-- Publicación programada: las entradas 'scheduled' no son públicas; el comando posts:publish-due
-- (cron cada 5 minutos) las pasa a 'published' cuando llega su published_at.
ALTER TABLE posts MODIFY status ENUM('published','draft','noindex','scheduled') NOT NULL DEFAULT 'published';
