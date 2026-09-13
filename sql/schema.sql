-- =============================================================
-- StockWise Retail Solutions - Database Schema
-- ICT726 Assignment 4 - Dynamic Website
-- =============================================================
-- Import this file into phpMyAdmin / MySQL before running the site:
--   mysql -u root -p < schema.sql
-- =============================================================

CREATE DATABASE IF NOT EXISTS stockwise_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE stockwise_db;

-- -------------------------------------------------------------
-- users: registered demo-portal accounts with role based access
-- -------------------------------------------------------------
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    full_name     VARCHAR(100)  NOT NULL,
    email         VARCHAR(150)  NOT NULL UNIQUE,
    password_hash VARCHAR(255)  NOT NULL,
    role          ENUM('admin','staff','viewer') NOT NULL DEFAULT 'viewer',
    status        ENUM('active','disabled') NOT NULL DEFAULT 'active',
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- categories: product groupings
-- -------------------------------------------------------------
CREATE TABLE categories (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    name  VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- products: the inventory items themselves
-- -------------------------------------------------------------
CREATE TABLE products (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    sku            VARCHAR(40)  NOT NULL UNIQUE,
    name           VARCHAR(150) NOT NULL,
    category_id    INT NULL,
    description    TEXT NULL,
    price          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    quantity       INT NOT NULL DEFAULT 0,
    reorder_level  INT NOT NULL DEFAULT 5,
    image_url      VARCHAR(255) NULL,
    created_by     INT NULL,
    created_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    CONSTRAINT fk_products_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- stock_movements: audit trail of stock in/out adjustments
-- -------------------------------------------------------------
CREATE TABLE stock_movements (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    product_id    INT NOT NULL,
    user_id       INT NULL,
    movement_type ENUM('in','out') NOT NULL,
    quantity      INT NOT NULL,
    note          VARCHAR(255) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_movement_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    CONSTRAINT fk_movement_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- -------------------------------------------------------------
-- contact_messages: submissions from the public Contact Us form
-- -------------------------------------------------------------
CREATE TABLE contact_messages (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL,
    phone       VARCHAR(30)  NULL,
    reason      VARCHAR(30)  NOT NULL,
    message     TEXT NOT NULL,
    is_read     TINYINT(1) NOT NULL DEFAULT 0,
    created_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================================================
-- Seed data
-- =============================================================

-- Demo accounts (password for ALL demo accounts is: Passw0rd!)
-- Hashes generated with PHP password_hash() using PASSWORD_DEFAULT (bcrypt).
INSERT INTO users (full_name, email, password_hash, role) VALUES
('Alex Admin',  'admin@stockwise.example',  '$2y$10$TRY0r9A/eCqvl1svYi31GezGXCFxj8No9bYfjwDBkEKt1L4rfHFRO', 'admin'),
('Sam Staff',   'staff@stockwise.example',  '$2y$10$TRY0r9A/eCqvl1svYi31GezGXCFxj8No9bYfjwDBkEKt1L4rfHFRO', 'staff'),
('Val Viewer',  'viewer@stockwise.example', '$2y$10$TRY0r9A/eCqvl1svYi31GezGXCFxj8No9bYfjwDBkEKt1L4rfHFRO', 'viewer');

INSERT INTO categories (name) VALUES
('Barcode Scanners'), ('POS Hardware'), ('Packaging Supplies'), ('Store Fixtures');

INSERT INTO products (sku, name, category_id, description, price, quantity, reorder_level, image_url, created_by) VALUES
('BC-1001', 'Handheld 2D Barcode Scanner', 1, 'Wireless handheld scanner compatible with all major POS systems.', 89.99, 42, 10, 'https://loremflickr.com/500/350/barcode,scanner', 1),
('POS-2004', 'Receipt Printer 80mm', 2, 'Fast thermal receipt printer with USB and network ports.', 129.50, 15, 5, 'https://loremflickr.com/500/350/printer,receipt', 1),
('PKG-3050', 'Kraft Paper Bags (Pack of 100)', 3, 'Eco-friendly kraft paper carry bags for retail checkout.', 18.75, 6, 20, 'https://loremflickr.com/500/350/paper,bags', 2),
('FIX-4020', 'Adjustable Shelving Unit', 4, 'Steel adjustable shelving unit for backroom or showroom storage.', 210.00, 8, 3, 'https://loremflickr.com/500/350/warehouse,shelves', 2),
('BC-1002', 'Bluetooth Barcode Scanner Ring', 1, 'Wearable ring-style scanner for fast pick-and-pack workflows.', 149.00, 3, 5, 'https://loremflickr.com/500/350/warehouse,scanner', 1);

INSERT INTO stock_movements (product_id, user_id, movement_type, quantity, note) VALUES
(1, 2, 'in', 50, 'Initial stock intake from supplier'),
(1, 2, 'out', 8, 'Sold to Grant''s Corner Store'),
(3, 2, 'out', 14, 'Sold to Northline Hardware'),
(5, 1, 'in', 5, 'Initial stock intake');
