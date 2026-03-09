<?php
// ============================================
// CATEGORY CONTROLLER - Leon Cafe
// ============================================
// - Controller ini menangani semua logika terkait KATEGORI
// - Termasuk: tambah, edit, hapus, tampil semua kategori
// - Semua operasi CRUD ada di 1 controller ini
// ============================================

namespace Controllers;

// Muat file-file yang dibutuhkan (Model)
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Model.php";
require_once __DIR__ . "/../models/CrudInterface.php";
require_once __DIR__ . "/../models/Category.php";

use Models\Category;

class CategoryController {

    private $categoryModel;

    // Constructor: membuat objek Category saat controller dibuat
    public function __construct(){
        $this->categoryModel = new Category();
    }

    // ==========================================
    // INDEX: Tampil + Proses CRUD Kategori
    // ==========================================
    // Fungsi ini menangani semuanya di 1 halaman:
    // - GET ?action=delete → hapus kategori
    // - POST tanpa edit_id → tambah kategori baru
    // - POST dengan edit_id → update kategori
    // - GET ?action=edit → tampilkan form edit
    // - Default → tampilkan semua kategori
    public function index(){
        $this->checkAdmin();

        // ---------- PROSES DELETE ----------
        if(isset($_GET['action']) && $_GET['action'] == 'delete'){
            $id = (int) $_GET['id'];
            $this->categoryModel->delete($id);
            header("Location: kategori.php");
            exit();
        }

        // ---------- PROSES TAMBAH (POST) ----------
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['edit_id'])){
            $data = ['nama_kategori' => $_POST['nama_kategori']];
            $this->categoryModel->create($data);
            header("Location: kategori.php");
            exit();
        }

        // ---------- PROSES UPDATE (POST) ----------
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])){
            $id = (int) $_POST['edit_id'];
            $data = ['nama_kategori' => $_POST['nama_kategori']];
            $this->categoryModel->update($id, $data);
            header("Location: kategori.php");
            exit();
        }

        // ---------- DATA UNTUK TAMPILAN ----------
        $categories = $this->categoryModel->read();

        // Jika sedang mode edit, ambil data kategori yang akan di-edit
        $editData = null;
        if(isset($_GET['action']) && $_GET['action'] == 'edit'){
            $editData = $this->categoryModel->getById((int) $_GET['id']);
        }

        // Kembalikan data ke view
        return [
            'categories' => $categories,
            'editData'   => $editData
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

        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
            header("Location: ../../login.php");
            exit();
        }
    }
}
