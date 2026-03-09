<?php
// ============================================
// MENU CONTROLLER - Leon Cafe
// ============================================
// - Controller ini menangani semua logika terkait MENU
// - Termasuk: tampil menu publik, detail, dan CRUD admin
// - Setiap method mengembalikan data yang dibutuhkan oleh View
// ============================================

namespace Controllers;

// Muat file-file yang dibutuhkan (Model)
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Model.php";
require_once __DIR__ . "/../models/CrudInterface.php";
require_once __DIR__ . "/../models/Menu.php";
require_once __DIR__ . "/../models/Category.php";

use Models\Menu;
use Models\Category;

class MenuController {

    private $menuModel;
    private $categoryModel;

    // Constructor: membuat objek Menu dan Category saat controller dibuat
    public function __construct(){
        $this->menuModel = new Menu();
        $this->categoryModel = new Category();
    }

    // ==========================================
    // HALAMAN PUBLIK: Index (Daftar Menu Pelanggan)
    // ==========================================
    // Fungsi ini:
    // 1. Ambil semua kategori untuk filter
    // 2. Cek apakah ada filter kategori dari URL (?kategori=...)
    // 3. Kembalikan $menus, $categories, $activeFilter ke view
    public function index(){
        // session_start() yang aman — cek dulu apakah session sudah aktif
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Ambil semua kategori untuk filter
        $categories = $this->categoryModel->read();

        // Cek apakah ada filter kategori yang dipilih
        if(isset($_GET['kategori']) && $_GET['kategori'] != ''){
            $menus = $this->menuModel->getByCategory($_GET['kategori']);
            $activeFilter = $_GET['kategori'];
        } else {
            $menus = $this->menuModel->read();
            $activeFilter = 'semua';
        }

        // Kembalikan data ke view
        return [
            'menus'        => $menus,
            'categories'   => $categories,
            'activeFilter' => $activeFilter
        ];
    }

    // ==========================================
    // HALAMAN PUBLIK: Detail Menu
    // ==========================================
    // Fungsi ini:
    // 1. Ambil ID dari URL (?id=...)
    // 2. Cari menu berdasarkan ID
    // 3. Jika tidak ditemukan, redirect ke index
    // 4. Kembalikan $data ke view
    public function detail(){
        // session_start() yang aman
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $data = $this->menuModel->getById($id);

        // Jika menu tidak ditemukan, kembali ke halaman utama
        if(!$data){
            header("Location: index.php");
            exit();
        }

        // Kembalikan data ke view
        return ['data' => $data];
    }

    // ==========================================
    // ADMIN: Daftar Menu (Tabel)
    // ==========================================
    // Fungsi ini dipanggil oleh views/admin/menu.php
    // Menampilkan semua menu dalam bentuk tabel
    public function adminIndex(){
        $this->checkAdmin();

        $menus = $this->menuModel->read();

        return ['menus' => $menus];
    }

    // ==========================================
    // ADMIN: Tambah Menu (Create)
    // ==========================================
    // Fungsi ini:
    // 1. Ambil semua kategori untuk dropdown
    // 2. Jika form dikirim (POST) → proses upload gambar + simpan menu
    // 3. Redirect ke dashboard setelah berhasil
    public function create(){
        $this->checkAdmin();

        // Ambil semua kategori untuk dropdown
        $categories = $this->categoryModel->read();

        // Proses form ketika dikirim
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // Proses upload gambar
            $gambar = $_FILES['gambar']['name'];
            $tmp = $_FILES['gambar']['tmp_name'];
            $uploadDir = __DIR__ . "/../public/images/";
            move_uploaded_file($tmp, $uploadDir . $gambar);

            // Kumpulkan data dari form ke dalam array
            $data = [
                "nama_menu"   => $_POST['nama_menu'],
                "deskripsi"   => $_POST['deskripsi'],
                "harga"       => $_POST['harga'],
                "kategori_id" => $_POST['kategori_id'],
                "gambar"      => $gambar
            ];

            // Panggil method create() dari Model Menu (OOP)
            $this->menuModel->create($data);

            // Kembali ke dashboard
            header("Location: dashboard.php");
            exit();
        }

        // Kembalikan data ke view
        return ['categories' => $categories];
    }

    // ==========================================
    // ADMIN: Edit Menu (Update)
    // ==========================================
    // Fungsi ini:
    // 1. Ambil data menu lama berdasarkan ID
    // 2. Ambil semua kategori untuk dropdown
    // 3. Jika form dikirim (POST) → proses update
    // 4. Redirect ke dashboard setelah berhasil
    public function edit(){
        $this->checkAdmin();

        // Ambil data menu yang akan di-edit
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $data = $this->menuModel->getById($id);

        if(!$data){
            header("Location: dashboard.php");
            exit();
        }

        // Ambil semua kategori untuk dropdown
        $categories = $this->categoryModel->read();

        // Proses update ketika form dikirim
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $updateData = [
                "nama_menu"   => $_POST['nama_menu'],
                "deskripsi"   => $_POST['deskripsi'],
                "harga"       => $_POST['harga'],
                "kategori_id" => $_POST['kategori_id'],
                "gambar"      => "" // kosong = tidak update gambar
            ];

            // Jika ada file gambar baru yang di-upload
            if(!empty($_FILES['gambar']['name'])){
                $gambar = $_FILES['gambar']['name'];
                $tmp = $_FILES['gambar']['tmp_name'];
                $uploadDir = __DIR__ . "/../public/images/";
                move_uploaded_file($tmp, $uploadDir . $gambar);
                $updateData['gambar'] = $gambar;
            }

            // Panggil method update() dari Model Menu (OOP)
            $this->menuModel->update($id, $updateData);
            header("Location: dashboard.php");
            exit();
        }

        // Kembalikan data ke view
        return [
            'data'       => $data,
            'categories' => $categories,
            'id'         => $id
        ];
    }

    // ==========================================
    // ADMIN: Hapus Menu (Delete)
    // ==========================================
    // Fungsi ini:
    // 1. Ambil ID dari URL
    // 2. Hapus menu dari database
    // 3. Redirect ke dashboard
    public function destroy(){
        $this->checkAdmin();

        $id = (int) $_GET['id'];

        // Panggil method delete() dari Model Menu (OOP)
        $this->menuModel->delete($id);

        header("Location: dashboard.php");
        exit();
    }

    // ==========================================
    // HELPER: Cek apakah user adalah Admin
    // ==========================================
    // Fungsi pembantu yang dipanggil di setiap method admin
    // Jika bukan admin → tendang ke halaman login
    private function checkAdmin(){
        // session_start() yang aman — cek dulu apakah session sudah aktif
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Anti-cache: agar browser tidak menyimpan halaman ini
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
            header("Location: ../../login.php");
            exit();
        }
    }
}
