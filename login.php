<?php
// ============================================
// HALAMAN LOGIN - Leon Cafe
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Semua logika proses login ada di AuthController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "controllers/AuthController.php";
use Controllers\AuthController;

$controller = new AuthController();
$result = $controller->login(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$error = $result['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Leon Cafe</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<!-- Halaman Login: Layout -->
<div class="auth-page">

    <!-- Kartu Login (efek glassmorphism) -->
    <div class="auth-card glass-strong">
        
        <!-- Logo -->
        <div class="logo">
            <div class="logo-icon">☕</div>
            <h1>Leon Cafe</h1>
            <p>Sip & Savor Life</p>
        </div>

        <!-- Pesan error jika login gagal -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form method="POST">

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" 
                       placeholder="Masukkan username..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" 
                       placeholder="Masukkan password..." required>
            </div>

            <button type="submit" class="btn btn-gold">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>

        </form>

        <!-- Link ke halaman Register -->
        <div class="auth-footer">
            Belum punya akun? <a href="register.php">Daftar di sini</a>
        </div>

    </div>

</div>

</body>
</html>