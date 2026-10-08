-- Suscriptores con perfil (estado, intereses, origen y métricas) y boletín automático.
-- Compatible con MySQL 8 y MariaDB 10.6.
--
-- Decisión: UNA FILA POR CORREO. Antes había una fila por (correo, etiqueta); ahora los temas van en
-- `interests` (selección múltiple) y `tag` queda solo por compatibilidad (la etiqueta del primer registro).
-- Los duplicados de un mismo correo se fusionan: se conserva la fila con mejor estado
-- (activo > pendiente > baja > rebotado > spam) y se unen sus intereses.
-- `status` es ahora la fuente de verdad; confirmed_at / unsubscribed_at se siguen llenando.

ALTER TABLE subscribers
    ADD COLUMN status ENUM('pending','active','unsubscribed','bounced','spam') NOT NULL DEFAULT 'pending' AFTER tag,
    ADD COLUMN interests SET('docentes','tecnologia','excel','concurso') NOT NULL DEFAULT '' AFTER status,
    ADD COLUMN source_type ENUM('footer','home','article','hub','product','tool','checkout','account','waitlist','other') NOT NULL DEFAULT 'other' AFTER source,
    ADD COLUMN source_path VARCHAR(255) NULL AFTER source_type,
    ADD COLUMN source_title VARCHAR(255) NULL AFTER source_path,
    ADD COLUMN referrer VARCHAR(255) NULL AFTER source_title,
    ADD COLUMN utm_source VARCHAR(100) NULL AFTER referrer,
    ADD COLUMN utm_medium VARCHAR(100) NULL AFTER utm_source,
    ADD COLUMN utm_campaign VARCHAR(100) NULL AFTER utm_medium,
    ADD COLUMN ip_hash CHAR(64) NULL AFTER utm_campaign,
    ADD COLUMN confirmed_ip_hash CHAR(64) NULL AFTER confirmed_at,
    ADD COLUMN confirm_sent_at DATETIME NULL AFTER confirmed_ip_hash,
    ADD COLUMN paused_until DATETIME NULL AFTER unsubscribed_at,
    ADD COLUMN unsubscribed_reason VARCHAR(255) NULL AFTER paused_until,
    ADD COLUMN last_sent_at DATETIME NULL,
    ADD COLUMN sends_count INT UNSIGNED NOT NULL DEFAULT 0,
    ADD COLUMN last_open_at DATETIME NULL,
    ADD COLUMN opens_count INT UNSIGNED NOT NULL DEFAULT 0,
    ADD COLUMN last_click_at DATETIME NULL,
    ADD COLUMN clicks_count INT UNSIGNED NOT NULL DEFAULT 0,
    ADD COLUMN updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Estado a partir de las fechas existentes.
UPDATE subscribers SET status = CASE
    WHEN unsubscribed_at IS NOT NULL THEN 'unsubscribed'
    WHEN confirmed_at IS NOT NULL THEN 'active'
    ELSE 'pending' END;

-- Ataque de "bombardeo de suscripciones" del 8 de octubre de 2026: 53 correos ajenos registrados desde
-- IP de centros de datos con el formulario de la portada, a los que ya se les había puesto unsubscribed_at.
UPDATE subscribers
SET status = 'spam', unsubscribed_reason = 'Ataque de suscripciones con correos ajenos (2026-10-08)'
WHERE source = 'home'
  AND unsubscribed_at IS NOT NULL
  AND created_at >= '2026-10-08 00:00:00' AND created_at < '2026-10-09 00:00:00';

-- Intereses según la etiqueta del formulario (hub) de cada registro.
UPDATE subscribers SET interests = CASE tag
    WHEN 'excel' THEN 'excel'
    WHEN 'ia-para-docentes' THEN 'docentes,tecnologia'
    WHEN 'concurso-docente' THEN 'concurso'
    WHEN 'concurso' THEN 'concurso'
    ELSE '' END;

-- Origen a partir del texto anterior ("home", "footer", "article:{slug}", "hub:{key}").
UPDATE subscribers SET source_type = 'home', source_path = IF(locale = 'en', '/en/', '/') WHERE source = 'home';
UPDATE subscribers SET source_type = 'footer' WHERE source = 'footer';
UPDATE subscribers
SET source_type = 'article', source_path = CONCAT(IF(locale = 'en', '/en/', '/'), SUBSTRING(source, 9), '/')
WHERE source LIKE 'article:%';
UPDATE subscribers s
JOIN hubs h ON h.`key` = SUBSTRING(s.source, 5)
LEFT JOIN hub_translations ht ON ht.hub_id = h.id AND ht.locale = s.locale
SET s.source_type = 'hub',
    s.source_path = IF(ht.slug IS NULL, NULL, CONCAT(IF(s.locale = 'en', '/en/', '/'), ht.slug, '/')),
    s.source_title = ht.title
