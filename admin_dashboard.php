<?php
$page_title = 'Dashboard Administrasi Desa';
require_once __DIR__ . '/includes/header.php';

// Tangani Update Status Permohonan Surat Warga dari Dashboard
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status_permohonan') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $catatan = trim($_POST['catatan'] ?? '');

    if ($id > 0 && !empty($status)) {
        update_permohonan_status($id, $status, $catatan);
        set_flash('success', "Status permohonan surat berhasil diperbarui menjadi '{$status}'.");
    }
    header('Location: admin_dashboard.php');
    exit;
}

// Inisialisasi variabel statistik
$totalSuratMasuk = 0;
$totalSuratKeluar = 0;
$totalDisposisiAktif = 0;
$totalBelumDisposisi = 0;

$recentSuratMasuk = [];
$recentSuratKeluar = [];
$dbError = null;

if ($isConfigured) {
    // 1. Ambil data Surat Masuk
    $resMasuk = supabase_request('GET', 'surat_masuk?order=created_at.desc');
    if ($resMasuk['code'] >= 200 && $resMasuk['code'] < 300 && is_array($resMasuk['data'])) {
        $suratMasukList = $resMasuk['data'];
        $totalSuratMasuk = count($suratMasukList);
        foreach ($suratMasukList as $sm) {
            if (($sm['status_disposisi'] ?? '') === 'Belum Disposisi') {
                $totalBelumDisposisi++;
            }
        }
        $recentSuratMasuk = array_slice($suratMasukList, 0, 5);
    } else {
        $dbError = $resMasuk['error'] ?? 'Gagal mengambil data surat masuk dari Supabase.';
    }

    // 2. Ambil data Surat Keluar
    $resKeluar = supabase_request('GET', 'surat_keluar?order=created_at.desc');
    if ($resKeluar['code'] >= 200 && $resKeluar['code'] < 300 && is_array($resKeluar['data'])) {
        $suratKeluarList = $resKeluar['data'];
        $totalSuratKeluar = count($suratKeluarList);
        $recentSuratKeluar = array_slice($suratKeluarList, 0, 5);
    }

    // 3. Ambil data Disposisi (hitung yang masih aktif / Diproses)
    $resDisposisi = supabase_request('GET', 'disposisi?order=created_at.desc');
    if ($resDisposisi['code'] >= 200 && $resDisposisi['code'] < 300 && is_array($resDisposisi['data'])) {
        $disposisiList = $resDisposisi['data'];
        foreach ($disposisiList as $disp) {
            if (($disp['status'] ?? '') === 'Diproses') {
                $totalDisposisiAktif++;
            }
        }
    }
}

// Data Permohonan Surat Warga Online
$semua_permohonan = get_permohonan_list();
$total_permohonan = count($semua_permohonan);
$permohonan_diajukan = 0;
foreach ($semua_permohonan as $p) {
    if (($p['status'] ?? '') === 'Diajukan') $permohonan_diajukan++;
}

// Data Pengaduan Masuk
$semua_pengaduan = get_pengaduan_list();
?>

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
        <div class="space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-200 bg-emerald-950/60 px-3 py-1 rounded-full border border-emerald-700">
                Pemerintah Desa Ngembe &bull; Kec. Beji
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1">
                Selamat Bertugas, <?= e($user['nama_lengkap']) ?>!
            </h1>
            <p class="text-xs sm:text-sm text-emerald-100 max-w-xl">
                Pantau permohonan surat warga online dari 4 dusun, kelola pengarsipan surat masuk &amp; dinas, serta tindak lanjuti disposisi Kepala Desa secara terpadu.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="permohonan_surat.php" class="px-4 py-2.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-xl font-bold text-xs shadow-md transition flex items-center gap-2">
                <i class="fa-solid fa-list-check"></i>
                <span>Kelola Surat Warga</span>
            </a>
            <a href="index.php" target="_blank" class="px-4 py-2.5 bg-emerald-900/60 hover:bg-emerald-900 text-white rounded-xl font-semibold text-xs border border-emerald-600 transition flex items-center gap-2">
                <i class="fa-solid fa-globe"></i>
                <span>Website Desa</span>
            </a>
        </div>
    </div>
</div>

