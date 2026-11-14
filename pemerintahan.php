<?php
$page_title = 'Pemerintahan Desa';
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Tata Kelola Desa</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Struktur Pemerintahan Desa Ngembe</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Aparatur Pemerintah Desa, Badan Permusyawaratan Desa (BPD), dan Lembaga Kemasyarakatan yang melayani masyarakat dengan integritas dan dedikasi.
        </p>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- KEPALA DESA & SEKRETARIS DESA -->
        <section>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Pimpinan Desa</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Kepala Desa &amp; Pimpinan Sekretariat</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                <!-- Kepala Desa -->
                <div class="bg-gradient-to-b from-slate-50 to-emerald-50/50 p-6 rounded-3xl border border-emerald-200 shadow-md text-center">
                    <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-tr from-emerald-700 to-teal-500 text-white flex items-center justify-center text-4xl shadow-lg mb-4">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">Kepala Desa</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-2"><?= e(KADES_NAME) ?></h3>
                    <p class="text-xs text-slate-500 mt-1">Penanggung Jawab Utama Kebijakan &amp; Pembangunan Desa</p>
                    <div class="mt-4 pt-3 border-t border-slate-200 text-xs text-slate-400">
                        Masa Bakti: 2020 &ndash; Sekarang
                    </div>
                </div>

                <!-- Sekretaris Desa -->
                <div class="bg-gradient-to-b from-slate-50 to-blue-50/50 p-6 rounded-3xl border border-blue-200 shadow-md text-center">
                    <div class="w-24 h-24 mx-auto rounded-2xl bg-gradient-to-tr from-blue-700 to-sky-500 text-white flex items-center justify-center text-4xl shadow-lg mb-4">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700 bg-blue-100 px-3 py-1 rounded-full">Sekretaris Desa</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-2">Ir. H. Sudirman, S.Sos.</h3>
                    <p class="text-xs text-slate-500 mt-1">Koordinator Tata Usaha, Kepegawaian, &amp; Administrasi Surat</p>
                    <div class="mt-4 pt-3 border-t border-slate-200 text-xs text-slate-400">
                        Sekretariat Desa Ngembe
                    </div>
                </div>

            </div>
        </section>

        <!-- KEPALA URUSAN & KEPALA SEKSI (PERANGKAT DESA) -->
        <section>
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Pelaksana Teknis &amp; Staf</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Kepala Urusan (Kaur) &amp; Kepala Seksi (Kasi)</h2>
                <p class="text-sm text-slate-500 mt-1">Aparatur yang bertugas langsung dalam penyelenggaraan urusan teknis dan pelayanan warga.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Kaur Keuangan -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-emerald-600">Keuangan Desa</span>
                            <h4 class="text-sm font-bold text-slate-900">Kaur Keuangan</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Muhammad Rizal, S.E.</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pengelolaan APBDes, penatausahaan kas, dan transparansi anggaran dana desa.</p>
                </div>

                <!-- Kaur Tata Usaha & Umum -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-folder-tree"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-sky-600">Tata Usaha</span>
                            <h4 class="text-sm font-bold text-slate-900">Kaur TU &amp; Umum</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Bambang Irawan</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pengarsipan naskah dinas, inventaris aset balai desa, dan ketatausahaan.</p>
                </div>

                <!-- Kaur Perencanaan -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-purple-600">Perencanaan</span>
                            <h4 class="text-sm font-bold text-slate-900">Kaur Perencanaan</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Rahmat Hidayat, S.P.</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Penyusunan RKPDes, Musrenbangdes, dan dokumentasi program kerja tahunan.</p>
                </div>

                <!-- Kasi Pemerintahan -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-landmark"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-amber-600">Pemerintahan</span>
                            <h4 class="text-sm font-bold text-slate-900">Kasi Pemerintahan</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Agus Prasetyo</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Ketertiban umum, data kependudukan, pengantar SKCK, dan pertanahan.</p>
                </div>

                <!-- Kasi Kesejahteraan -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-rose-600">Kesejahteraan</span>
                            <h4 class="text-sm font-bold text-slate-900">Kasi Kesejahteraan</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Nurul Qomariyah, S.Pd.</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pemberdayaan sosial, bantuan BLT/PKH, kesehatan, posyandu, dan keagamaan.</p>
                </div>

                <!-- Kasi Pelayanan -->
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-emerald-300 transition">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-id-badge"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-teal-600">Pelayanan Surat</span>
                            <h4 class="text-sm font-bold text-slate-900">Kasi Pelayanan</h4>
                        </div>
                    </div>
                    <p class="text-base font-bold text-slate-800">Tri Wahyudi</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pelayanan loket surat, verifikasi permohonan mandiri warga, dan legalisir dokumen.</p>
                </div>

            </div>
        </section>

        <!-- KEPALA DUSUN (KASUN) 4 WILAYAH -->
        <section class="bg-slate-50 p-8 rounded-3xl border border-slate-200">
            <div class="text-center max-w-3xl mx-auto mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-white px-3 py-1 rounded-full border border-slate-200">Pelaksana Kewilayahan</span>
                <h2 class="text-2xl font-extrabold text-slate-900 mt-2">Kepala Dusun (Kasun)</h2>
                <p class="text-xs text-slate-500 mt-1">Ujung tombak pelayanan dan pembinaan warga di 4 dusun Desa Ngembe.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Sunaryo</h4>
                    <p class="text-xs font-semibold text-emerald-700 mt-0.5">Kasun Dusun Ngembe</p>
                    <p class="text-[11px] text-slate-400 mt-1">Membawahi 7 RT / 2 RW</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 mx-auto rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Slamet Riadi</h4>
                    <p class="text-xs font-semibold text-amber-700 mt-0.5">Kasun Dusun Krikilan</p>
                    <p class="text-[11px] text-slate-400 mt-1">Membawahi 6 RT / 2 RW</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 mx-auto rounded-full bg-teal-100 text-teal-700 flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">Khoirul Anam</h4>
                    <p class="text-xs font-semibold text-teal-700 mt-0.5">Kasun Dusun Grogolan</p>
                    <p class="text-[11px] text-slate-400 mt-1">Membawahi 6 RT / 1 RW</p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="w-12 h-12 mx-auto rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center text-xl mb-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm">M. Junaidi</h4>
                    <p class="text-xs font-semibold text-indigo-700 mt-0.5">Kasun Dusun Simpar</p>
                    <p class="text-[11px] text-slate-400 mt-1">Membawahi 5 RT / 1 RW</p>
                </div>

            </div>
        </section>

        <!-- BPD & LEMBAGA DESA LAINNYA -->
        <section class="border-t border-slate-200 pt-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- BPD -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-base">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">BPD (Badan Permusyawaratan Desa)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Mitra strategis Pemerintah Desa dalam menampung dan menyalurkan aspirasi masyarakat, serta mengawasi penyelenggaraan peraturan desa.
                    </p>
                    <p class="text-xs font-semibold text-slate-700 pt-2 border-t border-slate-100">Ketua BPD: Drs. H. Achmad Zaini</p>
                </div>

                <!-- PKK DESA -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-pink-100 text-pink-700 flex items-center justify-center text-base">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">TP PKK Desa Ngembe</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penggerak pemberdayaan kesejahteraan keluarga, posyandu terpadu, penurunan angka stunting balita, dan keterampilan ibu-ibu rumah tangga.
                    </p>
                    <p class="text-xs font-semibold text-slate-700 pt-2 border-t border-slate-100">Ketua TP PKK: Ny. Hj. Siti Rohmah</p>
                </div>

                <!-- KARANG TARUNA -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-base">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900">Karang Taruna "Karya Muda"</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Wadah kreativitas pemuda pemudi 4 dusun dalam kegiatan sosial, olahraga, pengelolaan kepeloporan wisata Grojokan Limo, dan digitalisasi desa.
                    </p>
                    <p class="text-xs font-semibold text-slate-700 pt-2 border-t border-slate-100">Ketua: Danang Prasetyo, S.Kom.</p>
                </div>

            </div>
        </section>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
