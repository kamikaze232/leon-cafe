
-- DATABASE: leon_cafe


-- 1. Buat database
CREATE DATABASE IF NOT EXISTS leon_cafe;
USE leon_cafe;

-- 2. Tabel users (menyimpan admin & pelanggan)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pelanggan') DEFAULT 'pelanggan',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel categories (kategori menu)
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel menu (produk kafe)
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT,
    nama_menu VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 5. Data awal: 1 admin & beberapa kategori
INSERT INTO users (username, password, role) VALUES
('admin', 'admin123', 'admin'),
('pelanggan', 'pelanggan123', 'pelanggan');

INSERT INTO categories (nama_kategori) VALUES
('Makanan'),
('Minuman'),
('Dessert'),
('Snack');