<!-- 4 KARTU STATISTIK METRIK -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    
    <!-- Permohonan Surat Warga -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Permohonan Warga</p>
            <p class="text-2xl font-black text-slate-900 mt-1"><?= $total_permohonan ?></p>
            <p class="text-[11px] text-amber-600 font-semibold mt-1">
                <i class="fa-solid fa-clock"></i> <?= $permohonan_diajukan ?> Menunggu Verifikasi
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-envelope-open-text"></i>
        </div>
    </div>

    <!-- Surat Masuk Dinas -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Surat Masuk Dinas</p>
            <p class="text-2xl font-black text-slate-900 mt-1"><?= $totalSuratMasuk ?></p>
            <p class="text-[11px] text-emerald-600 font-semibold mt-1">
                <i class="fa-solid fa-inbox"></i> Dari Kecamatan &amp; Instansi
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-envelope"></i>
        </div>
    </div>

    <!-- Surat Keluar Dinas -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Surat Keluar Dinas</p>
            <p class="text-2xl font-black text-slate-900 mt-1"><?= $totalSuratKeluar ?></p>
            <p class="text-[11px] text-indigo-600 font-semibold mt-1">
                <i class="fa-solid fa-print"></i> Format Kop Desa Ngembe
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
    </div>

    <!-- Disposisi Aktif -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Disposisi Kades</p>
            <p class="text-2xl font-black text-slate-900 mt-1"><?= $totalDisposisiAktif ?></p>
            <p class="text-[11px] text-violet-600 font-semibold mt-1">
                <i class="fa-solid fa-spinner"></i> Sedang Ditindaklanjuti
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-file-signature"></i>
        </div>
    </div>

</div>

