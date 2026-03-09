<?php
// ============================================
// DETAIL MENU - Leon Cafe
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Logika ambil data menu ada di MenuController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "controllers/MenuController.php";
use Controllers\MenuController;

$controller = new MenuController();
$result = $controller->detail(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$data = $result['data'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['nama_menu'] ?> - Leon Cafe</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="nav-logo">☕ Leon Cafe</a>
    <ul class="nav-links">
        <li><a href="index.php">← Kembali ke Menu</a></li>
    </ul>
</nav>
<!-- DETAIL -->
<div class="detail-page fade-slide-up">
    <div class="detail-card glass">
        <img src="public/images/<?= $data['gambar'] ?>" alt="<?= $data['nama_menu'] ?>">
        <div class="detail-body">
            <span class="badge badge-gold" style="margin-bottom: 12px;">
                <?= $data['nama_kategori'] ?? 'Tanpa Kategori' ?>
            </span>
            <h1><?= $data['nama_menu'] ?></h1>
            <div class="price">Rp <?= number_format($data['harga'], 0, ',', '.') ?></div>
            <p class="desc"><?= $data['deskripsi'] ?></p>
            <a href="index.php" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
</body>
</html>