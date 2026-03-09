<?php
// ============================================
// LOGOUT - Leon Cafe
// ============================================
// - File ini hanya memanggil Controller
// - Semua logika logout (hapus session, cookie, dll) ada di AuthController
// ============================================

// Panggil Controller untuk memproses logout
require_once "controllers/AuthController.php";
use Controllers\AuthController;

$controller = new AuthController();
$controller->logout(); // Controller langsung proses dan redirect