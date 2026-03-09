<?php
// ============================================
// MANAJEMEN KATEGORI - Leon Cafe (Admin)
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Semua logika CRUD kategori ada di CategoryController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "../../controllers/CategoryController.php";
use Controllers\CategoryController;

$controller = new CategoryController();
$result = $controller->index(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$categories = $result['categories'];
$editData   = $result['editData'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - Leon Cafe</title>
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
            <li><a href="kategori.php" class="active"><i class="bi bi-folder"></i> Kategori</a></li>
            <li><a href="menu.php"><i class="bi bi-cup-hot"></i> Menu</a></li>
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
            <h2>📂 Manajemen Kategori</h2>
        </div>
        <!-- Form Tambah / Edit Kategori -->
        <div class="glass" style="padding:24px; margin-bottom:24px;">
            <form method="POST" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
                
                <?php if($editData): ?>
                    <!-- Mode EDIT -->
                    <input type="hidden" name="edit_id" value="<?= $editData['id'] ?>">
                    <div class="form-group" style="flex:1; min-width:200px; margin-bottom:0;">
                        <label class="form-label">Edit Kategori</label>
                        <input type="text" name="nama_kategori" class="form-input" 
                               value="<?= $editData['nama_kategori'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-check-lg"></i> Update
                    </button>
                    <a href="kategori.php" class="btn btn-outline">Batal</a>
                <?php else: ?>
                    <!-- Mode TAMBAH -->
                    <div class="form-group" style="flex:1; min-width:200px; margin-bottom:0;">
                        <label class="form-label">Tambah Kategori Baru</label>
                        <input type="text" name="nama_kategori" class="form-input" 
                               placeholder="Contoh: Makanan, Minuman..." required>
                    </div>
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
                <?php endif; ?>
            </form>
        </div>
        <!-- Tabel Kategori -->
        <div class="table-wrapper glass">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($categories) > 0): ?>
                        <?php $no = 1; foreach($categories as $cat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td style="font-weight:600; color: var(--text-primary);">
                                <?= $cat['nama_kategori'] ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="kategori.php?action=edit&id=<?= $cat['id'] ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="kategori.php?action=delete&id=<?= $cat['id'] ?>" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align:center; padding:40px; color: var(--text-muted);">
                                Belum ada kategori. Tambahkan di atas!
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