<?php
// ============================================
// HALAMAN DAFTAR MENU - Leon Cafe (Admin)
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Logika ambil daftar menu ada di MenuController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "../../controllers/MenuController.php";
use Controllers\MenuController;

$controller = new MenuController();
$result = $controller->adminIndex(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$menus = $result['menus'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - Leon Cafe</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="admin-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">☕ Leon Cafe</div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="kategori.php"><i class="bi bi-folder"></i> Kategori</a></li>
            <li><a href="menu.php" class="active"><i class="bi bi-cup-hot"></i> Menu</a></li>
        </ul>
        <div class="sidebar-footer">
            <ul class="sidebar-menu">
                <li><a href="../../logout.php" style="color: var(--danger);"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </aside>
    <!-- MAIN CONTENT -->
    <main class="admin-content">
        <div class="admin-header">
            <h2>🍽️ Semua Menu</h2>
            <a href="tambah_menu.php" class="btn btn-gold btn-sm">
                <i class="bi bi-plus-lg"></i> Tambah Menu
            </a>
        </div>
        <div class="table-wrapper glass">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($menus) > 0): ?>
                        <?php $no = 1; foreach($menus as $m): ?>
                        <tr>
                            <td><?= $no++ ?></td>
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
                            <td style="color: var(--gold); font-weight:600;">
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
                            <td colspan="6" style="text-align:center; padding:40px; color: var(--text-muted);">
                                Belum ada menu.
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
