<?php
// ============================================
// EDIT MENU - Leon Cafe (Admin)
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Logika proses edit + upload gambar ada di MenuController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "../../controllers/MenuController.php";
use Controllers\MenuController;

$controller = new MenuController();
$result = $controller->edit(); // Controller memproses, kembalikan data

// Deklarasi variabel
$data       = $result['data'];
$categories = $result['categories'];
$id         = $result['id'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Leon Cafe</title>
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
            <h2>✏️ Edit Menu</h2>
            <a href="dashboard.php" class="btn btn-outline btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="form-card glass fade-slide-up">
            <form method="POST" enctype="multipart/form-data">
                <!-- Nama Menu (sudah terisi data lama) -->
                <div class="form-group">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="nama_menu" class="form-input" 
                           value="<?= $data['nama_menu'] ?>" required>
                </div>
                <!-- Kategori -->
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="kategori_id" class="form-input" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" 
                                <?= ($cat['id'] == $data['kategori_id']) ? 'selected' : '' ?>>
                                <?= $cat['nama_kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Harga -->
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="harga" class="form-input" 
                           value="<?= $data['harga'] ?>" required>
                </div>
                <!-- Deskripsi -->
                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-input"><?= $data['deskripsi'] ?></textarea>
                </div>
                <!-- Gambar Saat Ini -->
                <div class="form-group">
                    <label class="form-label">Foto Saat Ini</label>
                    <img src="../../public/images/<?= $data['gambar'] ?>" 
                         style="width:150px; border-radius:10px; margin-bottom:12px;" 
                         alt="<?= $data['nama_menu'] ?>">
                </div>
                <!-- Upload Gambar Baru (opsional) -->
                <div class="form-group">
                    <label class="form-label">Ganti Foto (opsional)</label>
                    <div class="upload-area">
                        <input type="file" name="gambar" accept="image/*">
                        <i class="bi bi-cloud-arrow-up" style="display:block;"></i>
                        <p>Klik untuk mengganti gambar</p>
                    </div>
                </div>
                <!-- Tombol -->
                <div style="display:flex; gap:12px;">
                    <button type="submit" class="btn btn-gold">
                        <i class="bi bi-check-lg"></i> Update Menu
                    </button>
                    <a href="dashboard.php" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>