-- Reacciones de los lectores en los artículos (una por visitante y entrada; se puede cambiar o quitar).
-- visitor = HMAC-SHA256 (con APP_KEY) del identificador aleatorio de la cookie eo_rx: la base nunca guarda el valor de la cookie.
-- Los conteos se calculan con GROUP BY sobre el índice (post_id, reaction), que los cubre sin leer filas.

CREATE TABLE post_reactions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    post_id INT UNSIGNED NOT NULL,
    visitor CHAR(64) NOT NULL,
    reaction ENUM('like','insightful','celebrate','love','thoughtful') NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_reaction_visitor (post_id, visitor),
    KEY idx_reaction_counts (post_id, reaction),
    CONSTRAINT fk_reaction_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Política de cookies: se documenta la cookie funcional de las reacciones (solo se crea al reaccionar).
UPDATE posts
SET content_html = REPLACE(content_html,
    '<li><strong>eo_cart:</strong> indica que tienes productos en el carrito.</li>',
    '<li><strong>eo_cart:</strong> indica que tienes productos en el carrito.</li>\n<li><strong>eo_rx:</strong> recuerda tu reacción en los artículos para que puedas cambiarla o quitarla. Es un identificador aleatorio que solo se crea cuando reaccionas y dura un año.</li>')
WHERE type = 'policy' AND locale = 'es' AND slug = 'cookies' AND content_html NOT LIKE '%eo_rx%';

UPDATE posts
SET content_html = REPLACE(content_html,
    '<li><strong>eo_cart:</strong> indicates that you have products in your cart.</li>',
    '<li><strong>eo_cart:</strong> indicates that you have products in your cart.</li>\n<li><strong>eo_rx:</strong> remembers your reaction to articles so you can change or remove it. It is a random identifier that is only created when you react and lasts one year.</li>')
WHERE type = 'policy' AND locale = 'en' AND slug = 'cookies' AND content_html NOT LIKE '%eo_rx%';
