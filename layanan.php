<?php
$page_title = 'Pelayanan Surat Warga';
require_once __DIR__ . '/config/supabase.php';

$kode_tiket_baru = null;
$hasil_tracking = null;
$tracking_keyword = '';

// 1. Tangani Submit Pengajuan Surat Mandiri
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajukan_surat') {
    $nik = trim($_POST['nik'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $dusun = trim($_POST['dusun'] ?? '');
    $rt_rw = trim($_POST['rt_rw'] ?? '');
    $jenis_surat = trim($_POST['jenis_surat'] ?? '');
    $keperluan = trim($_POST['keperluan'] ?? '');

    if (empty($nik) || empty($nama) || empty($no_hp) || empty($jenis_surat) || empty($keperluan)) {
        set_flash('error', 'Mohon lengkapi seluruh formulir bertanda bintang (*).');
    } else {
        // Buat kode tiket permohonan
        $random_num = str_pad(rand(10, 999), 3, '0', STR_PAD_LEFT);
        $tiket = 'NGB-' . date('Ym') . '-' . $random_num;

        $baru = save_permohonan([
            'kode_tiket' => $tiket,
            'nik' => $nik,
            'nama' => $nama,
            'no_hp' => $no_hp,
            'dusun' => $dusun,
            'rt_rw' => $rt_rw,
            'jenis_surat' => $jenis_surat,
            'keperluan' => $keperluan
        ]);

        $kode_tiket_baru = $tiket;
        set_flash('success', "Permohonan surat berhasil dikirim! Simpan Nomor Tiket Anda: {$tiket}");
    }
}

// 2. Tangani Cek Status Tracking Surat
if (isset($_GET['cari_tiket']) && !empty(trim($_GET['cari_tiket']))) {
    $tracking_keyword = trim($_GET['cari_tiket']);
    $semua = get_permohonan_list();
    foreach ($semua as $item) {
        if (strcasecmp($item['kode_tiket'] ?? '', $tracking_keyword) === 0 || ($item['nik'] ?? '') === $tracking_keyword) {
            $hasil_tracking = $item;
            break;
        }
    }
}

// Deteksi jika dari link shortcut jenis surat
$selected_jenis = $_GET['jenis'] ?? '';
$map_jenis = [
    'sku' => 'Surat Keterangan Usaha (SKU)',
    'skd' => 'Surat Keterangan Domisili (SKD)',
    'skck' => 'Surat Pengantar SKCK',
    'sktm' => 'Surat Keterangan Tidak Mampu (SKTM)',
    'kelahiran' => 'Surat Keterangan Kelahiran',
    'kematian' => 'Surat Keterangan Kematian',
    'belum_menikah' => 'Surat Keterangan Belum Menikah'
];
$default_selected_surat = $map_jenis[$selected_jenis] ?? '';

require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Layanan Publik Online</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Pelayanan Surat Mandiri Warga</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Ajukan permohonan surat administrasi kependudukan kapan saja dari rumah Anda. Cepat, transparan, dan dapat dipantau langsung statusnya.
        </p>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- KOTAK NOTIFIKASI TIKET BARU JIKA SELESAI MENGAJUKAN -->
        <?php if ($kode_tiket_baru): ?>
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6 animate-in fade-in">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl shrink-0">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-100 bg-emerald-700/60 px-2.5 py-0.5 rounded-full">Tiket Permohonan Diterbitkan</span>
                    <h3 class="text-2xl sm:text-3xl font-black mt-1"><?= e($kode_tiket_baru) ?></h3>
                    <p class="text-xs text-emerald-100 mt-1">Harap catat atau tangkap layar (screenshot) kode tiket ini untuk mengecek status surat Anda.</p>
                </div>
            </div>
            <a href="layanan.php?cari_tiket=<?= urlencode($kode_tiket_baru) ?>#cek-status" class="px-6 py-3 rounded-xl bg-white text-emerald-800 hover:bg-emerald-50 font-bold text-xs shadow-lg transition">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Pantau Status Sekarang
            </a>
        </div>
        <?php endif; ?>

        <!-- GRID DUA KOLOM: FORM PENGAJUAN & TRACKING STATUS -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- KOLOM KIRI: FORMULIR PENGAJUAN MANDIRI -->
            <div id="form-ajukan" class="lg:col-span-7 bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-sm scroll-mt-24">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shadow-md">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Formulir Pengajuan Surat</h2>
                        <p class="text-xs text-slate-500">Lengkapi identitas diri sesuai Kartu Tanda Penduduk (KTP)</p>
                    </div>
                </div>

                <form action="layanan.php" method="POST" class="space-y-4 text-xs">
                    <input type="hidden" name="action" value="ajukan_surat">

                    <!-- Baris 1: NIK & Nama -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK) *</label>
                            <input type="text" name="nik" required maxlength="16" placeholder="16 digit NIK KTP Anda" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white font-mono text-sm">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap (sesuai KTP) *</label>
                            <input type="text" name="nama" required placeholder="Nama lengkap Anda" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        </div>
                    </div>

                    <!-- Baris 2: No WhatsApp & Dusun -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP Aktif *</label>
                            <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <span class="text-[10px] text-slate-400">Petugas akan mengabari saat surat selesai.</span>
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Wilayah Dusun Tempat Tinggal *</label>
                            <select name="dusun" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                <option value="">-- Pilih Dusun --</option>
                                <option value="Dusun Ngembe">Dusun Ngembe</option>
                                <option value="Dusun Krikilan">Dusun Krikilan</option>
                                <option value="Dusun Grogolan">Dusun Grogolan</option>
                                <option value="Dusun Simpar">Dusun Simpar</option>
                            </select>
                        </div>
                    </div>

                    <!-- Baris 3: RT/RW & Jenis Surat -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">RT / RW *</label>
                            <input type="text" name="rt_rw" required placeholder="Contoh: RT 02 / RW 01" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Jenis Surat Yang Dimohon *</label>
                            <select name="jenis_surat" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white font-medium">
                                <option value="">-- Pilih Jenis Surat --</option>
                                <option value="Surat Keterangan Usaha (SKU)" <?= $default_selected_surat === 'Surat Keterangan Usaha (SKU)' ? 'selected' : '' ?>>Surat Keterangan Usaha (SKU)</option>
                                <option value="Surat Keterangan Domisili (SKD)" <?= $default_selected_surat === 'Surat Keterangan Domisili (SKD)' ? 'selected' : '' ?>>Surat Keterangan Domisili (SKD)</option>
                                <option value="Surat Pengantar SKCK" <?= $default_selected_surat === 'Surat Pengantar SKCK' ? 'selected' : '' ?>>Surat Pengantar SKCK</option>
                                <option value="Surat Keterangan Tidak Mampu (SKTM)" <?= $default_selected_surat === 'Surat Keterangan Tidak Mampu (SKTM)' ? 'selected' : '' ?>>Surat Keterangan Tidak Mampu (SKTM)</option>
                                <option value="Surat Keterangan Kelahiran" <?= $default_selected_surat === 'Surat Keterangan Kelahiran' ? 'selected' : '' ?>>Surat Keterangan Kelahiran</option>
                                <option value="Surat Keterangan Kematian" <?= $default_selected_surat === 'Surat Keterangan Kematian' ? 'selected' : '' ?>>Surat Keterangan Kematian</option>
                                <option value="Surat Keterangan Belum Menikah" <?= $default_selected_surat === 'Surat Keterangan Belum Menikah' ? 'selected' : '' ?>>Surat Keterangan Belum Menikah</option>
                                <option value="Surat Keterangan Penghasilan">Surat Keterangan Penghasilan</option>
                                <option value="Surat Keterangan Pindah Domisili">Surat Keterangan Pindah Domisili</option>
                            </select>
                        </div>
                    </div>

                    <!-- Keperluan Pembuatan Surat -->
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Keperluan / Keterangan Tambahan *</label>
                        <textarea name="keperluan" rows="3" required placeholder="Jelaskan untuk apa surat ini dibuat (misal: pengajuan kredit usaha mikro di BRI, persyaratan berkas kerja, dsb)..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan Surat Online</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-400 text-center">
                        <i class="fa-solid fa-shield-halved text-emerald-600 mr-1"></i> Data Anda dijamin kerahasiaannya oleh Pemerintah Desa Ngembe.
                    </p>
                </form>
            </div>

            <!-- KOLOM KANAN: TRACKING STATUS SURAT -->
            <div id="cek-status" class="lg:col-span-5 space-y-6 scroll-mt-24">
                
                <!-- Kotak Form Pencarian Status -->
                <div class="bg-gradient-to-b from-slate-900 to-emerald-950 text-white p-6 sm:p-8 rounded-3xl shadow-xl space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xl border border-emerald-500/30">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Cek Status Permohonan</h3>
                            <p class="text-xs text-slate-300">Masukkan Nomor Tiket atau NIK Anda</p>
                        </div>
                    </div>

                    <form action="layanan.php" method="GET" class="space-y-3">
                        <div>
                            <input type="text" name="cari_tiket" value="<?= e($tracking_keyword) ?>" required placeholder="Contoh: NGB-202611-001 atau NIK" class="w-full px-4 py-3 rounded-xl border border-slate-700 bg-slate-800 text-white focus:ring-2 focus:ring-emerald-400 placeholder:text-slate-500 text-xs font-mono">
                        </div>
                        <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span>Lacak Status Surat</span>
                        </button>
                    </form>
                </div>

                <!-- HASIL PENCARIAN STATUS TRACKING -->
                <?php if ($tracking_keyword !== ''): ?>
                    <?php if ($hasil_tracking): ?>
                        <div class="bg-white border-2 border-emerald-500/40 p-6 rounded-3xl shadow-lg space-y-4 animate-in fade-in">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-mono">KODE PERMOHONAN</span>
                                    <h4 class="text-base font-extrabold text-slate-900 font-mono"><?= e($hasil_tracking['kode_tiket'] ?? '-') ?></h4>
                                </div>
                                <div>
                                    <?php
                                    $st = $hasil_tracking['status'] ?? 'Diajukan';
                                    $badge = 'bg-amber-100 text-amber-800 border-amber-200';
                                    if ($st === 'Diproses') $badge = 'bg-blue-100 text-blue-800 border-blue-200';
                                    if ($st === 'Selesai') $badge = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                    if ($st === 'Ditolak') $badge = 'bg-rose-100 text-rose-800 border-rose-200';
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border <?= $badge ?>">
                                        <?= e($st) ?>
                                    </span>
                                </div>
                            </div>

                            <div class="text-xs space-y-2 text-slate-600">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Nama Pemohon:</span>
                                    <span class="font-bold text-slate-800"><?= e($hasil_tracking['nama'] ?? '-') ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Jenis Surat:</span>
                                    <span class="font-bold text-emerald-700"><?= e($hasil_tracking['jenis_surat'] ?? '-') ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Dusun:</span>
                                    <span class="text-slate-700"><?= e($hasil_tracking['dusun'] ?? '-') ?> (<?= e($hasil_tracking['rt_rw'] ?? '-') ?>)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Tanggal Pengajuan:</span>
                                    <span class="text-slate-700"><?= format_tgl_indo($hasil_tracking['created_at'] ?? '') ?></span>
                                </div>
                            </div>

                            <!-- Catatan dari petugas -->
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                <span class="font-bold text-slate-700 block mb-1">
                                    <i class="fa-solid fa-comment-dots text-emerald-600 mr-1"></i> Pesan dari Petugas Loket:
                                </span>
                                <p class="text-slate-600 leading-relaxed italic">
                                    "<?= e($hasil_tracking['catatan_petugas'] ?? 'Berkas permohonan sedang ditinjau.') ?>"
                                </p>
                            </div>

                            <?php if (($hasil_tracking['status'] ?? '') === 'Selesai'): ?>
                            <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold text-center">
                                <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Surat telah selesai! Silakan datang ke Balai Desa Ngembe membawa KTP asli untuk pengambilan fisik dokumen.
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="bg-rose-50 border border-rose-200 p-6 rounded-3xl text-center space-y-2">
                            <i class="fa-solid fa-circle-xmark text-3xl text-rose-500"></i>
                            <h4 class="font-bold text-slate-800 text-sm">Permohonan Tidak Ditemukan</h4>
                            <p class="text-xs text-slate-500">Pastikan Kode Tiket atau NIK yang Anda masukkan sudah benar.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Panduan Jam Pelayanan -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-xs space-y-2">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        Ketentuan Pengambilan Surat Fisik:
                    </h4>
                    <p class="text-slate-500 leading-relaxed">
                        Jika status permohonan telah <strong>Selesai</strong>, warga dapat mengambil surat di loket Kantor Balai Desa Ngembe dengan membawa Fotokopi KTP dan KK pada jam kerja (Senin - Jumat, 08.00 - 15.00 WIB).
                    </p>
                </div>

            </div>

        </div>

        <!-- SECTION PANDUAN SYARAT BERKAS -->
        <section class="border-t border-slate-200 pt-12">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Pedoman Berkas</span>
                <h2 class="text-2xl font-extrabold text-slate-900 mt-2">Persyaratan Dokumen Administrasi</h2>
                <p class="text-xs text-slate-500 mt-1">Siapkan berkas pendukung berikut saat verifikasi atau pengambilan surat di Balai Desa.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-xs">
                
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm text-emerald-700">Surat Ket. Usaha (SKU)</h4>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>&bull; Fotokopi KTP &amp; Kartu Keluarga</li>
                        <li>&bull; Surat Pengantar RT/RW setempat</li>
                        <li>&bull; Foto dokumentasi tempat / aktivitas usaha</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm text-blue-700">Surat Pengantar SKCK</h4>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>&bull; Fotokopi KTP &amp; Kartu Keluarga</li>
                        <li>&bull; Fotokopi Akta Kelahiran / Ijazah</li>
                        <li>&bull; Pas foto 4x6 latar belakang merah (2 lbr)</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm text-rose-700">Surat Ket. Tidak Mampu (SKTM)</h4>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>&bull; Fotokopi KTP &amp; Kartu Keluarga</li>
                        <li>&bull; Surat Keterangan Pengantar RT/RW</li>
                        <li>&bull; Foto kondisi rumah tampak depan</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-2">
                    <h4 class="font-bold text-slate-900 text-sm text-teal-700">Surat Ket. Domisili (SKD)</h4>
                    <ul class="space-y-1.5 text-slate-600">
                        <li>&bull; Fotokopi KTP / Surat Pindah</li>
                        <li>&bull; Fotokopi Kartu Keluarga</li>
                        <li>&bull; Pengantar dari Ketua RT/RW dusun</li>
                    </ul>
                </div>

            </div>
        </section>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
