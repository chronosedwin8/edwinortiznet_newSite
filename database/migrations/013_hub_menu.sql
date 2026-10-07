-- Secciones (hubs) visibles en el menú principal y en las pestañas de la portada; antes estaban fijas en el código.
ALTER TABLE hubs ADD COLUMN in_menu TINYINT(1) NOT NULL DEFAULT 0 AFTER sort;
UPDATE hubs SET in_menu = 1 WHERE `key` IN ('excel', 'ia-para-docentes', 'concurso-docente');
