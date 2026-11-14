# 🏛️ Website Resmi Pemerintah Desa Ngembe
> **Kecamatan Beji, Kabupaten Pasuruan, Provinsi Jawa Timur**  
> Portal Layanan Informasi Publik, Pengajuan Surat Mandiri Online Warga, Destinasi Wisata Grojokan Limo, dan Sistem Administrasi Persuratan Desa.

**Pengembang**: Khusni Mubarok  
**Repositori GitHub**: [https://github.com/Kangjihyuk/tugas-ngembe.git](https://github.com/Kangjihyuk/tugas-ngembe.git)

---

## 📋 Daftar Isi
1. [Tentang Website Desa Ngembe](#-tentang-website-desa-ngembe)
2. [Fitur Unggulan](#-fitur-unggulan)
3. [Struktur Direktori & Halaman](#-struktur-direktori--halaman)
4. [Karakteristik 4 Dusun Desa Ngembe](#-karakteristik-4-dusun-desa-ngembe)
5. [Panduan Akses & Menjalankan Website](#-panduan-akses--menjalankan-website)
6. [Akun Login Pamong / Petugas Balai Desa](#-akun-login-pamong--petugas-balai-desa)
7. [Integrasi Database (Lokal & Supabase Cloud)](#-integrasi-database-lokal--supabase-cloud)

---

## 🌟 Tentang Website Desa Ngembe
Website ini dikembangkan untuk mewujudkan tata kelola pemerintahan desa yang transparan, akuntabel, dan berbasis teknologi digital (e-Government). Memadukan portal publik untuk seluruh warga dan pengunjung serta panel tata usaha kedinasan untuk staf dan pamong desa.

- **Lokasi**: Kecamatan Beji, Kabupaten Pasuruan, Jawa Timur 67154
- **Batas Wilayah**:
  - **Utara**: Desa Kenep (Kec. Beji)
  - **Timur**: Desa Banjarkejen (Kec. Pandaan)
  - **Selatan**: Desa Sebani (Kec. Pandaan)
  - **Barat**: Desa Baujeng (Kec. Beji)
- **Potensi Unggulan**: Wisata Alam Grojokan Limo (Dusun Grogolan), Lahan Persawahan Subur (Gapoktan), dan UMKM Olahan Pangan.

---

## 🚀 Fitur Unggulan

### A. Portal Publik (Warga & Pengunjung)
1. **Beranda Interaktif (`index.php`)**:
   - Hero banner dinamis dengan slogan desa *"Maju, Berdaya, Guyub, dan Sejahtera"*.
   - Ticker pengumuman desa terkini.
   - Statistik kependudukan 4 dusun (± 4.872 jiwa, 1.458 KK, 24 RT / 6 RW).
   - Sambutan resmi Kepala Desa Ngembe.
   - Akses cepat 6 permohonan surat warga terpopuler.
   - Highlight wisata alam Grojokan Limo.
   - Peta lokasi kantor Balai Desa Ngembe (Google Maps Embed) & batas wilayah.
   - Kotak suara / aspirasi warga cepat.

2. **Profil Lengkap Desa (`profil.php`)**:
   - Visi & Misi Pembangunan Jangka Menengah Desa Ngembe.
   - Sejarah & Asal Usul Nama Desa Ngembe.
   - Profil detail 4 Dusun (Ngembe, Krikilan, Grogolan, Simpar).
   - Tipologi & kondisi geografis wilayah.

3. **Struktur Pemerintahan (`pemerintahan.php`)**:
   - Bagan Kepala Desa & Sekretaris Desa.
   - Jajaran Kepala Urusan (Keuangan, Umum/TU, Perencanaan).
   - Jajaran Kepala Seksi (Pemerintahan, Kesejahteraan, Pelayanan).
   - 4 Kepala Dusun (Kasun Ngembe, Kasun Krikilan, Kasun Grogolan, Kasun Simpar).
   - Badan Permusyawaratan Desa (BPD), PKK, dan Karang Taruna "Karya Muda".

4. **Pelayanan Surat Mandiri Online (`layanan.php`)**:
   - Formulir online pengajuan surat warga: SKU, SKD, Pengantar SKCK, SKTM, Kelahiran, Kematian, Belum Menikah, Penghasilan, dan Pindah Domisili.
   - Penerbitan otomatis **Kode Tiket Permohonan** (contoh: `NGB-202611-001`).
   - Fitur **Pelacakan Status Surat Real-time** berdasarkan Kode Tiket atau NIK.
   - Panduan berkas dan persyaratan yang wajib disiapkan warga.

5. **Wisata & Potensi Desa (`potensi.php`)**:
   - Ulasan mendalam destinasi wisata alam **Grojokan Limo** (air terjun mini 5 pancuran di Dusun Grogolan).
   - Potensi pertanian padi & jagung dengan irigasi teknis terpadu.
   - Galeri UMKM dan produk olahan warga dusun.

6. **Kabar & Berita Desa (`berita.php`)**:
   - Publikasi agenda pembangunan saluran irigasi, BLT Dana Desa, posyandu serentak, dan kegiatan gotong royong.

7. **Kontak & Pengaduan (`kontak.php`)**:
   - Jam pelayanan kantor desa & nomor WhatsApp hotline.
   - Kontak darurat: Ambulans Desa, Bidan Desa, Babinsa, dan Bhabinkamtibmas.
   - Formulir aspirasi/pengaduan online langsung ke perangkat desa.

---

### B. Panel Administrasi Pamong Desa (`admin_dashboard.php`)
1. **Dashboard Metrik Real-time**:
   - Total permohonan surat warga online masuk.
   - Total surat masuk kedinasan (dari Kecamatan Beji, Pemkab Pasuruan, dsb).
   - Total surat keluar dinas.
   - Total disposisi Kepala Desa yang aktif.
2. **Kelola Permohonan Surat Warga (`permohonan_surat.php`)**:
   - Verifikasi data NIK, Nama, dan keperluan surat.
   - Pembaruan status: *Diajukan* &rarr; *Diproses* &rarr; *Selesai (Siap Ambil)* &rarr; *Ditolak*.
   - Pemberian catatan loket untuk warga pemohon.
3. **Pencatatan Surat Masuk & Surat Keluar**:
   - CRUD surat dinas lengkap dengan pencarian dan filter.
4. **Cetak Surat Keluar Resmi (`cetak_surat_keluar.php`)**:
   - Dilengkapi **Kop Resmi Pemerintah Kabupaten Pasuruan - Kecamatan Beji - Kantor Kepala Desa Ngembe**.
   - Siap cetak atau ekspor PDF (`window.print()`).
5. **Cetak Lembar Disposisi Kepala Desa (`cetak_disposisi.php`)**:
   - Lembar disposisi resmi standar kedinasan dengan kolom paraf penerima dan tanda tangan Kepala Desa Ngembe.

---

## 📂 Struktur Direktori & Halaman

```text
c:\laragon\www\app/
├── config/
│   └── supabase.php            # Konfigurasi konstanta desa, helper session, cURL & JSON storage
├── data/
│   ├── permohonan.json         # Penyimpanan data pengajuan surat mandiri online warga
│   └── pengaduan.json          # Penyimpanan data kotak aspirasi & aduan warga
├── includes/
│   ├── public_header.php       # Navbar & status bar portal publik Desa Ngembe
│   ├── public_footer.php       # Footer portal desa, kontak, info dusun, & script mobile
│   ├── header.php              # Sidebar & topbar panel administrasi pamong desa
│   └── footer.php              # Footer panel administrasi
├── .env                        # Konfigurasi nama desa, kades, & API Supabase
├── index.php                   # [PUBLIK] Beranda Portal Resmi Desa Ngembe
├── profil.php                  # [PUBLIK] Profil Lengkap, Sejarah, Visi Misi & 4 Dusun
├── pemerintahan.php            # [PUBLIK] Struktur Organisasi Pemerintah Desa & BPD
├── layanan.php                 # [PUBLIK] Form Pengajuan Surat & Pelacakan Status Tiket
├── potensi.php                 # [PUBLIK] Wisata Grojokan Limo, Pertanian & UMKM
├── berita.php                  # [PUBLIK] Kabar & Agenda Kegiatan Desa
├── kontak.php                  # [PUBLIK] Kontak Balai Desa & Kontak Darurat Warga
├── login.php                   # [ADMIN] Login Pamong & Operator Loket
├── logout.php                  # [ADMIN] Keluar dari sesi pamong
├── admin_dashboard.php         # [ADMIN] Dashboard Statistik & Ringkasan Desa
├── permohonan_surat.php        # [ADMIN] Kelola & Verifikasi Permohonan Surat Online
├── surat_masuk.php             # [ADMIN] Manajemen Surat Masuk Dinas
├── surat_keluar.php            # [ADMIN] Manajemen Surat Keluar Dinas
├── disposisi.php               # [ADMIN] Disposisi Kepala Desa
├── cetak_surat_keluar.php      # [CETAK] Template Naskah Dinas Kop Resmi Desa Ngembe
├── cetak_disposisi.php         # [CETAK] Template Lembar Disposisi Kop Desa Ngembe
└── schema.sql                  # Skema database PostgreSQL Supabase
```

---

## 🏞️ Karakteristik 4 Dusun Desa Ngembe

| Nama Dusun | Rukun Tetangga / RW | Karakteristik Utama |
|---|---|---|
| **Dusun Ngembe** | 7 RT / 2 RW | Pusat pemerintahan desa, Kantor Balai Desa, fasilitas umum, sarana ibadah. |
| **Dusun Krikilan** | 6 RT / 2 RW | Sentra pertanian tanaman pangan (padi, jagung, palawija) & irigasi teknis. |
| **Dusun Grogolan** | 6 RT / 1 RW | Lokasi destinasi wisata alam unggulan **Grojokan Limo** (5 pancuran alami). |
| **Dusun Simpar** | 5 RT / 1 RW | Kawasan agraris, peternakan rakyat, dan sentra UMKM olahan makanan warga. |

---

## 💻 Panduan Akses & Menjalankan Website

### Opsi 1: Melalui Laragon (Direkomendasikan)
1. Buka aplikasi **Laragon**.
2. Klik tombol **"Start All"**.
3. Buka browser dan akses:
   - **`http://localhost/app`** (atau `http://app.test`)

### Opsi 2: Melalui PHP Built-in Server (Terminal PowerShell)
Jalankan perintah berikut di folder proyek `c:\laragon\www\app`:
```powershell
& "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe" -S localhost:8000
```
Lalu buka browser Anda: 👉 **[http://localhost:8000](http://localhost:8000)**

---

## 👤 Akun Login Pamong / Petugas Balai Desa
Untuk masuk ke panel pengelolaan administrasi dan verifikasi surat:
- URL Login: `http://localhost/app/login.php` (atau klik tombol **Login Petugas** di portal publik)
- **Username**: `admin`
- **Password**: `admin123`

---

## 🌐 Integrasi Database (Lokal & Supabase Cloud)
1. **Layanan Mandiri Warga & Pengaduan**:
   Berjalan secara instan melalui local storage berformat JSON (`data/permohonan.json` & `data/pengaduan.json`), sehingga form pengajuan warga dan pelacakan tiket langsung 100% interaktif tanpa perlu konfigurasi database tambahan.
2. **Surat Kedinasan (Supabase PostgREST)**:
   Untuk menghubungkan surat masuk/keluar ke Supabase Cloud, cukup isi `SUPABASE_URL` dan `SUPABASE_KEY` pada file `.env` dan jalankan query dari [`schema.sql`](schema.sql) pada Supabase SQL Editor.
