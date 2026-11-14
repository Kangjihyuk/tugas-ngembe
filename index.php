<?php
$page_title = 'Beranda Resmi';
require_once __DIR__ . '/config/supabase.php';

// Tangani kirim aspirasi cepat dari beranda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_aspirasi') {
    $nama = trim($_POST['nama'] ?? '');
    $dusun = trim($_POST['dusun'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'Umum');
    $pesan = trim($_POST['pesan'] ?? '');

    if (!empty($nama) && !empty($pesan)) {
        save_pengaduan([
            'nama' => $nama,
            'dusun' => $dusun,
            'kategori' => $kategori,
            'pesan' => $pesan
        ]);
        set_flash('success', 'Terima kasih! Aspirasi atau pesan Anda telah berhasil disampaikan ke Pemerintah Desa Ngembe.');
    } else {
        set_flash('error', 'Mohon lengkapi nama dan isi pesan aspirasi Anda.');
    }
    header('Location: index.php#aspirasi');
    exit;
}

require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Announcement Ticker -->
<div class="bg-emerald-800 text-white text-xs py-2 px-4 shadow-inner">
    <div class="max-w-7xl mx-auto flex items-center gap-3 overflow-hidden">
        <span class="bg-emerald-600 text-white font-bold px-2 py-0.5 rounded text-[11px] uppercase tracking-wider shrink-0 flex items-center gap-1.5">
            <i class="fa-solid fa-bullhorn animate-pulse"></i> Pengumuman
        </span>
        <div class="truncate text-emerald-100 flex items-center gap-6">
            <span>&bull; Pelayanan administrasi surat-menyurat warga kini dapat diajukan secara online melalui portal ini.</span>
            <span>&bull; Wisata Alam Grojokan Limo Dusun Grogolan siap menyambut pengunjung dengan suasana alam yang asri dan sejuk.</span>
            <span>&bull; Pelaksanaan Posyandu ILP balita dan lansia serentak di 4 Dusun (Ngembe, Krikilan, Grogolan, Simpar).</span>
        </div>
    </div>
</div>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-slate-900 via-emerald-950 to-slate-900 text-white overflow-hidden py-20 lg:py-28">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#22c55e_1px,transparent_1px)] [background-size:20px_20px]"></div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-semibold backdrop-blur-sm">
                    <i class="fa-solid fa-seedling"></i>
                    <span>Portal Resmi Pelayanan &amp; Informasi Publik</span>
                </div>
                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight">
                    Selamat Datang di Website Resmi <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-lime-300">Pemerintah Desa Ngembe</span>
                </h1>
                
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Kecamatan Beji, Kabupaten Pasuruan, Jawa Timur. Mewujudkan tata kelola desa yang akuntabel, agamis, berbudaya, serta mengoptimalkan potensi pertanian dan destinasi wisata <strong>Grojokan Limo</strong>.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="layanan.php#form-ajukan" class="px-6 py-3.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-bold text-sm shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-file-signature text-base"></i>
                        <span>Ajukan Surat Mandiri</span>
                    </a>
                    <a href="profil.php" class="px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-sm border border-white/20 backdrop-blur-md transition flex items-center gap-2">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Profil &amp; Wilayah Dusun</span>
                    </a>
                    <a href="potensi.php" class="px-6 py-3.5 rounded-xl bg-teal-900/60 hover:bg-teal-900/90 text-teal-200 border border-teal-500/40 font-semibold text-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-water"></i>
                        <span>Wisata Grojokan Limo</span>
                    </a>
                </div>

                <!-- Live badges -->
                <div class="pt-6 border-t border-slate-800/80 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-slate-300">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot text-emerald-400 text-base"></i>
                        <span>4 Wilayah Dusun</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-users text-emerald-400 text-base"></i>
                        <span>± 4.872 Jiwa Penduduk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-leaf text-emerald-400 text-base"></i>
                        <span>Lumbung Pertanian &amp; Wisata</span>
                    </div>
                </div>

            </div>

            <!-- Right Hero Card: Sambutan Kades -->
            <div class="lg:col-span-5">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden">
                    <div class="flex items-start gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white text-2xl shadow-lg shrink-0 border border-white/30">
                            <i class="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-300 bg-emerald-950/80 px-2.5 py-0.5 rounded-full border border-emerald-800">Sambutan Kepala Desa</span>
                            <h3 class="text-xl font-bold text-white mt-1"><?= e(KADES_NAME) ?></h3>
                            <p class="text-xs text-slate-300">Kepala Desa Ngembe &bull; Periode Berjalan</p>
                        </div>
                    </div>
                    
                    <div class="mt-5 text-sm text-slate-200 leading-relaxed italic border-l-2 border-emerald-400 pl-4">
                        "Assalamu'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Desa Ngembe. Website ini kami dedikasikan sebagai jembatan informasi yang transparan dan memudahkan seluruh warga dalam pengurusan administrasi surat-menyurat secara cepat, mudah, dan bebas pungli."
                    </div>

                    <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-slate-300">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-solid fa-check-circle text-emerald-400"></i>
                            Siap Melayani Warga
                        </span>
                        <a href="profil.php#visi-misi" class="text-emerald-300 hover:text-white font-semibold transition flex items-center gap-1">
                            Visi &amp; Misi Desa <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SECTION: 4 WILAYAH DUSUN DESA NGEMBE -->
