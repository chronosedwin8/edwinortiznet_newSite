-- PIAR con IA: perfil docente (institución, logo, aceptación de términos), paquetes de créditos y planes generados.
-- Los PIAR nunca se borran (no hay función de borrar): el contenido de las pruebas se purga, el registro queda.

CREATE TABLE piar_profiles (
    customer_id INT UNSIGNED NOT NULL PRIMARY KEY,
    institution VARCHAR(190) NULL,
    city VARCHAR(120) NULL,
    logo_key VARCHAR(255) NULL,
    logo_disk VARCHAR(10) NULL,
    terms_accepted_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_piarprof_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE piar_packages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    order_id INT UNSIGNED NULL,
    order_item_id INT UNSIGNED NULL,
    sku VARCHAR(60) NOT NULL,
    credits SMALLINT UNSIGNED NOT NULL,
    used SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    starts_at DATETIME NOT NULL,
    expires_at DATETIME NOT NULL,
    revoked_at DATETIME NULL,
    note VARCHAR(190) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_piarpkg_item (order_item_id),
    KEY idx_piarpkg_customer (customer_id, expires_at),
    KEY idx_piarpkg_order (order_id),
    CONSTRAINT fk_piarpkg_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_piarpkg_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL,
    CONSTRAINT fk_piarpkg_item FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE piar_plans (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    uuid CHAR(32) NOT NULL,
    customer_id INT UNSIGNED NOT NULL,
    package_id INT UNSIGNED NULL,
    is_trial TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('pending','done','error') NOT NULL DEFAULT 'pending',
    student_alias VARCHAR(80) NULL,
    grade VARCHAR(20) NULL,
    input_json MEDIUMTEXT NULL,
    output_json MEDIUMTEXT NULL,
    model VARCHAR(60) NULL,
    prompt_tokens INT UNSIGNED NULL,
    output_tokens INT UNSIGNED NULL,
    error VARCHAR(255) NULL,
    ip_hash CHAR(64) NULL,
    purge_after DATETIME NULL,
    purged_at DATETIME NULL,
    edited_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_piarplan_uuid (uuid),
    KEY idx_piarplan_customer (customer_id, is_trial, status),
    KEY idx_piarplan_status (status, created_at),
    KEY idx_piarplan_purge (purge_after),
    KEY idx_piarplan_ip (ip_hash, created_at),
    CONSTRAINT fk_piarplan_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_piarplan_package FOREIGN KEY (package_id) REFERENCES piar_packages(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
