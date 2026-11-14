<?php
require_once __DIR__ . '/../config/supabase.php';
require_auth();

$currentPage = basename($_SERVER['PHP_SELF']);
$user = current_user();
$flash = get_flash();
$isConfigured = is_supabase_configured();

// Hitung permohonan baru
$permohonan_list = get_permohonan_list();
$total_permohonan_baru = 0;
foreach ($permohonan_list as $p) {
    if (($p['status'] ?? '') === 'Diajukan') {
        $total_permohonan_baru++;
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title) . ' - ' : '' ?>Panel Administrasi <?= e(DESA_NAME) ?></title>
    
    <!-- Google Fonts Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            500: '#16a34a',
                            600: '#15803d',
                            700: '#166534',
                            800: '#14532d',
                            900: '#052e16',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-full antialiased font-sans text-slate-800 bg-slate-50 flex flex-col">

    <!-- Mobile Navigation Overlay & Drawer -->
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-900/60 z-40 hidden transition-opacity lg:hidden" onclick="toggleMobileSidebar()"></div>
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-slate-200 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-slate-900">
            <!-- Brand Logo -->
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-800 bg-slate-900/60">
                <a href="admin_dashboard.php" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-600/30 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-landmark-flag text-lg"></i>
                    </div>
                    <div>
                        <h1 class="font-extrabold text-base text-white leading-tight tracking-tight uppercase">PEMDES NGEMBE</h1>
                        <p class="text-[11px] text-emerald-400 font-medium">Kec. Beji &bull; Kab. Pasuruan</p>
                    </div>
                </a>
                <button onclick="toggleMobileSidebar()" class="lg:hidden text-slate-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Menu Pamong &amp; Loket</div>
                
                <a href="admin_dashboard.php" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-150 <?= ($currentPage === 'admin_dashboard.php' || $currentPage === 'index.php') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-base <?= $currentPage === 'admin_dashboard.php' ? 'text-white' : 'text-slate-400' ?>"></i>
                    <span>Dashboard &amp; Statistik</span>
                </a>

                <a href="permohonan_surat.php" class="flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-150 <?= $currentPage === 'permohonan_surat.php' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope-circle-check w-5 text-center text-base <?= $currentPage === 'permohonan_surat.php' ? 'text-white' : 'text-amber-400' ?>"></i>
                        <span>Permohonan Warga</span>
                    </div>
                    <?php if ($total_permohonan_baru > 0): ?>
                    <span class="px-2 py-0.5 text-[10px] font-extrabold bg-amber-500 text-slate-950 rounded-full animate-pulse">
                        <?= $total_permohonan_baru ?> Baru
                    </span>
                    <?php endif; ?>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Tata Usaha Kedinasan</div>

                <a href="surat_masuk.php" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-150 <?= $currentPage === 'surat_masuk.php' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
                    <i class="fa-solid fa-inbox w-5 text-center text-base <?= $currentPage === 'surat_masuk.php' ? 'text-white' : 'text-sky-400' ?>"></i>
                    <span>Surat Masuk Dinas</span>
                </a>

                <a href="surat_keluar.php" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-150 <?= $currentPage === 'surat_keluar.php' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
                    <i class="fa-solid fa-paper-plane w-5 text-center text-base <?= $currentPage === 'surat_keluar.php' ? 'text-white' : 'text-indigo-400' ?>"></i>
                    <span>Surat Keluar Dinas</span>
                </a>

                <a href="disposisi.php" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-150 <?= $currentPage === 'disposisi.php' ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/30' : 'text-slate-300 hover:bg-slate-900 hover:text-white' ?>">
                    <i class="fa-solid fa-file-signature w-5 text-center text-base <?= $currentPage === 'disposisi.php' ? 'text-white' : 'text-teal-400' ?>"></i>
                    <span>Disposisi Kades</span>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Akses Publik</div>

                <a href="index.php" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-emerald-300 hover:bg-emerald-950/60 border border-emerald-900/60 transition">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-globe"></i>
                        <span>Lihat Website Desa</span>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>

                <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">Status Server</div>

                <div class="px-3.5 py-3 rounded-xl bg-slate-900/70 border border-slate-800 text-xs text-slate-300 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Database:</span>
                        <span class="font-semibold text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full <?= $isConfigured ? 'bg-emerald-500 animate-pulse' : 'bg-amber-400' ?>"></span>
                            <?= $isConfigured ? 'Supabase' : 'Lokal + Cloud' ?>
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Lokasi:</span>
                        <span class="font-medium text-slate-200">Kec. Beji</span>
                    </div>
                </div>
            </nav>

            <!-- User profile & Logout -->
            <div class="p-4 border-t border-slate-900 bg-slate-950/60">
                <div class="flex items-center justify-between p-2 rounded-xl bg-slate-900/70">
                    <div class="flex items-center space-x-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-sm border border-emerald-500/30">
                            <?= strtoupper(substr($user['nama_lengkap'], 0, 2)) ?>
                        </div>
                        <div class="truncate">
                            <p class="text-sm font-semibold text-white truncate"><?= e($user['nama_lengkap']) ?></p>
                            <p class="text-xs text-slate-400 capitalize"><?= e($user['role']) ?> Desa</p>
                        </div>
                    </div>
                    <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition-colors" title="Keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Navbar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <button onclick="toggleMobileSidebar()" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800 tracking-tight flex items-center gap-2">
                            <?= isset($page_title) ? e($page_title) : 'Panel Administrasi Desa' ?>
                        </h2>
                        <p class="text-xs text-slate-500 hidden sm:block">Pemerintah Desa Ngembe &bull; Kecamatan Beji, Pasuruan</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="index.php" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition">
                        <i class="fa-solid fa-globe"></i>
                        <span>Lihat Portal Warga</span>
                    </a>
                    <span class="text-xs font-medium text-slate-500 hidden md:inline-flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-full">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        <?= date('d M Y') ?>
                    </span>
                    <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?');" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </a>
                </div>
            </header>

            <!-- Page Body Container -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

                <!-- Flash Notification Banner -->
                <?php if ($flash): ?>
                <?php 
                    $typeColors = [
                        'success' => 'bg-emerald-50 border-emerald-500 text-emerald-800 icon-emerald-500 fa-circle-check',
                        'error'   => 'bg-rose-50 border-rose-500 text-rose-800 icon-rose-500 fa-circle-xmark',
                        'warning' => 'bg-amber-50 border-amber-500 text-amber-800 icon-amber-500 fa-triangle-exclamation',
                        'info'    => 'bg-sky-50 border-sky-500 text-sky-800 icon-sky-500 fa-circle-info'
                    ];
                    $cfg = $typeColors[$flash['type']] ?? $typeColors['info'];
                    $parts = explode(' ', $cfg);
                ?>
                <div id="flash-banner" class="border-l-4 p-4 rounded-r-xl shadow-sm transition-all duration-300 <?= $parts[0] . ' ' . $parts[1] . ' ' . $parts[2] ?>">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fa-solid <?= $parts[4] ?> text-lg mr-3"></i>
                            <p class="text-sm font-semibold"><?= e($flash['message']) ?></p>
                        </div>
                        <button onclick="document.getElementById('flash-banner').remove()" class="text-slate-400 hover:text-slate-700 ml-4">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
