<?php
$page_title = 'Berita & Agenda Kegiatan';
require_once __DIR__ . '/config/supabase.php';
require_once __DIR__ . '/includes/public_header.php';

$daftar_berita = [
    [
        'id' => 1,
        'judul' => 'Peningkatan Saluran Irigasi Tersier Mendukung Ketahanan Pangan Petani',
        'kategori' => 'Pembangunan',
        'dusun' => 'Dusun Krikilan & Simpar',
        'tanggal' => '2026-11-12',
        'ringkasan' => 'Pemerintah Desa Ngembe merealisasikan pembangunan dan normalisasi saluran irigasi guna mengairi puluhan hektar sawah padi warga menjelang musim tanam serentak.',
        'isi' => 'Guna mendukung program swasembada pangan nasional dan memaksimalkan produktivitas hasil panen petani lokal, Pemerintah Desa Ngembe melalui Tim Pelaksana Kegiatan (TPK) merampungkan pembangunan plengsengan saluran irigasi tersier sepanjang 450 meter. Saluran ini membentang menghubungkan aliran air primer menuju lahan persawahan di Dusun Krikilan dan Dusun Simpar.',
        'penulis' => 'Tim Pembangunan Desa'
    ],
    [
        'id' => 2,
        'judul' => 'Kerja Bakti Bersama Pembersihan & Penataan Kawasan Wisata Alam Grojokan Limo',
        'kategori' => 'Pariwisata & Lingkungan',
        'dusun' => 'Dusun Grogolan',
        'tanggal' => '2026-11-08',
        'ringkasan' => 'Karang Taruna bersama perangkat desa dan warga setempat antusias menggelar aksi bersih sungai dan penataan fasilitas di sekitar pancuran Grojokan Limo.',
        'isi' => 'Ratusan pemuda yang tergabung dalam Karang Taruna "Karya Muda" bersama warga Dusun Grogolan bergotong royong membersihkan sampah ranting pohon, menata jalan setapak berbatu, serta memasang papan imbauan kebersihan di destinasi wisata alam Grojokan Limo. Kegiatan ini bertujuan menciptakan kenyamanan maksimal bagi para pelancong yang berkunjung.',
        'penulis' => 'Karang Taruna Karya Muda'
    ],
    [
        'id' => 3,
        'judul' => 'Penyaluran Bantuan Langsung Tunai (BLT) Dana Desa Berjalan Tertib dan Transparan',
        'kategori' => 'Sosial & Bantuan',
        'dusun' => 'Balai Desa Ngembe',
        'tanggal' => '2026-11-04',
        'ringkasan' => 'Kepala Desa Ngembe menyalurkan bantuan tunai bagi keluarga penerima manfaat (KPM) disaksikan Babinsa, Bhabinkamtibmas, dan perwakilan BPD.',
        'isi' => 'Bertempat di pendopo Balai Desa Ngembe, sebanyak puluhan Keluarga Penerima Manfaat (KPM) telah menerima penyaluran Bantuan Langsung Tunai Dana Desa (BLT-DD) tahap berjalan. Kades Ngembe berpesan agar bantuan ini dapat dimanfaatkan secara bijak untuk memenuhi kebutuhan pokok keluarga dan tambahan modal usaha mikro.',
        'penulis' => 'Kaur Keuangan Desa'
    ],
    [
        'id' => 4,
        'judul' => 'Pelaksanaan Posyandu Integrasi Layanan Primer (ILP) Serentak di 4 Dusun',
        'kategori' => 'Kesehatan',
        'dusun' => '4 Dusun (Ngembe, Krikilan, Grogolan, Simpar)',
        'tanggal' => '2026-10-28',
        'ringkasan' => 'Kader posyandu bersama Bidan Desa menggelar pemeriksaan rutin balita, penimbangan berat badan, imunisasi, dan skrining kesehatan bagi lansia.',
        'isi' => 'Pemerintah Desa Ngembe terus berkomitmen menekan angka stunting dengan memperkuat layanan posyandu balita dan posyandu lansia. Pemeriksaan gizi, pemberian vitamin A, PMT (Pemberian Makanan Tambahan) kaya protein hewani, serta cek tensi darah dan gula darah bagi lansia dilaksanakan dengan antusiasme tinggi dari para warga.',
        'penulis' => 'Bidan Desa & TP PKK'
    ],
    [
        'id' => 5,
        'judul' => 'Musyawarah Perencanaan Pembangunan Desa (Musrenbangdes) Tahun Anggaran Mendatang',
        'kategori' => 'Pemerintahan',
        'dusun' => 'Balai Pertemuan Desa',
        'tanggal' => '2026-10-20',
        'ringkasan' => 'Menampung aspirasi usulan prioritas dari tingkat dusun, RT, dan kelompok tani demi pemerataan pembangunan desa.',
        'isi' => 'Musrenbangdes dihadiri oleh seluruh elemen masyarakat, meliputi Kepala Desa, BPD, LPMD, tokoh agama, ketua RT/RW dari 4 dusun, serta perwakilan perempuan dan pemuda. Beberapa usulan prioritas yang disepakati antara lain pavingisasi jalan lingkungan, pelatihan digital marketing bagi UMKM, dan perbaikan sarana sanitasi warga.',
        'penulis' => 'Kaur Perencanaan'
    ],
    [
        'id' => 6,
        'judul' => 'Sosialisasi Tertib Administrasi Kependudukan dan Layanan Mandiri Surat Online',
        'kategori' => 'Pelayanan Publik',
        'dusun' => 'Balai Desa Ngembe',
        'tanggal' => '2026-10-14',
        'ringkasan' => 'Pengenalan portal website desa resmi untuk mempermudah warga dalam mengurus surat keterangan tanpa harus antre lama di balai desa.',
        'isi' => 'Pemerintah Desa Ngembe memperkenalkan terobosan baru berupa formulir online pengajuan surat dan pelacakan status dokumen berbasis web. Langkah ini diapresiasi oleh masyarakat karena menghemat waktu dan biaya transportasi warga yang bekerja di pabrik atau luar kota.',
        'penulis' => 'Kasi Pelayanan'
    ]
];
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Transparansi Informasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Kabar &amp; Agenda Desa Ngembe</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Informasi resmi seputar pembangunan infrastruktur, kegiatan kemasyarakatan, posyandu, dan kemajuan desa.
        </p>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Grid Berita -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($daftar_berita as $b): ?>
            <article class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col group">
                <div class="h-48 bg-gradient-to-tr from-slate-800 via-emerald-900 to-teal-800 flex items-center justify-center text-white relative">
                    <i class="fa-solid fa-newspaper text-6xl opacity-30 group-hover:scale-110 transition duration-300"></i>
                    <span class="absolute top-4 left-4 bg-emerald-950/80 text-emerald-300 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-800/80">
                        <?= e($b['kategori']) ?>
                    </span>
                    <span class="absolute bottom-3 right-4 bg-black/50 backdrop-blur-sm text-slate-200 text-[10px] font-medium px-2 py-0.5 rounded">
                        <i class="fa-solid fa-location-dot mr-1 text-emerald-400"></i><?= e($b['dusun']) ?>
                    </span>
                </div>

                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 mb-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span><?= format_tgl_indo($b['tanggal']) ?></span>
                            <span>&bull;</span>
                            <span><?= e($b['penulis']) ?></span>
                        </div>
                        <h2 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition leading-snug">
                            <?= e($b['judul']) ?>
                        </h2>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                            <?= e($b['ringkasan']) ?>
                        </p>
                    </div>

                    <!-- Accordion Detail -->
                    <div class="pt-3 border-t border-slate-100">
                        <details class="text-xs text-slate-600 group/detail">
                            <summary class="font-bold text-emerald-600 hover:text-emerald-700 cursor-pointer list-none flex items-center justify-between">
                                <span>Baca Rilis Lengkap</span>
                                <i class="fa-solid fa-chevron-down text-[10px] group-open/detail:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="mt-3 text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-200">
                                <?= e($b['isi']) ?>
                            </p>
                        </details>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
