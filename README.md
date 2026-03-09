# Leon Cafe

Leon Cafe adalah sebuah aplikasi web sederhana berbasis PHP native dengan arsitektur **MVC (Model-View-Controller)** yang digunakan untuk mengelola data menu dan pengguna dari sebuah kafe.

## 🚀 Fitur Utama
- **Autentikasi Pengguna**: Login, Logout, dan Registrasi akun.
- **Manajemen Peran (Role-based Access)**:
  - **Admin**: Memiliki akses penuh (crud menu, kategori).
  - **Pelanggan**: Dapat melihat menu yang tersedia.
- **Manajemen Kategori**: Menambah, melihat, mengedit, dan menghapus kategori menu.
- **Manajemen Menu**: Menambah, melihat, mengedit, dan menghapus produk/menu kafe beserta gambar dan harganya.
- **Keamanan Halaman**: Dilengkapi dengan pencegahan akses *cache* sehingga pengguna yang sudah logout tidak bisa menekan tombol *back* ke halaman yang terproteksi.

## 🛠️ Teknologi yang Digunakan
- **Backend**: PHP (Native dengan struktur MVC)
- **Database**: MySQL (Ekstensi `mysqli`)
- **Frontend**: HTML, CSS, JavaScript (Vanilla/Sederhana)
- **Server**: Apache (via XAMPP)

## 📂 Struktur Direktori
- `config/` - Berisi pengaturan koneksi database (`Database.php`).
- `controllers/` - Berisi logika bisnis aplikasi kompartementasi ke dalam controller (`AuthController`, `MenuController`, `CategoryController`, `DashboardController`).
- `models/` - Mengelola logika berinteraksi dengan tabel database seperti `Menu`, `User`, `Category`.
- `views/` - File antarmuka pengguna (HTML/PHP khusus tampilan).
- `public/` - Aset publik (CSS, JS, Gambar/Uploads).
- `database/` - Menyimpan file skema database (`leon_cafe.sql`).
- `index.php` - Entry point atau halaman utama (Homepage Publik).

## ⚙️ Panduan Instalasi (Setup)

1. **Persiapan:** Pastikan Anda memiliki web server lokal seperti **XAMPP**, **WAMP**, atau **Laragon**.
2. **Kloning/Salin File:** Letakkan folder proyek `leon-cafe` ke dalam direktori root web server (contoh: `c:\xampp\htdocs\leon-cafe`).
3. **Konfigurasi Database:**
   - Buka **phpMyAdmin** (atau manajer database MySQL Anda).
   - Buat database baru dengan nama `leon_cafe`.
   - Import file `database/leon_cafe.sql` ke dalam database `leon_cafe`.
4. **Periksa Konfigurasi:**
   Buka file `config/Database.php` dan pastikan konfigurasi (host, username, password) sesuai dengan konfigurasi lokal Anda:
   ```php
   private $host = 'localhost';
   private $user = 'root';
   private $pass = ''; // kosongi jika default XAMPP
   private $db   = 'leon_cafe';
   ```
5. **Jalankan Aplikasi:**
   Buka browser dan akses alamat berikut:
   `http://localhost/leon-cafe/`

## 🔑 Akun Default (Testing)
Terdapat beberapa data dummy default dari proses import `.sql`:

**Akun Admin:**
- **Username:** `admin`
- **Password:** `admin123`

**Akun Pelanggan:**
- **Username:** `pelanggan`
- **Password:** `pelanggan123`

---
*Dibuat untuk keperluan manajemen Leon Cafe.*
