<?php
// ============================================
// DASHBOARD CONTROLLER - Leon Cafe
// ============================================
// - Controller ini menangani logika halaman Dashboard Admin
// - Mengambil statistik (total menu, kategori, user)
// - Mengambil daftar menu untuk tabel
// ============================================

namespace Controllers;

// Muat file-file yang dibutuhkan (Model)
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Model.php";
require_once __DIR__ . "/../models/CrudInterface.php";
require_once __DIR__ . "/../models/Menu.php";
require_once __DIR__ . "/../models/Category.php";
require_once __DIR__ . "/../models/User.php";

use Models\Menu;
use Models\Category;
use Models\User;

class DashboardController {

    private $menuModel;
    private $categoryModel;
    private $userModel;

    // Constructor: membuat semua objek Model yang dibutuhkan
    public function __construct(){
        $this->menuModel = new Menu();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    // ==========================================
    // INDEX: Halaman Utama Dashboard
    // ==========================================
    // Fungsi ini:
    // 1. Cek apakah user adalah admin
    // 2. Ambil semua data statistik
    // 3. Ambil daftar menu untuk tabel
    // 4. Kembalikan semua data ke view
    public function index(){
        $this->checkAdmin();

        // Ambil data untuk statistik dan tabel
        $menus = $this->menuModel->read();
        $totalMenu = $this->menuModel->countAll();
        $totalKategori = $this->categoryModel->countAll();
        $totalUser = $this->userModel->countAll();

        // Kembalikan data ke view
        return [
            'menus'         => $menus,
            'totalMenu'     => $totalMenu,
            'totalKategori' => $totalKategori,
            'totalUser'     => $totalUser
        ];
    }

    // ==========================================
    // HELPER: Cek apakah user adalah Admin
    // ==========================================
    private function checkAdmin(){
        // session_start() yang aman — cek dulu apakah session sudah aktif
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Anti-cache: agar browser tidak menyimpan halaman ini
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Proteksi: hanya admin yang boleh masuk
        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
            header("Location: ../../login.php");
            exit();
        }
    }
}
