<?php
// ============================================
// DASHBOARD ADMIN - Leon Cafe
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Semua logika (cek admin, ambil statistik) ada di DashboardController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "../../controllers/DashboardController.php";
use Controllers\DashboardController;

$controller = new DashboardController();
$result = $controller->index(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$menus         = $result['menus'];
$totalMenu     = $result['totalMenu'];
$totalKategori = $result['totalKategori'];
$totalUser     = $result['totalUser'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Leon Cafe</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="admin-layout">
    <!-- ========== SIDEBAR ========== -->
    <aside class="sidebar">
        <div class="sidebar-logo">☕ Leon Cafe</div>
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php" class="active">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="kategori.php">
                    <i class="bi bi-folder"></i> Kategori
                </a>
            </li>
            <li>
                <a href="menu.php">
                    <i class="bi bi-cup-hot"></i> Menu
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <ul class="sidebar-menu">
                <li>
                    <a href="../../logout.php" style="color: var(--danger);">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <!-- ========== MAIN CONTENT ========== -->
    <main class="admin-content">
        <!-- Header -->
        <div class="admin-header">
            <h2>📊 Dashboard</h2>
            <span style="color: var(--text-muted); font-size: 0.9rem;">
                Halo, <strong style="color: var(--gold);"><?= $_SESSION['username'] ?></strong>
            </span>
        </div>
        <!-- Stat Cards (Statistik) -->
        <div class="stat-grid">
            <!-- Total Menu -->
            <div class="stat-card glass">
                <div class="stat-icon gold">
                    <i class="bi bi-cup-hot"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $totalMenu ?></div>
                    <div class="stat-label">Total Menu</div>
                </div>
            </div>
            <!-- Total Kategori -->
            <div class="stat-card glass">
                <div class="stat-icon blue">
                    <i class="bi bi-folder"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $totalKategori ?></div>
                    <div class="stat-label">Total Kategori</div>
                </div>
            </div>
            <!-- Total User -->
            <div class="stat-card glass">
                <div class="stat-icon green">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="stat-number"><?= $totalUser ?></div>
                    <div class="stat-label">Total User</div>
                </div>
            </div>
        </div>
        <!-- Tabel Menu Terbaru -->
        <div class="table-wrapper glass">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h3 style="font-size:1.1rem;">📋 Daftar Menu Terbaru</h3>
                <a href="tambah_menu.php" class="btn btn-gold btn-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Menu
                </a>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($menus) > 0): ?>
                        <?php foreach($menus as $m): ?>
                        <tr>
                            <td>
                                <img src="../../public/images/<?= $m['gambar'] ?>" 
                                     class="menu-thumb" alt="<?= $m['nama_menu'] ?>">
                            </td>
                            <td style="font-weight:600; color: var(--text-primary);">
                                <?= $m['nama_menu'] ?>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    <?= $m['nama_kategori'] ?? '-' ?>
                                </span>
                            </td>
                            <td style="color: var(--gold);">
                                Rp <?= number_format($m['harga'], 0, ',', '.') ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="edit_menu.php?id=<?= $m['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="hapus_menu.php?id=<?= $m['id'] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color: var(--text-muted);">
                                Belum ada menu. Tambah menu pertamamu!
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>