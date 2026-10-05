-- Pedidos, pagos, descargas, clientes, enlace mágico, suscriptores y contacto.

CREATE TABLE customers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL,
    name VARCHAR(190) NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_customer_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE orders (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(40) NOT NULL,
    token CHAR(64) NOT NULL,
    customer_id INT UNSIGNED NULL,
    email VARCHAR(190) NOT NULL,
    name VARCHAR(190) NOT NULL,
    document VARCHAR(40) NULL,
    phone VARCHAR(40) NULL,
    locale ENUM('es','en') NOT NULL DEFAULT 'es',
    currency ENUM('COP','USD') NOT NULL DEFAULT 'COP',
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('pending','approved','declined','voided','refunded','error') NOT NULL DEFAULT 'pending',
    gateway ENUM('mercadopago','wompi','paypal') NOT NULL,
    gateway_id VARCHAR(120) NULL,
    gateway_status VARCHAR(60) NULL,
    paid_at DATETIME NULL,
    terms_accepted_at DATETIME NULL,
    ip VARCHAR(45) NULL,
    last_checked_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_orders_reference (reference),
    UNIQUE KEY uq_orders_token (token),
    KEY idx_orders_status (status, created_at),
    KEY idx_orders_email (email),
    KEY idx_orders_gateway (gateway, gateway_id),
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NULL,
    title VARCHAR(255) NOT NULL,
    unit_price DECIMAL(12,2) NOT NULL,
    quantity SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    total DECIMAL(12,2) NOT NULL,
    KEY idx_oitems_order (order_id),
    CONSTRAINT fk_oitems_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    CONSTRAINT fk_oitems_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE payment_events (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    gateway ENUM('mercadopago','wompi','paypal') NOT NULL,
    event_id VARCHAR(190) NOT NULL,
    order_id INT UNSIGNED NULL,
    event_type VARCHAR(80) NULL,
    payload JSON NULL,
    signature_ok TINYINT(1) NOT NULL DEFAULT 0,
    result VARCHAR(40) NULL,
    processed_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_payment_event (gateway, event_id),
    KEY idx_pevents_order (order_id),
    CONSTRAINT fk_pevents_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE download_grants (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_item_id INT UNSIGNED NOT NULL,
    product_file_id INT UNSIGNED NULL,
    token CHAR(64) NOT NULL,
    max_downloads SMALLINT UNSIGNED NOT NULL DEFAULT 5,
    downloads SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    expires_at DATETIME NOT NULL,
    revoked_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_grant_token (token),
    KEY idx_grant_item (order_item_id),
    CONSTRAINT fk_grant_item FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE,
    CONSTRAINT fk_grant_file FOREIGN KEY (product_file_id) REFERENCES product_files(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE download_log (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    grant_id INT UNSIGNED NOT NULL,
    ip VARCHAR(45) NULL,
    user_agent VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_dlog_grant (grant_id),
    CONSTRAINT fk_dlog_grant FOREIGN KEY (grant_id) REFERENCES download_grants(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE login_tokens (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    token_hash CHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    used_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_login_token (token_hash),
    CONSTRAINT fk_login_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE subscribers (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    source VARCHAR(190) NULL,
    tag VARCHAR(60) NOT NULL DEFAULT 'general',
    token CHAR(64) NOT NULL,
    confirmed_at DATETIME NULL,
    unsubscribed_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_subscriber (email, tag),
    UNIQUE KEY uq_subscriber_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE contact_messages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(190) NULL,
    message TEXT NOT NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    ip VARCHAR(45) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
