# Sistem Absensi Diskominfo - Dokumentasi Lengkap

## 📋 Ringkasan Aplikasi

Aplikasi Web Absensi berbasis Laravel yang dirancang untuk Dinas Komunikasi dan Informatika (Diskominfo) dengan fitur manajemen kehadiran karyawan, dashboard admin, dan form absensi user-friendly.

## 🎯 Fitur Utama

### 1. **Admin Dashboard**
- Total Karyawan dan Total Bidang
- Rekap Kehadiran Hari Ini (hadir, terlambat, izin, sakit)
- Grafik Kehadiran Mingguan/Bulanan
- Daftar Karyawan Terbaru

### 2. **Manajemen Karyawan (Admin)**
- CRUD lengkap (Create, Read, Update, Delete)
- Field: Nama, NIP, Email, Bidang, Jabatan, Jam Kerja, Foto Profil
- Filter berdasarkan bidang dan pencarian nama/NIP
- Pagination otomatis

### 3. **Manajemen Absensi (Admin)**
- Lihat semua data absensi dengan filter
- Filter: tanggal, bidang, karyawan, status
- Tambah/Edit absensi manual

### 4. **Form Absensi (Karyawan)**
- Absen Masuk dengan deteksi waktu otomatis
- Validasi: 1 user hanya bisa absen masuk 1x per hari
- Status otomatis (hadir/terlambat)
- Absen Pulang
- Riwayat absensi 7 hari terakhir

### 5. **Profil Karyawan**
- Lihat & Edit data profil
- Upload foto profil
- Ubah password

### 6. **Jam Kerja**
- Tampilkan jam kerja yang ditetapkan admin
- Penjelasan status absensi

## 📊 Database Schema

### Bidang yang Tersedia
1. APTIKA (Aplikasi Teknologi Informasi dan Komunikasi)
2. Statistik
3. IKP (Inovasi dan Komunikasi Publik)
4. Persandian

## 🚀 Instalasi & Setup

### 1. Jalankan Migrations & Seeder
```bash
php artisan migrate
php artisan db:seed
```

### 2. Default Credentials
**Admin:**
- Email: `admin@diskominfo.local`
- Password: `password`

**Karyawan (Sample):**
- Email: `karyawan1@diskominfo.local` - `karyawan4@diskominfo.local`
- Password: `password` (semua)

### 3. Menjalankan Aplikasi
```bash
php artisan serve
# Akses: http://localhost:8000
```

## 🛣️ Routes Utama

### Admin Routes (`/admin`)
- `/dashboard` - Dashboard admin
- `/karyawan` - Manajemen karyawan
- `/absensi` - Manajemen absensi

### Karyawan Routes (`/karyawan`)
- `/absensi` - Form absensi
- `/absensi/history` - Riwayat absensi
- `/profile` - Profil karyawan
- `/jam-kerja` - Informasi jam kerja

## 🎨 Teknologi Utama

- **Framework**: Laravel 12.0
- **Frontend**: Bootstrap 5.3 + Tailwind CSS
- **Icons**: Font Awesome 6.4
- **Database**: SQLite (default)
- **Build Tool**: Vite

## 🔐 Role & Middleware

- **Admin**: Akses penuh (dashboard, manajemen karyawan, absensi)
- **Karyawan**: Akses terbatas (absensi, profil, jam kerja)
- Middleware: `IsAdmin`, `IsKaryawan`

## 📝 Features Completed

✅ Database migrations dengan relationships
✅ Seeders untuk 4 bidang + 1 admin + 4 karyawan sample
✅ Authentication & Authorization
✅ Admin Controllers & Views
✅ User Controllers & Views
✅ Form Validations
✅ Filter & Search functionality
✅ Responsive Design
✅ Role-based Access Control

---

**Versi**: 1.0.0 | **Update**: 27 Nov 2025

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
