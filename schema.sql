-- ==============================================================================
-- Skema Database SiSurat - Sistem Informasi Manajemen Surat Menyurat
-- Untuk Supabase SQL Editor (PostgreSQL)
-- ==============================================================================

-- 1. Tabel Pengguna (Admin / Petugas Arsip)
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role VARCHAR(30) DEFAULT 'petugas',
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- 2. Tabel Surat Masuk
CREATE TABLE IF NOT EXISTS surat_masuk (
    id SERIAL PRIMARY KEY,
    nomor_surat VARCHAR(100) UNIQUE NOT NULL,
    tanggal_surat DATE NOT NULL,
    tanggal_terima DATE NOT NULL,
    pengirim VARCHAR(150) NOT NULL,
    perihal TEXT NOT NULL,
    kategori VARCHAR(50) DEFAULT 'Umum',
    status_disposisi VARCHAR(30) DEFAULT 'Belum Disposisi',
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- 3. Tabel Surat Keluar
CREATE TABLE IF NOT EXISTS surat_keluar (
    id SERIAL PRIMARY KEY,
    nomor_surat VARCHAR(100) UNIQUE NOT NULL,
    tanggal_surat DATE NOT NULL,
    tujuan VARCHAR(150) NOT NULL,
    perihal TEXT NOT NULL,
    kategori VARCHAR(50) DEFAULT 'Umum',
    penandatangan VARCHAR(100) NOT NULL,
    status_kirim VARCHAR(30) DEFAULT 'Terkirim',
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- 4. Tabel Disposisi Surat Masuk
CREATE TABLE IF NOT EXISTS disposisi (
    id SERIAL PRIMARY KEY,
    surat_masuk_id INT REFERENCES surat_masuk(id) ON DELETE CASCADE,
    tujuan_unit VARCHAR(100) NOT NULL,
    instruksi TEXT NOT NULL,
    sifat VARCHAR(30) DEFAULT 'Segera',
    batas_waktu DATE,
    status VARCHAR(30) DEFAULT 'Diproses',
    created_at TIMESTAMPTZ DEFAULT NOW()
);

-- ==============================================================================
-- Data Awal (Seed Data) untuk Demo & Pengujian
-- ==============================================================================

INSERT INTO surat_masuk (nomor_surat, tanggal_surat, tanggal_terima, pengirim, perihal, kategori, status_disposisi)
VALUES 
('001/UND/DINAS-KOMINFO/XI/2026', '2026-11-10', '2026-11-11', 'Dinas Komunikasi dan Informatika', 'Undangan Rapat Koordinasi Sistem Pemerintahan Berbasis Elektronik', 'Undangan', 'Sudah Disposisi'),
('045/PMH/UNIV-TI/XI/2026', '2026-11-11', '2026-11-12', 'Fakultas Ilmu Komputer', 'Permohonan Izin Magang Mahasiswa Semester Ganjil', 'Permohonan', 'Belum Disposisi')
ON CONFLICT (nomor_surat) DO NOTHING;

INSERT INTO surat_keluar (nomor_surat, tanggal_surat, tujuan, perihal, kategori, penandatangan, status_kirim)
VALUES 
('012/SK/SEKRET/XI/2026', '2026-11-12', 'Seluruh Kepala Divisi Operasional', 'Pemberitahuan Pemeliharaan Server Arsip Digital', 'Pemberitahuan', 'Kepala Sekretariat', 'Terkirim')
ON CONFLICT (nomor_surat) DO NOTHING;

INSERT INTO disposisi (surat_masuk_id, tujuan_unit, instruksi, sifat, batas_waktu, status)
VALUES 
(1, 'Divisi IT & Infrastruktur', 'Hadiri rapat koordinasi dan siapkan bahan paparan arsitektur sistem.', 'Penting', '2026-11-15', 'Diproses')
ON CONFLICT DO NOTHING;

-- Akun demo opsional pada tabel users (password default: admin123)
-- Hash di bawah dihasilkan dari password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (username, password_hash, nama_lengkap, role)
VALUES 
('admin', '$2y$10$tM2j3qPqFkZ9/f2o9Vq6pOOvL0/3Wv4k87w1XzH56G4M4e4c4kCke', 'Administrator Arsip', 'admin')
ON CONFLICT (username) DO NOTHING;

-- ==============================================================================
-- Row Level Security (RLS) & Policies untuk Supabase PostgREST API
-- ==============================================================================

ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE surat_masuk ENABLE ROW LEVEL SECURITY;
ALTER TABLE surat_keluar ENABLE ROW LEVEL SECURITY;
ALTER TABLE disposisi ENABLE ROW LEVEL SECURITY;

-- Memberikan izin akses penuh kepada role anon untuk keperluan prototipe tugas
DROP POLICY IF EXISTS "Allow public access users" ON users;
CREATE POLICY "Allow public access users" ON users FOR ALL USING (true) WITH CHECK (true);

DROP POLICY IF EXISTS "Allow public access surat_masuk" ON surat_masuk;
CREATE POLICY "Allow public access surat_masuk" ON surat_masuk FOR ALL USING (true) WITH CHECK (true);

DROP POLICY IF EXISTS "Allow public access surat_keluar" ON surat_keluar;
CREATE POLICY "Allow public access surat_keluar" ON surat_keluar FOR ALL USING (true) WITH CHECK (true);

DROP POLICY IF EXISTS "Allow public access disposisi" ON disposisi;
CREATE POLICY "Allow public access disposisi" ON disposisi FOR ALL USING (true) WITH CHECK (true);
