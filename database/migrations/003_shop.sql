-- Tienda: familias, productos (fila única + traducciones), imágenes, archivos, packs y lista de espera.

CREATE TABLE product_families (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(60) NOT NULL,
    audience ENUM('oficina','docente','concurso') NOT NULL DEFAULT 'oficina',
    sort SMALLINT NOT NULL DEFAULT 0,
    UNIQUE KEY uq_family_key (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_family_translations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    family_id INT UNSIGNED NOT NULL,
    locale CHAR(2) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    name VARCHAR(190) NOT NULL,
    description_html TEXT NULL,
    needs_review TINYINT(1) NOT NULL DEFAULT 0,
    UNIQUE KEY uq_famtr (family_id, locale),
    UNIQUE KEY uq_famtr_slug (locale, slug),
    CONSTRAINT fk_famtr_family FOREIGN KEY (family_id) REFERENCES product_families(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    wp_id INT UNSIGNED NULL,
    sku VARCHAR(60) NULL,
    family_id INT UNSIGNED NULL,
    audience ENUM('oficina','docente','concurso') NOT NULL DEFAULT 'oficina',
    type ENUM('download','service','course','pack') NOT NULL DEFAULT 'download',
    price_usd DECIMAL(10,2) NOT NULL DEFAULT 0,
    price_cop INT UNSIGNED NOT NULL DEFAULT 0,
    status ENUM('active','hidden','coming_soon') NOT NULL DEFAULT 'active',
    featured TINYINT(1) NOT NULL DEFAULT 0,
    cover_url VARCHAR(500) NULL,
    cover_alt VARCHAR(255) NULL,
    cover_width SMALLINT UNSIGNED NULL,
    cover_height SMALLINT UNSIGNED NULL,
    video_url VARCHAR(500) NULL,
    legacy_sales INT UNSIGNED NOT NULL DEFAULT 0,
    sales_count INT UNSIGNED NOT NULL DEFAULT 0,
    has_english_version TINYINT(1) NOT NULL DEFAULT 0,
    tutorial_post_id INT UNSIGNED NULL,
    sort SMALLINT NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_products_wp (wp_id),
    KEY idx_products_status (status, audience),
    KEY idx_products_family (family_id),
    CONSTRAINT fk_products_family FOREIGN KEY (family_id) REFERENCES product_families(id) ON DELETE SET NULL,
    CONSTRAINT fk_products_tutorial FOREIGN KEY (tutorial_post_id) REFERENCES posts(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_translations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    locale CHAR(2) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    title VARCHAR(255) NOT NULL,
    short_html TEXT NULL,
    description_html MEDIUMTEXT NULL,
    includes_html TEXT NULL,
    requirements TEXT NULL,
    license_text TEXT NULL,
    faq_json JSON NULL,
    search_text MEDIUMTEXT NULL,
    seo_title VARCHAR(190) NULL,
    seo_description VARCHAR(320) NULL,
    needs_review TINYINT(1) NOT NULL DEFAULT 0,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_prodtr (product_id, locale),
    UNIQUE KEY uq_prodtr_slug (locale, slug),
    FULLTEXT KEY ft_prodtr (title, search_text),
    CONSTRAINT fk_prodtr_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE posts ADD CONSTRAINT fk_posts_product FOREIGN KEY (related_product_id) REFERENCES products(id) ON DELETE SET NULL;

CREATE TABLE product_images (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    url VARCHAR(500) NOT NULL,
    alt VARCHAR(255) NULL,
    width SMALLINT UNSIGNED NULL,
    height SMALLINT UNSIGNED NULL,
    sort SMALLINT NOT NULL DEFAULT 0,
    KEY idx_pimg_product (product_id, sort),
    CONSTRAINT fk_pimg_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE product_files (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    label VARCHAR(190) NOT NULL,
    source_url VARCHAR(500) NULL,
    storage_path VARCHAR(255) NULL,
    version VARCHAR(40) NULL,
    bytes BIGINT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_pfile_product (product_id),
    CONSTRAINT fk_pfile_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pack_items (
    pack_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (pack_id, product_id),
    CONSTRAINT fk_pack_pack FOREIGN KEY (pack_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT fk_pack_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE waitlist (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    email VARCHAR(190) NOT NULL,
    locale CHAR(2) NOT NULL DEFAULT 'es',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_waitlist (product_id, email),
    CONSTRAINT fk_waitlist_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
