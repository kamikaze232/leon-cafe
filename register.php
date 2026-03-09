<?php
// ============================================
// HALAMAN REGISTER - Leon Cafe
// ============================================
// - File ini hanya menampilkan TAMPILAN (View)
// - Semua logika proses register ada di AuthController
// - Controller memproses data, lalu mengembalikan variabel ke sini
// ============================================

// Panggil Controller untuk memproses logika
require_once "controllers/AuthController.php";
use Controllers\AuthController;

$controller = new AuthController();
$result = $controller->register(); // Controller memproses, kembalikan data

// Deklarasi variabel 
$success = $result['success'] ?? null;
$error   = $result['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Leon Cafe</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

<div class="auth-page">

    <div class="auth-card glass-strong">
        
        <!-- Logo -->
        <div class="logo">
            <div class="logo-icon">☕</div>
            <h1>Leon Cafe</h1>
            <p>Buat akun baru</p>
        </div>

        <!-- Pesan sukses -->
        <?php if(isset($success)): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- Pesan error -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Form Register -->
        <form method="POST">

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" 
                       placeholder="Pilih username..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" 
                       placeholder="Buat password..." required>
            </div>

            <button type="submit" class="btn btn-gold">
                <i class="bi bi-person-plus"></i> Daftar
            </button>

        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </div>

    </div>

</div>

</body>
</html>