<section class="py-12 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">Wilayah Administratif</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">4 Dusun di Wilayah Desa Ngembe</h2>
            <p class="text-sm text-slate-500 mt-2">Desa Ngembe secara administratif terbagi menjadi empat dusun yang rukun, produktif, dan saling bersinergi dalam pembangunan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Dusun 1: Ngembe -->
            <div class="p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Pusat Desa</span>
                <h3 class="text-lg font-bold text-slate-900 mt-2">Dusun Ngembe</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Merupakan pusat pemerintahan desa, lokasi Kantor Balai Desa Ngembe, fasilitas umum, dan sentra kegiatan administrasi masyarakat.
                </p>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Kasun Ngembe</span>
                    <span class="font-semibold text-slate-700">7 RT &bull; 2 RW</span>
                </div>
            </div>

            <!-- Dusun 2: Krikilan -->
            <div class="p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    <i class="fa-solid fa-wheat-awn"></i>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2 py-0.5 rounded">Pertanian &amp; Hunian</span>
                <h3 class="text-lg font-bold text-slate-900 mt-2">Dusun Krikilan</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Kawasan dengan hamparan persawahan hijau, sistem irigasi teknis produktif untuk tanaman padi, jagung, dan palawija.
                </p>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Kasun Krikilan</span>
                    <span class="font-semibold text-slate-700">6 RT &bull; 2 RW</span>
                </div>
            </div>

            <!-- Dusun 3: Grogolan -->
            <div class="p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    <i class="fa-solid fa-water"></i>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-teal-600 bg-teal-50 px-2 py-0.5 rounded">Sentra Wisata Alam</span>
                <h3 class="text-lg font-bold text-slate-900 mt-2">Dusun Grogolan</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Lokasi destinasi wisata alam <strong>Grojokan Limo</strong>, keunikan 5 pancuran air alami jernih yang menjadi ikon kebanggaan desa.
                </p>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Kasun Grogolan</span>
                    <span class="font-semibold text-slate-700">6 RT &bull; 1 RW</span>
                </div>
            </div>

            <!-- Dusun 4: Simpar -->
            <div class="p-6 rounded-2xl bg-gradient-to-b from-slate-50 to-white border border-slate-200 hover:border-emerald-300 hover:shadow-xl transition-all duration-300 group">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    <i class="fa-solid fa-store"></i>
                </div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">Pertanian &amp; UMKM</span>
                <h3 class="text-lg font-bold text-slate-900 mt-2">Dusun Simpar</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Wilayah agraris dengan dinamika usaha mikro warga, peternakan rakyat, dan sentra produksi pangan keluarga yang mandiri.
                </p>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                    <span>Kasun Simpar</span>
                    <span class="font-semibold text-slate-700">5 RT &bull; 1 RW</span>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SECTION: PELAYANAN SURAT MANDIRI WARGA (ONLINE) -->
