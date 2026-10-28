# Form Penjualan

Aplikasi web sederhana untuk manajemen data barang/penjualan menggunakan **HTML frontend** dan **PHP backend**.

## 📋 Fitur

- 🔐 **Autentikasi** — Register, Login, Logout dengan password hashing (bcrypt)
- 📦 **CRUD Barang** — Tambah, Lihat, Edit, Hapus data barang
- 📊 **Dashboard** — Statistik total barang, total stok, dan total nilai
- 🔍 **Pencarian** — Cari barang berdasarkan nama atau deskripsi
- 🌐 **Dual Bahasa** — Indonesia & English
- 🔒 **Keamanan** — PDO Prepared Statements, session-based auth, sanitasi input

## 🗂️ Struktur Folder

```
10124023-WillyWildanHapid-IF1/
├── HTML/                   # Frontend (HTML murni + JavaScript)
│   ├── login.html          # Halaman login
│   ├── register.html       # Halaman registrasi
│   ├── index.html          # Dashboard & tabel data barang
│   ├── create.html         # Form tambah barang
│   └── edit.html           # Form edit barang
├── PHP/                    # Backend (PHP murni)
│   ├── koneksi.php         # Koneksi database (PDO)
│   ├── login.php           # Proses login
│   ├── register.php        # Proses registrasi
│   ├── logout.php          # Proses logout
│   ├── create.php          # Proses tambah barang
│   ├── edit.php            # Proses edit barang
│   ├── api.php             # API JSON (list, get, delete)
│   └── bahasa.php          # Sistem dual bahasa (ID/EN)
├── tugas.sql               # Skema database
└── README.md
```

## ⚙️ Cara Instalasi

### Prasyarat
- [Laragon](https://laragon.org/) / XAMPP / WAMP
- PHP 7.4+
- MySQL / MariaDB

### Langkah-langkah

1. **Clone repository**
   ```bash
   git clone https://github.com/willywildan125-dev/10124023-WillyWildanHapid-IF1.git
   ```

2. **Letakkan di folder web server**
   ```
   C:\laragon\www\10124023-WillyWildanHapid-IF1
   ```

3. **Import database**
   - Buka phpMyAdmin (`http://localhost/phpmyadmin`)
   - Import file `tugas.sql`

4. **Konfigurasi database** (jika perlu)
   - Edit file `PHP/koneksi.php` sesuai konfigurasi server kamu

5. **Buka aplikasi**
   ```
   http://localhost/10124023-WillyWildanHapid-IF1/HTML/login.html
   ```

## 🛠️ Teknologi

| Layer    | Teknologi        |
|----------|------------------|
| Frontend | HTML, JavaScript |
| Backend  | PHP (PDO)        |
| Database | MySQL / MariaDB  |

## 👤 Dibuat Oleh

**Willy Wildan Hapid** — 10124023 — IF1
