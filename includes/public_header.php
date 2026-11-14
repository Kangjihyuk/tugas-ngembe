<?php
require_once __DIR__ . '/../config/supabase.php';

$currentPage = basename($_SERVER['PHP_SELF']);
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title) . ' - ' : '' ?><?= e(DESA_NAME) ?> - <?= e(KECAMATAN) ?>, <?= e(KABUPATEN) ?></title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Website Resmi Pemerintah Desa Ngembe, Kecamatan Beji, Kabupaten Pasuruan, Jawa Timur. Informasi profil desa, layanan pengajuan surat online warga, destinasi wisata Grojokan Limo, dan transparansi desa.">
    <meta name="keywords" content="Desa Ngembe, Beji, Pasuruan, Grojokan Limo, Pelayanan Surat Desa Ngembe, Berita Desa Ngembe">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f8fafc; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans selection:bg-emerald-500 selection:text-white flex flex-col min-h-screen">

    <!-- Top Contact & Status Bar -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-emerald-400"></i>
                    <span>Kec. Beji, Kab. Pasuruan, Jawa Timur</span>
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-clock text-emerald-400"></i>
                    <span>Pelayanan: Senin - Jumat (08.00 - 15.00 WIB)</span>
                </span>
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-phone text-emerald-400"></i>
                    <span><?= e(TELP_DESA) ?></span>
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <span class="flex items-center gap-1.5 text-emerald-400 font-medium bg-emerald-950/60 px-2.5 py-0.5 rounded-full border border-emerald-800/50">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Pelayanan Online Aktif</span>
                </span>
                <?php if (is_logged_in()): ?>
                    <a href="admin_dashboard.php" class="text-amber-300 hover:text-amber-200 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-gauge-high"></i> Panel Petugas
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-slate-300 hover:text-white font-medium flex items-center gap-1">
                        <i class="fa-solid fa-lock text-xs"></i> Login Petugas
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand Header -->
                <a href="index.php" class="flex items-center gap-3.5 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-700 via-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-600/30 group-hover:scale-105 transition duration-200">
                        <i class="fa-solid fa-landmark-flag text-2xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 group-hover:text-emerald-700 transition">DESA NGEMBE</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full">Resmi</span>
                        </div>
                        <p class="text-xs font-medium text-slate-500">Kecamatan Beji &bull; Kabupaten Pasuruan</p>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden lg:flex items-center space-x-1">
                    <a href="index.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'index.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Beranda
                    </a>
                    <a href="profil.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'profil.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Profil Desa
                    </a>
                    <a href="pemerintahan.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'pemerintahan.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Pemerintahan
                    </a>
                    <a href="layanan.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'layanan.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Layanan Warga
                    </a>
                    <a href="potensi.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'potensi.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Wisata &amp; Potensi
                    </a>
                    <a href="berita.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'berita.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Berita &amp; Agenda
                    </a>
                    <a href="kontak.php" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition <?= $currentPage === 'kontak.php' ? 'text-emerald-700 bg-emerald-50' : 'text-slate-700 hover:text-emerald-600 hover:bg-slate-50' ?>">
                        Kontak
                    </a>
                </nav>

                <!-- CTA Button -->
                <div class="hidden lg:flex items-center gap-3">
                    <a href="layanan.php#form-ajukan" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md shadow-emerald-600/25 transition transform active:scale-95">
                        <i class="fa-solid fa-file-signature"></i>
                        <span>Ajukan Surat Online</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center gap-2">
                    <a href="layanan.php#form-ajukan" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg text-sm font-bold">
                        <i class="fa-solid fa-file-pen text-lg"></i>
                    </a>
                    <button type="button" onclick="togglePublicMobileMenu()" class="p-2.5 rounded-xl text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <i id="menu-icon-bars" class="fa-solid fa-bars text-xl"></i>
                        <i id="menu-icon-close" class="fa-solid fa-xmark text-xl hidden"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2 shadow-xl animate-in slide-in-from-top">
            <a href="index.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'index.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-house w-5 text-emerald-600"></i> Beranda
            </a>
            <a href="profil.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'profil.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-circle-info w-5 text-emerald-600"></i> Profil Desa &amp; 4 Dusun
            </a>
            <a href="pemerintahan.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'pemerintahan.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-users w-5 text-emerald-600"></i> Pemerintahan &amp; BPD
            </a>
            <a href="layanan.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'layanan.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-file-contract w-5 text-emerald-600"></i> Pelayanan Surat Warga
            </a>
            <a href="potensi.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'potensi.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-water w-5 text-emerald-600"></i> Wisata Grojokan Limo &amp; Potensi
            </a>
            <a href="berita.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'berita.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-newspaper w-5 text-emerald-600"></i> Berita &amp; Agenda
            </a>
            <a href="kontak.php" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold <?= $currentPage === 'kontak.php' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' ?>">
                <i class="fa-solid fa-envelope w-5 text-emerald-600"></i> Kontak &amp; Aspirasi Warga
            </a>
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                <a href="layanan.php#form-ajukan" class="w-full text-center py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm shadow">
                    <i class="fa-solid fa-file-pen mr-1"></i> Ajukan Surat Mandiri
                </a>
                <?php if (is_logged_in()): ?>
                    <a href="admin_dashboard.php" class="w-full text-center py-2 rounded-xl bg-slate-900 text-amber-300 font-semibold text-xs">
                        <i class="fa-solid fa-gauge mr-1"></i> Buka Panel Petugas Desa
                    </a>
                <?php else: ?>
                    <a href="login.php" class="w-full text-center py-2 rounded-xl bg-slate-100 text-slate-700 font-semibold text-xs hover:bg-slate-200">
                        <i class="fa-solid fa-lock mr-1"></i> Login Pamong / Petugas
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Flash Alert Message (jika ada) -->
    <?php if ($flash): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="p-4 rounded-2xl flex items-center justify-between shadow-sm <?= $flash['type'] === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : ($flash['type'] === 'error' ? 'bg-rose-50 text-rose-800 border border-rose-200' : 'bg-amber-50 text-amber-800 border border-amber-200') ?>">
            <div class="flex items-center gap-3">
                <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check text-emerald-600' : 'fa-circle-exclamation text-rose-600' ?> text-lg"></i>
                <span class="text-sm font-semibold"><?= e($flash['message']) ?></span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 text-sm">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>
