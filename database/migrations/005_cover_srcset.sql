-- srcset de las imágenes destacadas (tamaños que WordPress dejó en S3).

ALTER TABLE posts ADD COLUMN cover_srcset TEXT NULL AFTER cover_height;
ALTER TABLE products ADD COLUMN cover_srcset TEXT NULL AFTER cover_height;