<section id="layanan" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-100/70 px-3 py-1 rounded-full">Pelayanan Warga</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Layanan Administrasi Surat Desa</h2>
                <p class="text-sm text-slate-500 mt-1">Warga Desa Ngembe dapat mengajukan permohonan surat secara online tanpa antre panjang.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="layanan.php#cek-status" class="px-4 py-2.5 rounded-xl bg-white border border-slate-300 hover:border-emerald-500 text-slate-700 text-xs font-bold shadow-sm transition flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-emerald-600"></i>
                    <span>Cek Status Surat</span>
                </a>
                <a href="layanan.php" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <span>Lihat Semua Layanan</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- 6 Layanan Surat Populer -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- SKU -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-shop"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Keterangan Usaha (SKU)</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Surat keterangan legalitas usaha bagi warga pedagang, pemilik warung, dan pelaku UMKM di wilayah Desa Ngembe.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> 1 Hari Kerja</span>
                    <a href="layanan.php?jenis=sku#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- SKD -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-house-user"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Keterangan Domisili (SKD)</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Keterangan tempat tinggal resmi warga di 4 dusun untuk keperluan perbankan, pekerjaan, atau administrasi sekolah.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> Langsung Jadi</span>
                    <a href="layanan.php?jenis=skd#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Pengantar SKCK -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-id-card-clip"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Pengantar SKCK</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Pengantar dari desa untuk pembuatan Surat Keterangan Catatan Kepolisian di Polsek Beji atau Polres Pasuruan.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> 1 Hari Kerja</span>
                    <a href="layanan.php?jenis=skck#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- SKTM -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Ket. Tidak Mampu (SKTM)</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Keterangan kondisi ekonomi keluarga untuk beasiswa pendidikan anak, bantuan sosial, atau keringanan biaya kesehatan.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> Verifikasi Kasun</span>
                    <a href="layanan.php?jenis=sktm#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Keterangan Kelahiran / Kematian -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-baby"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Keterangan Kelahiran</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Penerbitan surat pengantar kelahiran warga desa untuk kelengkapan pembuatan Akta Kelahiran di Dispendukcapil Pasuruan.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> 1 Hari Kerja</span>
                    <a href="layanan.php?jenis=kelahiran#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Keterangan Belum Menikah / Penghasilan -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Surat Ket. Belum Menikah</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Surat pernyataan status pernikahan untuk melamar pekerjaan, persyaratan KPR perumahan, atau administrasi nikah KUA.
                </p>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400"><i class="fa-regular fa-clock mr-1"></i> Langsung Jadi</span>
                    <a href="layanan.php?jenis=belum_menikah#form-ajukan" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                        Ajukan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- SECTION: DESTINASI IKONIK WISATA GROJOKAN LIMO & POTENSI DESA -->
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-8 sm:p-12 text-white relative shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <div class="lg:col-span-7 space-y-4">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-water mr-1"></i> Ikon Wisata Desa Ngembe
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Wisata Alam Grojokan Limo</h2>
                    <p class="text-sm sm:text-base text-slate-200 leading-relaxed">
                        Terletak di <strong>Dusun Grogolan, Desa Ngembe</strong>, Grojokan Limo merupakan destinasi wisata alam air terjun mini dengan 5 aliran pancuran bertingkat yang mengalir jernih. Dikelilingi pepohonan rimbun yang asri, udara sejuk, dan suasana persawahan khas pedesaan Pasuruan.
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-2 text-xs">
                        <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                            <p class="text-emerald-300 font-bold text-sm">5 Pancuran</p>
                            <p class="text-slate-300">Aliran Air Alami</p>
                        </div>
                        <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                            <p class="text-emerald-300 font-bold text-sm">Dusun Grogolan</p>
                            <p class="text-slate-300">Lokasi Strategis</p>
                        </div>
                        <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                            <p class="text-emerald-300 font-bold text-sm">Setiap Hari</p>
                            <p class="text-slate-300">Terbuka Untuk Umum</p>
                        </div>
                    </div>
                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="potensi.php" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-lg transition flex items-center gap-2">
                            <span>Pelajari Rute &amp; Galeri</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="https://maps.google.com/?q=Grojokan+Limo+Ngembe+Beji+Pasuruan" target="_blank" class="px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs border border-white/20 transition flex items-center gap-2">
                            <i class="fa-solid fa-map-pin"></i>
                            <span>Buka di Google Maps</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-center">
                    <div class="w-full max-w-sm bg-white/10 border border-white/20 backdrop-blur-md rounded-2xl p-6 text-center space-y-4">
                        <div class="w-20 h-20 mx-auto rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-3xl border border-emerald-400/40">
                            <i class="fa-solid fa-mountain-sun"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Pesona Alam Asri &amp; Bersahaja</h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Nikmati kesegaran air alami, spot foto instagramable, serta keramahan warga Dusun Grogolan yang siap menyambut Anda.
                        </p>
                        <div class="p-3 bg-emerald-950/60 rounded-xl border border-emerald-800 text-xs text-emerald-200">
                            <i class="fa-solid fa-leaf mr-1"></i> Mari jaga kebersihan &amp; keasrian lingkungan bersama.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- SECTION: BERITA & AGENDA KEGIATAN DESA -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">Kabar Terkini</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Berita &amp; Kegiatan Warga Desa Ngembe</h2>
            </div>
            <a href="berita.php" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1.5">
                <span>Lihat Seluruh Kabar</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Berita 1 -->
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                <div class="h-44 bg-gradient-to-tr from-emerald-800 to-teal-600 flex items-center justify-center text-white relative">
                    <i class="fa-solid fa-tractor text-5xl opacity-40"></i>
                    <span class="absolute top-3 left-3 bg-emerald-950/80 text-emerald-300 text-[10px] font-bold px-2.5 py-1 rounded-md">
                        Pembangunan Desa
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>12 November 2026</span>
                            <span>&bull;</span>
                            <span>Dusun Krikilan</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 hover:text-emerald-600 transition leading-snug">
                            <a href="berita.php">Peningkatan Jaringan Irigasi Tersier Mendukung Ketahanan Pangan Petani</a>
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                            Pemerintah Desa Ngembe merealisasikan pembangunan saluran irigasi guna mengairi puluhan hektar sawah padi warga Dusun Krikilan dan Dusun Simpar menjelang musim tanam.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Tim Jurnalis Desa</span>
                        <a href="berita.php" class="text-emerald-600 font-bold hover:underline">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            </article>

            <!-- Berita 2 -->
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                <div class="h-44 bg-gradient-to-tr from-teal-800 to-cyan-600 flex items-center justify-center text-white relative">
                    <i class="fa-solid fa-water text-5xl opacity-40"></i>
                    <span class="absolute top-3 left-3 bg-teal-950/80 text-teal-300 text-[10px] font-bold px-2.5 py-1 rounded-md">
                        Pariwisata &amp; Lingkungan
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>08 November 2026</span>
                            <span>&bull;</span>
                            <span>Dusun Grogolan</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 hover:text-emerald-600 transition leading-snug">
                            <a href="berita.php">Kerja Bakti Guyub Rukun Pembersihan Jalur Wisata Alam Grojokan Limo</a>
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                            Karang Taruna bersama perangkat desa dan warga setempat antusias menggelar aksi bersih sungai dan penataan area istirahat di sekitar pancuran Grojokan Limo.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Humas Desa</span>
                        <a href="berita.php" class="text-emerald-600 font-bold hover:underline">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            </article>

            <!-- Berita 3 -->
            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
                <div class="h-44 bg-gradient-to-tr from-amber-700 to-emerald-700 flex items-center justify-center text-white relative">
                    <i class="fa-solid fa-hand-holding-dollar text-5xl opacity-40"></i>
                    <span class="absolute top-3 left-3 bg-amber-950/80 text-amber-300 text-[10px] font-bold px-2.5 py-1 rounded-md">
                        Sosial &amp; Bantuan
                    </span>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>04 November 2026</span>
                            <span>&bull;</span>
                            <span>Balai Desa Ngembe</span>
                        </div>
                        <h3 class="text-base font-bold text-slate-900 hover:text-emerald-600 transition leading-snug">
                            <a href="berita.php">Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Berjalan Tertib</a>
                        </h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3 leading-relaxed">
                            Kepala Desa Ngembe menyalurkan bantuan tunai bagi keluarga penerima manfaat (KPM) disaksikan Babinsa, Bhabinkamtibmas, dan perwakilan BPD.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-slate-400">Kaur Keuangan</span>
                        <a href="berita.php" class="text-emerald-600 font-bold hover:underline">Baca Selengkapnya &rarr;</a>
                    </div>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- SECTION: PETA LOKASI, BATAS WILAYAH & KOTAK ASPIRASI -->
