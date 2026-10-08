-- Texto alternativo en inglés de las imágenes de la galería del producto (NULL = se usa el de español).
ALTER TABLE product_images ADD COLUMN alt_en VARCHAR(255) NULL AFTER alt;
