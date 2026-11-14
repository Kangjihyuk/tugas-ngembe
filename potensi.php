<?php
$page_title = 'Wisata & Potensi Desa';
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-teal-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-teal-400 bg-teal-950/80 px-3 py-1 rounded-full border border-teal-800">Kekayaan &amp; Destinasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Potensi &amp; Wisata Desa Ngembe</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Dari keindahan alam alami <strong>Grojokan Limo</strong>, hamparan lumbung padi subur, hingga geliat UMKM warga di empat dusun.
        </p>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- HIGHLIGHT UTAMA: WISATA ALAM GROJOKAN LIMO -->
        <section id="grojokan-limo" class="scroll-mt-24">
            <div class="bg-gradient-to-br from-teal-900 via-emerald-900 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-2xl overflow-hidden relative">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative">
                    <div class="lg:col-span-7 space-y-5">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-400/20 border border-teal-400/30 text-teal-300 text-xs font-bold">
                            <i class="fa-solid fa-water"></i> DESTINASI IKONIK DESA NGEMBE
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black tracking-tight leading-tight">
                            Wisata Alam Grojokan Limo <br>
                            <span class="text-teal-300 text-2xl sm:text-3xl font-bold">Pesona 5 Aliran Air Alami Dusun Grogolan</span>
                        </h2>
                        <p class="text-sm sm:text-base text-slate-200 leading-relaxed">
                            <strong>Grojokan Limo</strong> adalah destinasi rintisan wisata alam yang berada di Dusun Grogolan, Desa Ngembe, Kecamatan Beji. Daya tarik utamanya berupa aliran sungai jernih yang terbagi menjadi lima pancuran atau undakan air terjun mini bertingkat yang mengalir deras nan menyejukkan.
                        </p>
                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                            Dikelilingi rerimbunan pohon bambu dan pepohonan hijau alami, tempat ini menyajikan hembusan udara segar dan suasana gemericik air yang sangat cocok untuk melepas penat bersama keluarga atau komunitas pesepeda (goweser).
                        </p>

                        <!-- Fasilitas & Jam Buka -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-xs">
                            <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                                <span class="text-teal-300 font-bold block mb-0.5"><i class="fa-solid fa-ticket mr-1"></i> Tiket Masuk</span>
                                <span class="text-slate-200">Donasi Sukarela / Parkir Terjangkau</span>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                                <span class="text-teal-300 font-bold block mb-0.5"><i class="fa-regular fa-clock mr-1"></i> Jam Buka</span>
                                <span class="text-slate-200">Setiap Hari (07.00 - 17.00 WIB)</span>
                            </div>
                            <div class="bg-white/10 p-3 rounded-xl border border-white/10">
                                <span class="text-teal-300 font-bold block mb-0.5"><i class="fa-solid fa-camera mr-1"></i> Spot Foto</span>
                                <span class="text-slate-200">Bebatuan Sungai &amp; Air Terjun</span>
                            </div>
                        </div>

                        <div class="pt-3 flex flex-wrap gap-4">
                            <a href="https://maps.google.com/?q=Grojokan+Limo+Ngembe+Beji+Pasuruan" target="_blank" class="px-5 py-3 rounded-xl bg-teal-400 hover:bg-teal-500 text-slate-950 font-bold text-xs shadow-lg transition flex items-center gap-2">
                                <i class="fa-solid fa-location-arrow"></i>
                                <span>Petunjuk Arah Google Maps</span>
                            </a>
                            <a href="kontak.php" class="px-5 py-3 rounded-xl bg-white/15 hover:bg-white/25 text-white font-semibold text-xs border border-white/20 transition flex items-center gap-2">
                                <i class="fa-solid fa-circle-question"></i>
                                <span>Informasi Kunjungan Rombongan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Visual Side -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 space-y-4 text-center">
                            <div class="w-16 h-16 mx-auto rounded-full bg-teal-500/30 text-teal-300 flex items-center justify-center text-3xl">
                                <i class="fa-solid fa-person-swimming"></i>
                            </div>
                            <h4 class="text-lg font-bold text-white">Tips &amp; Etika Berwisata</h4>
                            <ul class="text-xs text-slate-200 text-left space-y-2">
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-teal-400 mt-0.5"></i>
                                    <span>Gunakan alas kaki anti selip saat menuruni bebatuan sungai.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-teal-400 mt-0.5"></i>
                                    <span>Wajib membawa kembali sampah plastik dan tidak mengotori aliran air.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fa-solid fa-check text-teal-400 mt-0.5"></i>
                                    <span>Waktu terbaik berkunjung: pagi hari pukul 07.30 - 10.00 WIB.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- POTENSI PERTANIAN & KETAHANAN PANGAN -->
        <section class="border-t border-slate-200 pt-12">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Sektor Agraris</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Pertanian Subur &amp; Irigasi Mandiri</h2>
                <p class="text-sm text-slate-500 mt-1">Mayoritas lahan di Dusun Krikilan dan Dusun Simpar merupakan hamparan sawah produktif.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-wheat-awn"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Komoditas Padi Unggul</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Petani Desa Ngembe menghasilkan beras berkualitas dengan siklus panen teratur didukung pemupukan berimbang dan bimbingan penyuluh pertanian lapangan (PPL).
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-faucet-drip"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Sistem Irigasi Teknis</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pemerintah Desa secara konsisten membangun dan memelihara plengsengan serta saluran irigasi tersier untuk memastikan pasokan air merata ke seluruh petak sawah.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-seedling"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Tanaman Palawija &amp; Jagung</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Sebagai rotasi tanam di musim kemarau, warga aktif membudidayakan jagung manis, kedelai, kacang tanah, dan aneka sayuran hortikultura bernilai jual tinggi.
                    </p>
                </div>

            </div>
        </section>

        <!-- POTENSI UMKM & PRODUK LOKAL WARGA -->
        <section class="border-t border-slate-200 pt-12">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Ekonomi Kreatif</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">UMKM &amp; Produk Olahan Desa</h2>
                <p class="text-sm text-slate-500 mt-1">Geliat usaha mikro keluarga di 4 dusun yang terus berkembang dan menopang ekonomi warga.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-cookie-bite"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Keripik &amp; Camilan Tradisional</h4>
                    <p class="text-xs text-slate-500">Olahan keripik pisang, singkong renyah, dan rempeyek gurih khas buatan ibu-ibu PKK Dusun Simpar.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-mug-hot"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Warung Kopi &amp; Kuliner Dusun</h4>
                    <p class="text-xs text-slate-500">Sentra kuliner pedesaan dengan menu nasi pecel, rujak uleg, dan wedang jahe di dekat area wisata.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-cow"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Peternakan Rakyat</h4>
                    <p class="text-xs text-slate-500">Budidaya kambing, sapi potong, dan unggas pedaging yang dikelola mandiri oleh kelompok peternak dusun.</p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Jasa &amp; Pertukangan</h4>
                    <p class="text-xs text-slate-500">Tenaga ahli pertukangan kayu, bengkel las, dan jasa servis permesinan pertanian yang andal.</p>
                </div>

            </div>
        </section>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
