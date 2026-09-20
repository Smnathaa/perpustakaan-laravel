# Pustaka — Sistem Informasi Data Buku Perpustakaan Berbasis Laravel

Aplikasi Laravel 12, PHP 8.2+, Blade, CSS lokal, dan MySQL. Tidak perlu npm untuk menjalankan tampilan. Paket berisi source code, bukan vendor/dependensi Composer.

## Fitur
- Dashboard: jumlah judul, eksemplar, kategori, stok kosong, dan koleksi terbaru.
- Tambah, lihat detail, edit, hapus buku; konfirmasi penghapusan.
- Kode buku dan ISBN unik (ISBN opsional); validasi jumlah nonnegatif.
- Pencarian judul/penulis/kode/ISBN, filter kategori, pagination.
- Tambah/edit/hapus kategori. Kategori yang masih dipakai tidak dapat dihapus.
- Laporan inventaris sesuai filter; cetak atau simpan sebagai PDF melalui browser.
- Tampilan responsif berbahasa Indonesia, zona waktu WITA.

Semua akun dalam proyek ini adalah pengelola dengan hak yang sama. Tidak ada pendaftaran umum. Jumlah buku adalah jumlah inventaris, bukan perhitungan ketersediaan berdasarkan transaksi. Modul anggota, peminjaman, pengembalian, dan denda belum termasuk ruang lingkup versi ini.

## Instalasi Windows (XAMPP/Laragon)
1. Pastikan PHP 8.2 atau lebih baru dan Composer tersedia di terminal. Aktifkan ekstensi PHP yang dibutuhkan Laravel, termasuk pdo_mysql, mbstring, openssl, fileinfo, xml, curl, dan zip. Pengujian juga membutuhkan pdo_sqlite.
2. Ekstrak ZIP. Buka folder `perpustakaan-laravel` di VS Code, lalu buka terminal pada folder yang berisi `artisan`.
3. Jalankan `composer install`. Koneksi internet diperlukan untuk mengunduh dependensi.
4. Salin `.env.example` menjadi `.env`. Di CMD/PowerShell Windows: `copy .env.example .env`. Di Linux/macOS: `cp .env.example .env`.
5. Aktifkan MySQL di XAMPP/Laragon. Buat database `perpustakaan` melalui phpMyAdmin atau jalankan SQL berikut:

```sql
CREATE DATABASE perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. Sesuaikan DB_USERNAME dan DB_PASSWORD pada `.env`. Default lokal root dengan password kosong hanya contoh; sesuaikan instalasi kamu.
7. Jalankan satu per satu:

```bash
php artisan key:generate
php artisan config:clear
php artisan migrate
php artisan library:admin
php artisan serve
```

Perintah `library:admin` menanyakan nama, email, dan kata sandi minimal 10 karakter. Tidak ada akun/password bawaan. Buka http://127.0.0.1:8000 dan masuk memakai akun yang kamu buat.

Opsional data demonstrasi: `php artisan db:seed`. Data buku seeder bersifat fiktif dan diberi kode DEMO. Seeder tidak mengubah data buku yang sudah ada. Tanpa seeder, buat kategori dahulu lalu tambahkan buku.

## Alternatif SQLite
Jika tidak menggunakan MySQL, ubah DB_CONNECTION=sqlite dan hapus baris DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, serta DB_PASSWORD dari `.env`. Buat file kosong `database/database.sqlite`, kemudian jalankan `php artisan config:clear` dan `php artisan migrate`. Mengganti koneksi tidak memindahkan data dari database sebelumnya.

## Cara menggunakan
1. Login pengelola.
2. Buka Kategori untuk membuat kelompok buku.
3. Buka Data buku → Tambah buku → isi data → Simpan buku.
4. Gunakan pencarian/filter, klik judul untuk detail, atau Edit untuk memperbarui.
5. Untuk laporan terfilter, pilih Cari dahulu lalu klik Cetak hasil.
6. Klik Cetak / Simpan PDF; pilih tujuan Save as PDF untuk mengunduh laporan.

## Struktur utama
- routes/web.php: endpoint dan middleware autentikasi.
- routes/console.php: perintah pembuatan akun admin.
- app/Models: User, Book, Category dan relasinya.
- app/Http/Controllers: proses login, CRUD buku, dan kategori.
- database/migrations: skema tabel dengan foreign key dan unique index.
- database/seeders: kategori dan buku contoh.
- resources/views: halaman Blade.
- public/css/app.css: tampilan lokal tanpa CDN atau proses build.
- tests/Feature/LibraryTest.php: pengujian akses, login, CRUD, validasi, filter, dan kategori terpakai.

Relasi: satu kategori memiliki banyak buku; satu buku berada di satu kategori. User berfungsi sebagai akun pengelola, tidak ada relasi kepemilikan buku.

## Verifikasi
Jalankan `php artisan test` setelah Composer terpasang; konfigurasi pengujian menggunakan SQLite memory sehingga tidak mengubah database aplikasi. Tes disertakan tetapi belum dijalankan saat paket dibuat karena lingkungan pembuatan tidak menyediakan PHP/Composer. Lakukan pengujian ini sebelum memakai aplikasi dengan data nyata. Paket belum diverifikasi secara runtime atau visual di browser.

## Mengatasi masalah
- `php` tidak dikenali: tambahkan folder PHP XAMPP/Laragon ke PATH dan buka ulang terminal.
- `could not find driver`: aktifkan pdo_mysql (atau pdo_sqlite untuk SQLite) di php.ini yang digunakan CLI.
- `Unknown database`: buat database perpustakaan dan periksa `.env`.
- `No application encryption key`: jalankan `php artisan key:generate`.
- Tabel belum ada: jalankan `php artisan config:clear` lalu `php artisan migrate`.
- CSS tidak muncul: akses lewat `php artisan serve`, bukan membuka Blade sebagai file biasa.
- Port sibuk: jalankan `php artisan serve --port=8001`.

## Jika akan dipublikasikan
Gunakan hosting yang mendukung Laravel/PHP dan arahkan document root ke folder public. Gunakan HTTPS, APP_ENV=production, APP_DEBUG=false, serta SESSION_SECURE_COOKIE=true; rahasiakan `.env`, gunakan kredensial database produksi, dan buat backup rutin. Jangan memasukkan data contoh di database produksi. Panduan ini berfokus pada menjalankan proyek lokal.

## Referensi
Dokumentasi resmi Laravel: https://laravel.com/docs/12.x/installation dan https://laravel.com/docs/12.x/authentication. Kerangka awal berasal dari https://github.com/laravel/laravel/tree/12.x (MIT).
