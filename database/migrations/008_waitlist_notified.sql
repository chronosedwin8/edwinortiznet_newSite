-- Lista de espera: cuándo se le avisó a cada correo que el producto ya está a la venta.
ALTER TABLE waitlist ADD COLUMN notified_at DATETIME NULL AFTER locale;
