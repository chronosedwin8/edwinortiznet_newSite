-- PIAR: cada uso del asistente "Redactar con IA" en el editor (límite por cuenta y control de costos).
CREATE TABLE piar_assists (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    plan_id INT UNSIGNED NOT NULL,
    field VARCHAR(80) NOT NULL,
    action VARCHAR(20) NOT NULL,
    model VARCHAR(60) NULL,
    prompt_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    output_tokens INT UNSIGNED NOT NULL DEFAULT 0,
    ok TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_piar_assists_customer (customer_id, created_at),
    CONSTRAINT fk_piar_assists_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    CONSTRAINT fk_piar_assists_plan FOREIGN KEY (plan_id) REFERENCES piar_plans(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
