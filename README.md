<p align="center">
  <h1 align="center">🌿 SahroolFlora E-commerce Project 🌿</h1>
</p>

<p align="center">
  Aplikasi e-commerce fungsional dengan integrasi proses bisnis (ERP) yang dibangun menggunakan Laravel & Tailwind CSS untuk tugas akhir mata kuliah Rekayasa E-Bisnis.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC.svg?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/MySQL-8.x-4479A1.svg?style=for-the-badge&logo=mysql" alt="MySQL">
</p>

---

## 📝 Tentang Proyek Ini

**SahroolFlora** adalah simulasi aplikasi web untuk sebuah toko online tanaman hias. Proyek ini tidak hanya berfungsi sebagai antarmuka untuk pelanggan (toko online), tetapi juga sebagai sistem ERP (Enterprise Resource Planning) terpadu bagi admin untuk mengelola seluruh aspek bisnis secara efisien.

## ✨ Fitur Utama

Aplikasi ini memiliki dua bagian utama yang saling terhubung:

### Frontend (Untuk Customer)
- **Katalog Produk:** Menampilkan semua produk dengan filter (per kategori) dan fitur urutkan (harga, terbaru).
- **Keranjang & Wishlist:** Sistem keranjang belanja dan wishlist berbasis database yang persisten.
- **Sistem Diskon:** Penerapan kode kupon untuk potongan harga.
- **Alur Transaksi Lengkap:** Proses checkout mulai dari pengisian alamat, pemilihan metode pengiriman, hingga pemilihan metode pembayaran.
- **Akun Pengguna:**
    - Registrasi & Login.
    - Halaman pengaturan akun (ganti profil/password).
    - Halaman riwayat pesanan dengan status yang jelas.
    - Form lacak pesanan publik tanpa login.
- **Fitur Purna Jual:** Kemampuan untuk submit testimoni dan mengajukan pengembalian.
- **Halaman Informasi:** Blog, Testimoni, Tentang Kami, Kontak, dan FAQ.

### Backend (Sistem ERP untuk Admin)
- **Dashboard Analitik:** Pusat informasi berisi 7+ statistik (pendapatan, pesanan baru, produk terlaris, grafik, dll), peringatan stok, dan notifikasi.
- **Manajemen Katalog:** CRUD penuh untuk Produk (termasuk gambar & harga modal) dan Kategori.
- **Manajemen Operasional:**
    - Manajemen Pesanan (lihat detail, update status, input no. resi).
    - Manajemen Stok (halaman terpusat).
    - CRUD untuk Kupon, Opsi Pengiriman, dan Metode Pembayaran.
- **Manajemen Interaksi (CRM):**
    - CRUD penuh untuk Pengguna & Role.
    - Halaman Detail Pelanggan yang menampilkan semua riwayat interaksi.
    - Melihat Pesan Kontak, Testimoni, dan Permintaan Pengembalian.
- **Laporan Keuangan:** Laporan Pendapatan & Pengeluaran dengan filter tanggal, beserta perhitungan keuntungan bersih.

## 🛠️ Teknologi yang Digunakan

* **PHP 8.2**
* **Framework:** Laravel 11
* **Frontend:** Tailwind CSS & Alpine.js
* **Database:** MySQL
* **Web Server:** Apache/Nginx (direkomendasikan via Laragon/XAMPP)

## ⚙️ System Requirements

- PHP >= 8.2
- Composer 2.x
- Node.js & NPM
- Database (MySQL/MariaDB)
- Web Server (Apache/Nginx)

## 🚀 Instalasi

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/nama-repo.git](https://github.com/username/nama-repo.git)
    cd nama-repo
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sahroolflora
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4.  **Jalankan Migrasi & Seeder**
    Perintah ini akan membuat semua tabel dan mengisinya dengan data awal (user admin, produk, dll).
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Buat Symbolic Link untuk Storage**
    ```bash
    php artisan storage:link
    ```

6.  **Compile Aset Frontend & Jalankan Server**
    Buka dua tab terminal.
    
    Di terminal pertama, jalankan:
    ```bash
    npm run dev
    ```
    Di terminal kedua, jalankan:
    ```bash
    php artisan serve
    ```

Aplikasi sekarang bisa diakses di `http://127.0.0.1:8000`.

### 🔑 Akun Demo
- **Admin:**
    - Email: `admin@sahroolflora.test`
    - Password: `password`
- **Customer:**
    - Email: `customer@sahroolflora.test`
    - Password: `password`
