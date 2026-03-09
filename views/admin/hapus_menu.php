<?php
// ============================================
// HAPUS MENU - Leon Cafe (Admin)
// ============================================
// - File ini hanya memanggil Controller
// - Logika hapus menu ada di MenuController
// - Controller langsung proses hapus dan redirect ke dashboard
// ============================================

// Panggil Controller untuk memproses hapus
require_once "../../controllers/MenuController.php";
use Controllers\MenuController;

$controller = new MenuController();
$controller->destroy(); 