WHERE s.source LIKE 'hub:%';

-- Una fila por correo: une los intereses en la fila que se conserva (mejor estado; a igualdad, la más antigua).
UPDATE subscribers s
JOIN (
    SELECT email,
           CAST(SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY FIELD(status, 'active', 'pending', 'unsubscribed', 'bounced', 'spam'), id SEPARATOR ','), ',', 1) AS UNSIGNED) AS keep_id,
           BIT_OR(interests + 0) AS bits,
           MIN(created_at) AS first_at
    FROM subscribers
    GROUP BY email
    HAVING COUNT(*) > 1
) d ON s.id = d.keep_id
SET s.interests = d.bits, s.created_at = d.first_at;

DELETE s FROM subscribers s
JOIN (
    SELECT email,
           CAST(SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY FIELD(status, 'active', 'pending', 'unsubscribed', 'bounced', 'spam'), id SEPARATOR ','), ',', 1) AS UNSIGNED) AS keep_id
    FROM subscribers
    GROUP BY email
    HAVING COUNT(*) > 1
) d ON d.email = s.email AND s.id <> d.keep_id;

ALTER TABLE subscribers
    DROP INDEX uq_subscriber,
    ADD UNIQUE KEY uq_subscriber_email (email),
    ADD KEY idx_subscribers_status (status, created_at),
    ADD KEY idx_subscribers_ip (ip_hash);

-- Ediciones del boletín. Una sola "abierta" (scheduled/sending) a la vez.
CREATE TABLE newsletter_issues (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    issue_key VARCHAR(40) NOT NULL,              -- boletin-2026-10-13 (también es el utm_campaign)
    status ENUM('scheduled','sending','sent','cancelled','failed') NOT NULL DEFAULT 'scheduled',
    mode ENUM('auto','approval') NOT NULL DEFAULT 'auto',
    scheduled_for DATETIME NOT NULL,              -- UTC
    since_at DATETIME NULL,                       -- artículos publicados desde (UTC)
    subject VARCHAR(255) NULL,                    -- asunto general (con subject_manual = 1 se usa para todos)
    subject_manual TINYINT(1) NOT NULL DEFAULT 0,
    intro_es TEXT NULL,
    intro_en TEXT NULL,
    intro_source ENUM('ai','template','manual') NOT NULL DEFAULT 'template',
    ai_calls TINYINT UNSIGNED NOT NULL DEFAULT 0,
    content_json JSON NOT NULL,                   -- {"es": {"posts": [...], "offers": [...]}, "en": {...}}
    approved_at DATETIME NULL,
    preview_sent_at DATETIME NULL,
    started_at DATETIME NULL,
    finished_at DATETIME NULL,
    recipients INT UNSIGNED NOT NULL DEFAULT 0,
    created_by ENUM('auto','admin') NOT NULL DEFAULT 'auto',
    note VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_newsletter_issue (issue_key),
    KEY idx_newsletter_issue_status (status, scheduled_for)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Un envío por suscriptor y edición (UNIQUE: nunca dos veces la misma edición a la misma persona).
CREATE TABLE newsletter_sends (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    subscriber_id INT UNSIGNED NULL,
    email VARCHAR(190) NOT NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    status ENUM('queued','sending','sent','failed','skipped') NOT NULL DEFAULT 'queued',
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NULL,
    locked_at DATETIME NULL,
    error VARCHAR(500) NULL,
    subject VARCHAR(255) NULL,
    items_json JSON NULL,                         -- artículos y productos que recibió
    sent_at DATETIME NULL,
    opened_at DATETIME NULL,
    opens INT UNSIGNED NOT NULL DEFAULT 0,
    clicked_at DATETIME NULL,
    clicks INT UNSIGNED NOT NULL DEFAULT 0,
    unsubscribed_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_newsletter_send (issue_id, subscriber_id),
    KEY idx_newsletter_send_queue (issue_id, status, next_attempt_at),
    KEY idx_newsletter_send_subscriber (subscriber_id),
    CONSTRAINT fk_nsend_issue FOREIGN KEY (issue_id) REFERENCES newsletter_issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_nsend_subscriber FOREIGN KEY (subscriber_id) REFERENCES subscribers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Clics por enlace (para ver qué interesó en cada edición).
CREATE TABLE newsletter_clicks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    send_id INT UNSIGNED NOT NULL,
    url VARCHAR(600) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_newsletter_click_send (send_id),
    CONSTRAINT fk_nclick_send FOREIGN KEY (send_id) REFERENCES newsletter_sends(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
