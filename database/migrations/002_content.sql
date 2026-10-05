-- Contenido: hubs, categorías, entradas/páginas/políticas (multilingüe) y banco de preguntas.

CREATE TABLE hubs (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(60) NOT NULL,
    sort SMALLINT NOT NULL DEFAULT 0,
    pillar_post_id INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_hub_key (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE hub_translations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hub_id INT UNSIGNED NOT NULL,
    locale CHAR(2) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    title VARCHAR(190) NOT NULL,
    menu_title VARCHAR(80) NULL,
    intro_html MEDIUMTEXT NULL,
    faq_json JSON NULL,
    seo_title VARCHAR(190) NULL,
    seo_description VARCHAR(320) NULL,
    needs_review TINYINT(1) NOT NULL DEFAULT 0,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_hubtr (hub_id, locale),
    UNIQUE KEY uq_hubtr_slug (locale, slug),
    CONSTRAINT fk_hubtr_hub FOREIGN KEY (hub_id) REFERENCES hubs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    wp_slug VARCHAR(190) NOT NULL,
    hub_id INT UNSIGNED NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_cat_wp (wp_slug),
    CONSTRAINT fk_cat_hub FOREIGN KEY (hub_id) REFERENCES hubs(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE category_translations (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    locale CHAR(2) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    name VARCHAR(190) NOT NULL,
    needs_review TINYINT(1) NOT NULL DEFAULT 0,
    UNIQUE KEY uq_cattr (category_id, locale),
    UNIQUE KEY uq_cattr_slug (locale, slug),
    CONSTRAINT fk_cattr_cat FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE posts (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    wp_id INT UNSIGNED NULL,
    type ENUM('post','page','policy') NOT NULL DEFAULT 'post',
    locale CHAR(2) NOT NULL DEFAULT 'es',
    translation_group CHAR(36) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT NULL,
    content_html MEDIUMTEXT NULL,
    content_text MEDIUMTEXT NULL,
    notice_html TEXT NULL,
    cover_url VARCHAR(500) NULL,
    cover_alt VARCHAR(255) NULL,
    cover_width SMALLINT UNSIGNED NULL,
    cover_height SMALLINT UNSIGNED NULL,
    hub_id INT UNSIGNED NULL,
    related_product_id INT UNSIGNED NULL,
    status ENUM('published','draft','noindex') NOT NULL DEFAULT 'published',
    seo_title VARCHAR(190) NULL,
    seo_description VARCHAR(320) NULL,
    seo_auto TINYINT(1) NOT NULL DEFAULT 0,
    focus_keyword VARCHAR(190) NULL,
    canonical_url VARCHAR(500) NULL,
    no_ads TINYINT(1) NOT NULL DEFAULT 0,
    reading_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    needs_review TINYINT(1) NOT NULL DEFAULT 0,
    published_at DATETIME NULL,
    updated_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_posts_wp (wp_id),
    UNIQUE KEY uq_posts_slug (locale, slug),
    KEY idx_posts_group (translation_group),
    KEY idx_posts_list (locale, type, status, published_at),
    KEY idx_posts_hub (hub_id),
    FULLTEXT KEY ft_posts (title, excerpt, content_text),
    CONSTRAINT fk_posts_hub FOREIGN KEY (hub_id) REFERENCES hubs(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE post_category (
    post_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    is_primary TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (post_id, category_id),
    KEY idx_pc_cat (category_id),
    CONSTRAINT fk_pc_post FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    CONSTRAINT fk_pc_cat FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quiz_questions (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    area VARCHAR(120) NOT NULL,
    question TEXT NOT NULL,
    options_json JSON NOT NULL,
    correct_index TINYINT UNSIGNED NOT NULL,
    explanation TEXT NULL,
    is_demo TINYINT(1) NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    KEY idx_quiz_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
