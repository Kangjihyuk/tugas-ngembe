<?php
$page_title = 'Profil Desa';
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Mengenal Lebih Dekat</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Profil &amp; Wilayah Desa Ngembe</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Sejarah, Visi &amp; Misi, Letak Geografis, serta Karakteristik 4 Dusun di Kecamatan Beji, Kabupaten Pasuruan, Jawa Timur.
        </p>
    </div>
</div>

<!-- Main Content -->
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- SECTION: VISI & MISI DESA NGEMBE -->
        <section id="visi-misi" class="scroll-mt-24">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Arah Pembangunan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Visi &amp; Misi Pemerintah Desa</h2>
                <p class="text-sm text-slate-500 mt-1">Pedoman langkah pembangunan jangka menengah demi kesejahteraan segenap warga Desa Ngembe.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                <!-- Card Visi -->
                <div class="lg:col-span-5 bg-gradient-to-br from-emerald-800 to-teal-900 text-white p-8 rounded-3xl shadow-xl flex flex-col justify-between">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-emerald-300 text-xs font-bold mb-4">
                            <i class="fa-solid fa-compass"></i> VISI UTAMA
                        </div>
                        <h3 class="text-2xl font-black tracking-tight leading-snug">
                            "Terwujudnya Desa Ngembe yang Maju, Agamis, Berbudaya, Mandiri, dan Sejahtera Berbasis Potensi Pertanian dan Kearifan Lokal."
                        </h3>
                    </div>
                    <div class="mt-8 pt-4 border-t border-white/15 text-xs text-emerald-200">
                        Pemerintah Desa Ngembe &bull; Kecamatan Beji &bull; Kabupaten Pasuruan
                    </div>
                </div>

                <!-- Card Misi -->
                <div class="lg:col-span-7 bg-slate-50 border border-slate-200 p-8 rounded-3xl shadow-sm">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold mb-4">
                        <i class="fa-solid fa-list-check"></i> MISI PEMBANGUNAN
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4">5 Pilar Misi Strategis:</h3>
                    
                    <ul class="space-y-3.5 text-xs sm:text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">1</span>
                            <span>Meningkatkan kualitas pelayanan administrasi dan kependudukan yang cepat, transparan, dan berbasis teknologi digital bagi seluruh masyarakat.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">2</span>
                            <span>Mengoptimalkan sektor pertanian, saluran irigasi, dan pemberdayaan gabungan kelompok tani (Gapoktan) guna menjamin ketahanan pangan warga.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">3</span>
                            <span>Mengembangkan dan mempromosikan potensi wisata alam <strong>Grojokan Limo</strong> serta mendorong UMKM lokal bernilai tambah.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">4</span>
                            <span>Meningkatkan pembangunan infrastruktur jalan desa, pavingisasi lingkungan dusun, dan fasilitas penerangan yang merata di 4 dusun.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">5</span>
                            <span>Memperkokoh kerukunan masyarakat yang religius, berakhlak mulia, menjaga nilai gotong royong, serta kelestarian lingkungan hidup.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- SECTION: SEJARAH SINGKAT DESA NGEMBE -->
        <section class="bg-gradient-to-r from-emerald-50/60 to-slate-50 p-8 sm:p-12 rounded-3xl border border-emerald-150">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Kilas Sejarah</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Sejarah &amp; Asal Usul Desa Ngembe</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Desa Ngembe merupakan salah satu desa bersejarah di wilayah barat daya Kecamatan Beji, Kabupaten Pasuruan. Nama <strong>Ngembe</strong> secara turun-temurun diyakini berkaitan dengan keberadaan sumber mata air dan aliran sungai yang melimpah (mengalir/ngembeng) yang sejak masa lampau menyuburkan lahan pertanian warga.
                    </p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        Masyarakat Desa Ngembe dikenal memiliki etos kerja agraris yang tinggi, menjunjung tinggi tradisi musyawarah, dan kearifan lokal. Bersama empat dusunnya—<strong>Ngembe, Krikilan, Grogolan, dan Simpar</strong>—desa ini terus bertransformasi menuju desa modern tanpa meninggalkan jati diri budaya luhur Pasuruan.
                    </p>
                </div>
                <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-emerald-150 shadow-md text-center space-y-3">
                    <div class="w-16 h-16 mx-auto rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl">
                        <i class="fa-solid fa-scroll"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-base">Kearifan Lokal Yang Lestari</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Gotong royong pembersihan saluran irigasi (sedekah bumi), tradisi tasyakuran panen, dan perayaan hari besar Islam senantiasa dirawat secara guyub oleh warga di setiap dusun.
                    </p>
                </div>
            </div>
        </section>

        <!-- SECTION: RINCIAN 4 WILAYAH DUSUN -->
        <section>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Kewilayahan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Karakteristik 4 Wilayah Dusun</h2>
                <p class="text-sm text-slate-500 mt-1">Setiap dusun di Desa Ngembe memiliki keunikan potensi wilayah yang saling melengkapi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Dusun 1 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-800">Dusun I</span>
                            <span class="text-xs text-slate-400">7 RT &bull; 2 RW</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Dusun Ngembe</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Pusat pelayanan administratif dan pemerintahan desa. Di dusun ini berdiri Kantor Kepala Desa Ngembe, balai pertemuan warga, sarana ibadah utama, serta fasilitas umum kesehatan pembantu.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-map-pin text-emerald-600"></i>
                        <span>Fasilitas: Balai Desa, Poskesdes, Masjid Jami'</span>
                    </div>
                </div>

                <!-- Dusun 2 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-amber-100 text-amber-800">Dusun II</span>
                            <span class="text-xs text-slate-400">6 RT &bull; 2 RW</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Dusun Krikilan</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Dusun dengan dominasi lahan pertanian produktif. Sebagian besar warga merupakan petani penggarap padi dan tanaman palawija dengan pengelolaan kelompok tani yang aktif.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-wheat-awn text-amber-600"></i>
                        <span>Potensi: Lahan Persawahan Subur, Gapoktan Padi</span>
                    </div>
                </div>

                <!-- Dusun 3 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800">Dusun III</span>
                            <span class="text-xs text-slate-400">6 RT &bull; 1 RW</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Dusun Grogolan</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Sentra pariwisata alam Desa Ngembe tempat beradanya <strong>Wisata Grojokan Limo</strong>. Suasana asri dan rimbun menjadikan dusun ini sebagai daya tarik wisatawan keluarga lokal.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-water text-teal-600"></i>
                        <span>Destinasi: Wisata Alam Grojokan Limo (Air Terjun 5 Pancuran)</span>
                    </div>
                </div>

                <!-- Dusun 4 -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-indigo-100 text-indigo-800">Dusun IV</span>
                            <span class="text-xs text-slate-400">5 RT &bull; 1 RW</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Dusun Simpar</h3>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Dusun yang asri dengan aktivitas warga yang seimbang antara pertanian, peternakan rakyat, dan usaha mikro rumahan (UMKM makanan olahan dan kerajinan).
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-store text-indigo-600"></i>
                        <span>Keunggulan: UMKM Olahan Pangan, Usaha Ternak Warga</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION: GEOGRAFIS & BATAS WILAYAH -->
        <section class="border-t border-slate-200 pt-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="space-y-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Data Spasial</span>
                    <h2 class="text-2xl font-bold text-slate-900">Letak Geografis</h2>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Desa Ngembe berada di dataran rendah yang subur dengan ketinggian rata-rata 30-50 meter di atas permukaan laut. Memiliki iklim tropis dengan curah hujan yang mendukung pertanian sepanjang tahun.
                    </p>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Kecamatan:</span>
                            <span class="font-bold text-slate-800">Beji</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Kabupaten:</span>
                            <span class="font-bold text-slate-800">Pasuruan</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Provinsi:</span>
                            <span class="font-bold text-slate-800">Jawa Timur</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Kode Pos:</span>
                            <span class="font-bold text-slate-800">67154</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Batas Wilayah Administratif Desa:</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                            <p class="font-bold text-emerald-900 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-arrow-up text-emerald-600"></i> Sebelah Utara
                            </p>
                            <p class="text-slate-600 mt-2">
                                Berbatasan dengan <strong>Desa Kenep</strong>, Kecamatan Beji.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-200">
                            <p class="font-bold text-blue-900 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-arrow-right text-blue-600"></i> Sebelah Timur
                            </p>
                            <p class="text-slate-600 mt-2">
                                Berbatasan dengan <strong>Desa Banjarkejen</strong>, Kecamatan Pandaan.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200">
                            <p class="font-bold text-amber-900 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-arrow-down text-amber-600"></i> Sebelah Selatan
                            </p>
                            <p class="text-slate-600 mt-2">
                                Berbatasan dengan <strong>Desa Sebani</strong>, Kecamatan Pandaan.
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200">
                            <p class="font-bold text-rose-900 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-arrow-left text-rose-600"></i> Sebelah Barat
                            </p>
                            <p class="text-slate-600 mt-2">
                                Berbatasan dengan <strong>Desa Baujeng</strong>, Kecamatan Beji.
                            </p>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-900 text-white text-xs flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-emerald-400 text-base"></i>
                            <span>Ingin berkunjung atau mengurus administrasi ke Balai Desa?</span>
                        </span>
                        <a href="kontak.php" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition">
                            Lihat Lokasi &amp; Kontak
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