<section id="aspirasi" class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Kolom Kiri: Peta & Batas Wilayah -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Geografis Desa</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Batas Wilayah &amp; Lokasi Balai Desa</h2>
                    <p class="text-xs text-slate-500 mt-1">Desa Ngembe terletak di lokasi strategis Kecamatan Beji, berbatasan langsung dengan Kecamatan Pandaan.</p>
                </div>

                <!-- Kartu 4 Batas Wilayah -->
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-bold text-slate-700 flex items-center gap-1.5"><i class="fa-solid fa-compass text-emerald-600"></i> Sebelah Utara:</p>
                        <p class="text-slate-600 mt-1">Berbatasan dengan <strong>Desa Kenep</strong> (Kec. Beji)</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-bold text-slate-700 flex items-center gap-1.5"><i class="fa-solid fa-compass text-emerald-600"></i> Sebelah Timur:</p>
                        <p class="text-slate-600 mt-1">Berbatasan dengan <strong>Desa Banjarkejen</strong> (Kec. Pandaan)</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-bold text-slate-700 flex items-center gap-1.5"><i class="fa-solid fa-compass text-emerald-600"></i> Sebelah Selatan:</p>
                        <p class="text-slate-600 mt-1">Berbatasan dengan <strong>Desa Sebani</strong> (Kec. Pandaan)</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="font-bold text-slate-700 flex items-center gap-1.5"><i class="fa-solid fa-compass text-emerald-600"></i> Sebelah Barat:</p>
                        <p class="text-slate-600 mt-1">Berbatasan dengan <strong>Desa Baujeng</strong> (Kec. Beji)</p>
                    </div>
                </div>

                <!-- Google Maps Embed Balai Desa Ngembe -->
                <div class="rounded-2xl overflow-hidden border border-slate-200 shadow-md h-72 relative bg-slate-100">
                    <iframe 
                        title="Peta Balai Desa Ngembe Beji Pasuruan"
                        src="https://maps.google.com/maps?q=Kantor+Balai+Desa+Ngembe+Beji+Pasuruan&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                        class="w-full h-full border-0" 
                        loading="lazy" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Kolom Kanan: Form Aspirasi & Aduan Warga -->
            <div class="lg:col-span-5">
                <div class="bg-gradient-to-b from-slate-50 to-emerald-50/40 p-6 sm:p-8 rounded-3xl border border-emerald-100 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Kotak Aspirasi &amp; Pengaduan</h3>
                            <p class="text-xs text-slate-500">Sampaikan saran, masukan, atau keluhan</p>
                        </div>
                    </div>

                    <form action="index.php" method="POST" class="space-y-4 text-xs">
                        <input type="hidden" name="action" value="kirim_aspirasi">
                        
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap Warga / Inisial *</label>
                            <input type="text" name="nama" required placeholder="Contoh: Ahmad / Warga Simpar" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Pilih Wilayah Dusun *</label>
                            <select name="dusun" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                <option value="Dusun Ngembe">Dusun Ngembe</option>
                                <option value="Dusun Krikilan">Dusun Krikilan</option>
                                <option value="Dusun Grogolan">Dusun Grogolan</option>
                                <option value="Dusun Simpar">Dusun Simpar</option>
                                <option value="Luar Desa">Warga Luar Desa / Pengunjung</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Kategori Topik *</label>
                            <select name="kategori" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                <option value="Pelayanan Administrasi">Pelayanan Administrasi &amp; Surat</option>
                                <option value="Infrastruktur & Jalan">Infrastruktur, Jalan, &amp; Irigasi</option>
                                <option value="Kebersihan & Wisata">Kebersihan, Lingkungan &amp; Wisata</option>
                                <option value="Keamanan & Ketertiban">Keamanan &amp; Ketertiban Warga</option>
                                <option value="Saran & Masukan">Saran &amp; Masukan Umum</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Isi Pesan Aspirasi / Keluhan *</label>
                            <textarea name="pesan" rows="3" required placeholder="Tuliskan pesan atau usulan Anda dengan jelas dan santun..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/25 transition">
                            <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Pesan Aspirasi Warga
                        </button>
                    </form>

                    <div class="mt-4 pt-3 border-t border-emerald-200/60 text-center">
                        <p class="text-[11px] text-slate-500">
                            Butuh tanggapan cepat? Hubungi langsung WhatsApp Kantor Desa: 
                            <a href="https://wa.me/6285233445566" target="_blank" class="text-emerald-700 font-bold hover:underline">0852-3344-5566</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