<!-- SECTION 1: PERMOHONAN SURAT WARGA ONLINE -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900">Permohonan Surat Warga Online Terbaru</h3>
                <p class="text-xs text-slate-500">Warga yang mengajukan surat mandiri dari 4 dusun</p>
            </div>
        </div>
        <a href="permohonan_surat.php" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
            Lihat Semua Permohonan <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3.5">Kode Tiket &amp; Tanggal</th>
                    <th class="px-5 py-3.5">Nama &amp; NIK Pemohon</th>
                    <th class="px-5 py-3.5">Asal Dusun</th>
                    <th class="px-5 py-3.5">Jenis Surat</th>
                    <th class="px-5 py-3.5">Status</th>
                    <th class="px-5 py-3.5 text-right">Aksi Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (count($semua_permohonan) === 0): ?>
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-slate-400">Belum ada permohonan surat warga yang masuk.</td>
                </tr>
                <?php else: ?>
                <?php foreach (array_slice($semua_permohonan, 0, 5) as $row): ?>
                <tr class="hover:bg-slate-50/80 transition">
                    <td class="px-5 py-3.5">
                        <span class="font-mono font-bold text-slate-800 text-xs block"><?= e($row['kode_tiket'] ?? '-') ?></span>
                        <span class="text-[10px] text-slate-400"><?= format_tgl_indo($row['created_at'] ?? '') ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-bold text-slate-900 block"><?= e($row['nama']) ?></span>
                        <span class="text-[10px] font-mono text-slate-400">NIK: <?= e($row['nik']) ?> &bull; WA: <?= e($row['no_hp']) ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-medium text-slate-700 block"><?= e($row['dusun']) ?></span>
                        <span class="text-[10px] text-slate-400"><?= e($row['rt_rw']) ?></span>
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-semibold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-[11px] block w-fit">
                            <?= e($row['jenis_surat']) ?>
                        </span>
                        <span class="text-[10px] text-slate-500 mt-1 line-clamp-1 italic">
                            "<?= e($row['keperluan']) ?>"
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <?php
                        $st = $row['status'] ?? 'Diajukan';
                        $badge = 'bg-amber-100 text-amber-800 border-amber-200';
                        if ($st === 'Diproses') $badge = 'bg-blue-100 text-blue-800 border-blue-200';
                        if ($st === 'Selesai') $badge = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                        if ($st === 'Ditolak') $badge = 'bg-rose-100 text-rose-800 border-rose-200';
                        ?>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $badge ?>">
                            <?= e($st) ?>
                        </span>
                    </td>
                    <td class="px-5 py-3.5 text-right">
                        <form action="admin_dashboard.php" method="POST" class="inline-flex items-center gap-1.5">
                            <input type="hidden" name="action" value="update_status_permohonan">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <select name="status" class="px-2 py-1 rounded-lg border border-slate-300 text-[11px] bg-white font-medium">
                                <option value="Diajukan" <?= $st === 'Diajukan' ? 'selected' : '' ?>>Diajukan</option>
                                <option value="Diproses" <?= $st === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option value="Selesai" <?= $st === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="Ditolak" <?= $st === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>
                            <button type="submit" class="px-2.5 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] transition" title="Simpan Status">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SECTION 2: SURAT MASUK & KELUAR DINAS -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Surat Masuk -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Surat Masuk Kedinasan</h3>
            </div>
            <a href="surat_masuk.php" class="text-xs font-semibold text-emerald-600 hover:underline">Kelola &rarr;</a>
        </div>

        <div class="space-y-3">
            <?php if (count($recentSuratMasuk) === 0): ?>
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada data surat masuk kedinasan.</p>
            <?php else: ?>
                <?php foreach ($recentSuratMasuk as $sm): ?>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-3 text-xs">
                    <div>
                        <span class="font-bold text-slate-800 block"><?= e($sm['pengirim']) ?></span>
                        <span class="text-slate-600 line-clamp-1 mt-0.5"><?= e($sm['perihal']) ?></span>
                        <span class="text-[10px] text-slate-400 block mt-1"><?= e($sm['nomor_surat']) ?> &bull; <?= format_tgl_indo($sm['tanggal_terima']) ?></span>
                    </div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold shrink-0 <?= ($sm['status_disposisi'] ?? '') === 'Sudah Disposisi' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' ?>">
                        <?= e($sm['status_disposisi'] ?? 'Belum Disposisi') ?>
                    </span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Surat Keluar -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900">Surat Keluar Kedinasan</h3>
            </div>
            <a href="surat_keluar.php" class="text-xs font-semibold text-emerald-600 hover:underline">Kelola &rarr;</a>
        </div>

        <div class="space-y-3">
            <?php if (count($recentSuratKeluar) === 0): ?>
                <p class="text-xs text-slate-400 py-4 text-center">Belum ada data surat keluar kedinasan.</p>
            <?php else: ?>
                <?php foreach ($recentSuratKeluar as $sk): ?>
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-start justify-between gap-3 text-xs">
                    <div>
                        <span class="font-bold text-slate-800 block">Tujuan: <?= e($sk['tujuan']) ?></span>
                        <span class="text-slate-600 line-clamp-1 mt-0.5"><?= e($sk['perihal']) ?></span>
                        <span class="text-[10px] text-slate-400 block mt-1"><?= e($sk['nomor_surat']) ?> &bull; <?= format_tgl_indo($sk['tanggal_surat']) ?></span>
                    </div>
                    <a href="cetak_surat_keluar.php?id=<?= $sk['id'] ?>" target="_blank" class="px-2 py-1 bg-white border border-slate-300 hover:border-emerald-500 rounded text-[10px] font-bold text-slate-700 transition shrink-0" title="Cetak Format Kop Resmi Desa Ngembe">
                        <i class="fa-solid fa-print"></i> Cetak
                    </a>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- SECTION 3: KOTAK ASPIRASI & PENGADUAN WARGA -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-slate-900">Aspirasi &amp; Aduan Warga Masuk</h3>
                <p class="text-[11px] text-slate-500">Pesan dari masyarakat melalui formulir website</p>
            </div>
        </div>
        <span class="text-xs font-semibold text-slate-400"><?= count($semua_pengaduan) ?> Pesan Terdaftar</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <?php foreach ($semua_pengaduan as $ad): ?>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 text-xs space-y-2">
            <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900"><?= e($ad['nama']) ?> &bull; <span class="text-emerald-700"><?= e($ad['dusun']) ?></span></span>
                <span class="text-[10px] text-slate-400"><?= format_tgl_indo($ad['created_at'] ?? '') ?></span>
            </div>
            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-200 text-slate-700">
                <?= e($ad['kategori'] ?? 'Umum') ?>
            </span>
            <p class="text-slate-600 leading-relaxed italic">
                "<?= e($ad['pesan']) ?>"
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
