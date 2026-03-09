<?php
// ============================================
// DASHBOARD PELANGGAN - Leon Cafe
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Semua logika (ambil menu, filter kategori) ada di MenuController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "controllers/MenuController.php";
use Controllers\MenuController;

$controller = new MenuController();
$result = $controller->index(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$menus        = $result['menus'];
$categories   = $result['categories'];
$activeFilter = $result['activeFilter'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leon Cafe - Sip & Savor Life</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<!-- ========== NAVBAR ========== -->
<nav class="navbar">
    <a href="index.php" class="nav-logo">
        ☕ Leon Cafe
    </a>
    <ul class="nav-links">
        <li><a href="#menu" class="active">Menu</a></li>
        <?php if(isset($_SESSION['username'])): ?>
            <!-- Jika user sudah login, tampilkan nama + tombol logout -->
            <li>
                <span style="color: var(--text-secondary); font-size: 0.85rem;">
                    Halo, <strong style="color: var(--gold)"><?= $_SESSION['username'] ?></strong>
                </span>
            </li>
            <li>
                <a href="logout.php" class="btn btn-outline btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        <?php else: ?>
            <!-- Jika belum login, tampilkan tombol login -->
            <li>
                <a href="login.php" class="btn btn-gold btn-sm">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
<!-- ========== HERO SECTION ========== -->
<section class="hero">
    <div class="fade-slide-up">
        <h1>Selamat Datang di <span>Leon Cafe</span></h1>
        <p>Temukan cita rasa terbaik untuk menemani harimu. Dari kopi pilihan hingga hidangan lezat, semuanya ada di sini.</p>
        <a href="#menu" class="btn btn-gold">
            <i class="bi bi-arrow-down-circle"></i> Lihat Menu
        </a>
    </div>
</section>
<!-- ========== SECTION MENU ========== -->
<section class="section" id="menu">
    <h2 class="section-title">☕ Menu Kami</h2>
    <p class="section-subtitle">Pilih kategori favoritmu dan temukan menu yang sempurna</p>
    <!-- Filter Kategori (Tombol Pill) -->
    <div class="filter-bar">
        <!-- Tombol "Semua" -->
        <a href="index.php" 
           class="filter-btn <?= ($activeFilter == 'semua') ? 'active' : '' ?>">
            Semua
        </a>
        <!-- Loop kategori dari database -->
        <?php foreach($categories as $cat): ?>
            <a href="index.php?kategori=<?= $cat['id'] ?>" 
               class="filter-btn <?= ($activeFilter == $cat['id']) ? 'active' : '' ?>">
                <?= $cat['nama_kategori'] ?>
            </a>
        <?php endforeach; ?>
    </div>
    <!-- Grid Kartu Menu -->
    <div class="menu-grid">
        <?php if(count($menus) > 0): ?>
            <?php foreach($menus as $m): ?>
                <!-- Satu Kartu Menu -->
                <a href="detail.php?id=<?= $m['id'] ?>" class="menu-card glass" style="text-decoration:none;">
                    <div class="card-img-wrapper">
                        <img src="public/images/<?= $m['gambar'] ?>" 
                             alt="<?= $m['nama_menu'] ?>" 
                             class="card-img">
                    </div>
                    <div class="card-body">
                        <div class="card-category">
                            <?= $m['nama_kategori'] ?? 'Tanpa Kategori' ?>
                        </div>
                        <h3 class="card-title"><?= $m['nama_menu'] ?></h3>
                        <p class="card-desc"><?= $m['deskripsi'] ?></p>
                        <div class="card-footer">
                            <span class="card-price">Rp <?= number_format($m['harga'], 0, ',', '.') ?></span>
                            <span class="btn btn-outline btn-sm">Detail →</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center; color: var(--text-muted); grid-column: 1/-1; padding: 60px 0;">
                <i class="bi bi-emoji-frown" style="font-size: 2rem; display:block; margin-bottom:12px;"></i>
                Belum ada menu di kategori ini.
            </p>
        <?php endif; ?>
    </div>
</section>
<!-- ========== FOOTER ========== -->
<footer class="footer">
    &copy; 2026 Leon Cafe. All rights reserved. ☕
</footer>
</body>
</html>