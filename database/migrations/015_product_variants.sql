-- Variantes de producto (p. ej. la materia del Kit de IA para docentes).
-- product_files.variant: clave de la variante a la que pertenece el archivo (NULL = para todos los compradores).
-- order_items.variant / variant_label: la variante elegida al comprar; solo se entregan sus archivos.
ALTER TABLE product_files ADD COLUMN variant VARCHAR(40) NULL AFTER label;
ALTER TABLE product_files ADD KEY idx_pfile_variant (product_id, variant);
ALTER TABLE order_items ADD COLUMN variant VARCHAR(40) NULL AFTER product_id;
ALTER TABLE order_items ADD COLUMN variant_label VARCHAR(120) NULL AFTER variant;
