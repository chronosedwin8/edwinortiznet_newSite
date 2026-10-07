-- Generador de exámenes con IA: perfil docente (institución, logo, términos), planes mensuales
-- (suscripciones acumulables de 30 días), exámenes generados y registro de cada llamada a la IA.
-- El cupo se descuenta en exam_subscriptions (exams_used) y en exams (ai_questions): borrar un examen
-- no devuelve nada. Compatible con MariaDB 10.6 y MySQL 8.

CREATE TABLE exam_profiles (
    customer_id INT UNSIGNED NOT NULL PRIMARY KEY,
    institution VARCHAR(190) NULL,
    teacher VARCHAR(120) NULL,
    logo_key VARCHAR(255) NULL,
    logo_disk VARCHAR(10) NULL,
    terms_accepted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_examprof_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE exam_subscriptions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    order_id INT UNSIGNED NULL,
    order_item_id INT UNSIGNED NULL,
    sku VARCHAR(60) NOT NULL,
    exams SMALLINT UNSIGNED NOT NULL,
    exams_used SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    max_versions TINYINT UNSIGNED NOT NULL,
    max_questions SMALLINT UNSIGNED NOT NULL,
    ai_extra SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    refunds_used TINYINT UNSIGNED NOT NULL DEFAULT 0,
    starts_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    revoked_at DATETIME NULL,
    note VARCHAR(190) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_examsub_item (order_item_id),
    KEY idx_examsub_customer (customer_id, expires_at),
    KEY idx_examsub_order (order_id),
    CONSTRAINT fk_examsub_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_examsub_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    CONSTRAINT fk_examsub_item FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE exams (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(32) NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    subscription_id INT UNSIGNED NULL,
    status ENUM('pending','done','error') NOT NULL DEFAULT 'pending',
    title VARCHAR(190) NULL,
    subject VARCHAR(40) NOT NULL,
    grade VARCHAR(20) NOT NULL,
    mode ENUM('distintas','barajar') NOT NULL DEFAULT 'barajar',
    versions TINYINT UNSIGNED NOT NULL DEFAULT 1,
    questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    ai_questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    ai_requests TINYINT UNSIGNED NOT NULL DEFAULT 0,
    input_json MEDIUMTEXT NULL,
    content_json MEDIUMTEXT NULL,
    header_json TEXT NULL,
    progress TINYINT UNSIGNED NOT NULL DEFAULT 0,
    model VARCHAR(60) NULL,
    prompt_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    output_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    error VARCHAR(255) NULL,
    edited_at DATETIME NULL,
    deleted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_exam_uuid (uuid),
    KEY idx_exam_customer (customer_id, deleted_at, created_at),
    KEY idx_exam_status (status, created_at),
    CONSTRAINT fk_exam_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_exam_subscription FOREIGN KEY (subscription_id) REFERENCES exam_subscriptions(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cada llamada a la IA (generación, plan, preguntas adicionales o reemplazo): costos y límites.
CREATE TABLE exam_ai_calls (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    exam_id INT UNSIGNED NULL,
    kind VARCHAR(12) NOT NULL,
    questions SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    model VARCHAR(60) NULL,
    prompt_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    output_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    ok TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_examcall_customer (customer_id, created_at),
    KEY idx_examcall_exam (exam_id),
    CONSTRAINT fk_examcall_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_examcall_exam FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
