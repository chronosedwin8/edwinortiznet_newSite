-- Encuestas cortas dentro de los artículos ({{encuesta:clave}}). Una respuesta por visitante y pregunta (se puede cambiar).
-- El visitante se guarda como HMAC con APP_KEY (nunca la cookie ni la IP). Las preguntas viven en resources/polls/<clave>.php;
-- aquí solo el índice de la pregunta y de la opción elegida, así que cambiar un texto no invalida los votos.

CREATE TABLE poll_votes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    poll_key VARCHAR(80) NOT NULL,
    visitor CHAR(64) NOT NULL,
    question TINYINT UNSIGNED NOT NULL,
    answer TINYINT UNSIGNED NOT NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_poll_vote (poll_key, visitor, question),
    KEY idx_poll_counts (poll_key, question, answer)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
