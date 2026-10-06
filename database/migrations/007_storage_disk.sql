-- Dónde está cada archivo de producto: "local" (storage/downloads) o "s3" (bucket privado, URL firmada).
ALTER TABLE product_files ADD COLUMN storage_disk VARCHAR(10) NOT NULL DEFAULT 'local' AFTER storage_path;
