<?php
// ============================================
// AUTH CONTROLLER - Leon Cafe
// ============================================
// - Controller ini menangani semua proses AUTENTIKASI (login, register, logout)
// - "Autentikasi" = proses memastikan siapa user yang sedang mengakses
// - Controller hanya memproses logika
// - Setelah diproses, controller mengembalikan data ke View untuk ditampilkan
// ============================================

namespace Controllers;

// Muat file-file yang dibutuhkan (Model)
require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../models/Model.php";
require_once __DIR__ . "/../models/User.php";

use Models\User;

class AuthController {

    private $userModel;

    // Constructor: membuat objek User saat controller dibuat
    public function __construct(){
        $this->userModel = new User();
    }

    // ==========================================
    // LOGIN
    // ==========================================
    // Fungsi ini:
    // 1. Cek apakah user sudah login → redirect
    // 2. Jika form dikirim (POST) → proses login
    // 3. Kembalikan variabel $error ke view jika gagal
    public function login(){
        // session_start() yang aman — cek dulu apakah session sudah aktif
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Jika user sudah login, langsung arahkan ke halaman yang sesuai
        if(isset($_SESSION['username'])){
            if($_SESSION['role'] == 'admin'){
                header("Location: views/admin/dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit();
        }

        $error = null;

        // Proses login ketika form dikirim (method POST)
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Panggil method login() dari Model User (OOP)
            $result = $this->userModel->login($username, $password);

            if($result){
                // Login berhasil → simpan data ke session
                $_SESSION['username'] = $result['username'];
                $_SESSION['role'] = $result['role'];
                $_SESSION['user_id'] = $result['id'];

                // Arahkan berdasarkan role
                if($result['role'] == 'admin'){
                    header("Location: views/admin/dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        }

        // Kembalikan data ke view
        return ['error' => $error];
    }

    // ==========================================
    // REGISTER
    // ==========================================
    // Fungsi ini:
    // 1. Jika form dikirim (POST) → proses registrasi
    // 2. Kembalikan variabel $success / $error ke view
    public function register(){
        $success = null;
        $error = null;

        // Proses register ketika form dikirim
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password']
            ];

            // Panggil method register() dari Model User (OOP)
            if($this->userModel->register($data)){
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Registrasi gagal. Username mungkin sudah dipakai.";
            }
        }

        // Kembalikan data ke view
        return [
            'success' => $success,
            'error'   => $error
        ];
    }

    // ==========================================
    // LOGOUT
    // ==========================================
    // Fungsi ini:
    // 1. Hapus semua session
    // 2. Hapus cookie session
    // 3. Hancurkan session
    // 4. Redirect ke halaman login
    public function logout(){
        // session_start() yang aman
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        // Langkah 1: Kosongkan semua variabel session
        $_SESSION = array();
        session_unset();

        // Langkah 2: Hapus cookie session di browser
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Langkah 3: Hancurkan session di server
        session_destroy();

        // Langkah 4: Arahkan ke halaman login
        header("Location: login.php");
        exit();
    }
}
