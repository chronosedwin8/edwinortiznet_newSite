-- Publicación automática en redes sociales (Facebook e Instagram): cuentas conectadas,
-- canales (qué se publica, dónde y cuándo) y la cola/historial de publicaciones.
-- Compatible con MySQL 8 y MariaDB 10.6.

CREATE TABLE social_accounts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    network ENUM('fb','ig') NOT NULL,
    external_id VARCHAR(64) NOT NULL,
    name VARCHAR(190) NOT NULL,
    username VARCHAR(190) NULL,
    page_id VARCHAR(64) NULL,                 -- Instagram: página de Facebook vinculada (su token publica en IG)
    picture_url VARCHAR(1000) NULL,
    token_enc TEXT NULL,                      -- cifrado con libsodium (secretbox, clave derivada de APP_KEY)
    token_expires_at DATETIME NULL,           -- NULL = no vence (tokens de página obtenidos con un token de usuario de larga duración)
    status ENUM('active','reconnect','disabled') NOT NULL DEFAULT 'active',
    info_json JSON NULL,                      -- cuota de publicación y otros datos de la última comprobación
    last_check_at DATETIME NULL,
    last_error VARCHAR(500) NULL,
    alerted_at DATETIME NULL,                 -- último aviso por correo de "reconectar" (evita repetirlo en cada cron)
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_social_account (network, external_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE social_channels (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(40) NOT NULL,
    name VARCHAR(120) NOT NULL,
    fb_account_id INT UNSIGNED NULL,
    ig_account_id INT UNSIGNED NULL,
    schedule_json JSON NOT NULL,              -- {"days":[1..7 ISO], "time":"18:30", "tz":"America/Bogota"}
    content_json JSON NOT NULL,               -- {"types":[…], "hubs_include":[…], "hubs_exclude":[…], "audiences":[…], "skus":[…], "exclude_skus":[…], "tools":[…]}
    auto_approve TINYINT(1) NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_social_channel (`key`),
    CONSTRAINT fk_sch_fb FOREIGN KEY (fb_account_id) REFERENCES social_accounts(id) ON DELETE SET NULL,
    CONSTRAINT fk_sch_ig FOREIGN KEY (ig_account_id) REFERENCES social_accounts(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Una fila por red. Las filas de un mismo contenido y horario comparten group_key (una tarjeta en el panel).
CREATE TABLE social_posts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    group_key CHAR(20) NOT NULL,
    channel_id INT UNSIGNED NOT NULL,
    network ENUM('fb','ig') NOT NULL,
    account_id INT UNSIGNED NULL,
    content_type ENUM('post','page','product','tool') NOT NULL,
    content_id INT UNSIGNED NULL,             -- posts.id o products.id
    content_key VARCHAR(80) NOT NULL,         -- "post:12", "product:25", "tool:fundales" (para no repetir)
    title VARCHAR(255) NOT NULL,              -- copia del título al planificar
    link VARCHAR(600) NOT NULL,               -- con UTM de la red
    caption TEXT NULL,
    hashtags VARCHAR(1000) NULL,              -- separados por espacio, con #
    caption_source ENUM('ai','template','manual') NOT NULL DEFAULT 'template',
    image_path VARCHAR(255) NULL,             -- relativa al sitio (/social/… o /og/…)
    image_url VARCHAR(600) NULL,              -- absoluta (la que descarga Meta)
    scheduled_at DATETIME NOT NULL,           -- UTC
    status ENUM('draft','approved','publishing','published','failed','skipped') NOT NULL DEFAULT 'draft',
    container_id VARCHAR(64) NULL,            -- Instagram: contenedor creado y aún no publicado
    external_id VARCHAR(64) NULL,
    permalink VARCHAR(600) NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    next_attempt_at DATETIME NULL,
    locked_at DATETIME NULL,
    error VARCHAR(1000) NULL,
    created_by ENUM('planner','admin') NOT NULL DEFAULT 'planner',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    published_at DATETIME NULL,
    KEY idx_social_due (status, scheduled_at),
    KEY idx_social_group (group_key),
    KEY idx_social_content (channel_id, content_key, scheduled_at),
    CONSTRAINT fk_spost_channel FOREIGN KEY (channel_id) REFERENCES social_channels(id) ON DELETE CASCADE,
    CONSTRAINT fk_spost_account FOREIGN KEY (account_id) REFERENCES social_accounts(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
