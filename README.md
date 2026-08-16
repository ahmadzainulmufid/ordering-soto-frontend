# 🍜 Soto Lamongan - UI/UX & Frontend Documentation

Dokumentasi ini berisi panduan antarmuka pengguna (User Interface), struktur halaman, modul panel, serta panduan integrasi sistem antrean dan manajemen resto pada aplikasi **Soto Lamongan**.

---

## 📑 Daftar Isi

- [Ikhtisar Sistem](#-ikhtisar-sistem)
- [Teknologi UI & Style Guide](#-teknologi-ui--style-guide)
- [Modul & Hak Akses Panel](#-modul--hak-akses-panel)
    - [1. Pelanggan (Customer Ordering)](#1-pelanggan-customer-ordering)
    - [2. Panel Admin (Admin Dashboard)](#2-panel-admin-admin-dashboard)
    - [3. Panel Dapur (Kitchen Display System - KDS)](#3-panel-dapur-kitchen-display-system---kds)
    - [4. Panel Owner (Executive Dashboard)](#4-panel-owner-executive-dashboard)
- [Struktur File Blade Layouts](#-struktur-file-blade-layouts)
- [Petunjuk Penggunaan & Interaksi UI](#-petunjuk-penggunaan--interaksi-ui)

---

## 🌟 Ikhtisar Sistem

Aplikasi ini dirancang menggunakan arsitektur **Material Design 3 (M3)** dengan skema warna khas restoran (Nuansa Hijau Organik `#1e5e3a` & Emas Gurih `#785900`). Tampilan bersifat responsif (_Mobile-First_ untuk Pelanggan & _Large-Screen Touch/KDS_ untuk Dapur dan Admin).

---

## 🎨 Teknologi UI & Style Guide

- **Framework Template**: Laravel Blade Templating
- **CSS Framework**: Tailwind CSS
- **Design Tokens (M3 Theme)**:
    - `primary`: `#1e5e3a` (Hijau Utama Soto)
    - `secondary`: `#785900` (Koya Emas / Accent)
    - `surface-bright`: `#ffffff`
    - `surface-container`: Tonal Layering M3
- **Iconography**: Google Material Symbols Outlined
- **Chart Component**: Chart.js (Visualisasi Grafik Omset Mingguan)

---

## 🖥️ Modul & Hak Akses Panel

### 1. Pelanggan (Customer Ordering)

- **URL**: `/menu`
- **Layout**: `layouts/app.blade.php`
- **Fitur Utama UI**:
    - Filter kategori menu dinamis & _Live Search Bar_.
    - _Sticky Order Summary Card_ (Ringkasan Keranjang Belanja).
    - Modal Form Checkout (_Responsive & Scrollable Modal_) yang mendukung tipe pemesanan: **Dine In**, **Takeaway**, dan **Delivery**.
    - Integrasi instruksi pembayaran Cash & QRIS/E-Wallet via Midtrans Online.

### 2. Panel Admin (Admin Dashboard)

- **URL Prefix**: `/admin/*`
- **Layout**: `layouts/admin.blade.php`
- **Fitur Utama UI**:
    - **Dashboard Operasional**: Ringkasan Bento Grid (_Total Orders, Sedang Dimasak, Katalog Menu, & Stok Habis_).
    - **Kelola Pesanan Masuk**: Supervisi status transaksi _real-time_ dari seluruh area resto.
    - **Kelola Katalog**: Manajemen produk menu, penetapan harga, kategori, dan nomor meja.
    - **Dropdown Aktivitas & Notifikasi System**.

### 3. Panel Dapur (Kitchen Display System - KDS)

- **URL**: `/kitchen/orders`
- **Layout**: `layouts/kitchen.blade.php`
- **Fitur Utama UI**:
    - **Card Pesanan Visual dengan Indikator Status Warna**:
        - 🔴 **Merah (Baru Masuk / Pending)**: Membutuhkan perhatian cepat koki (_Pulse Animation_).
        - 🟡 **Kuning (Proses Kompor / Cooking)**: Pesanan sedang dalam tahap penyajian/memasak.
        - 🟢 **Hijau (Siap Saji / Ready)**: Pesanan siap diambil oleh pelayan.
    - **Highlight Catatan Khusus**: Memperjelas instruksi khusus pelanggan (_contoh: "Kuah dipisah, koya dibanyakin"_).
    - **Filter Tab Instant**: Memungkinkan koki menyaring antrean masakan tanpa memuat ulang (_reload_) halaman.

### 4. Panel Owner (Executive Dashboard)

- **URL Prefix**: `/owner/*`
- **Layout**: `layouts/owner.blade.php`
- **Fitur Utama UI**:
    - Executive Bento Summary (_Pendapatan Harian, Total Omset, & Counter Transaksi_).
    - Grafik Batang Interaktif (_Chart.js_) untuk memantau **Tren Penjualan Mingguan**.
    - Monitor Transaksi Terbaru (_Read-Only Transaction Table_).

---

## 📁 Struktur File Blade Layouts

```text
resources/views/
├── includes/
│   ├── style.blade.php          # Import Google Fonts & Asset Tailwind
│   ├── script.blade.php         # Script Global JS & Modals
│   └── logout-modal.blade.php   # Modal Konfirmasi Keluar
├── layouts/
│   ├── app.blade.php            # Layout Utama Pelanggan
│   ├── admin.blade.php          # Layout Panel Admin (Sidebar Hijau)
│   ├── kitchen.blade.php        # Layout Panel Dapur / KDS
│   └── owner.blade.php          # Layout Panel Owner / Eksekutif
└── pages/
    ├── menu.blade.php           # Katalog & Checkout Pelanggan
    ├── admin/
    │   ├── dashboard.blade.php  # Dashboard Operasional Admin
    │   └── orders.blade.php     # Kelola Transaksi Admin
    ├── kitchen/
    │   └── orders.blade.php     # Kitchen Display System (Antrean Dapur)
    └── owner/
        └── dashboard.blade.php  # Dashboard Eksekutif Owner
```

---
