<?php
$page_title = 'Kelola Permohonan Surat Warga';
require_once __DIR__ . '/includes/header.php';

// Tangani Update Status Permohonan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $id = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $catatan = trim($_POST['catatan'] ?? '');

    if ($id > 0 && !empty($status)) {
        update_permohonan_status($id, $status, $catatan);
        set_flash('success', "Permohonan ID #{$id} berhasil diupdate ke status '{$status}'.");
    }
    header('Location: permohonan_surat.php');
    exit;
}

$semua = get_permohonan_list();

// Filter & Pencarian
$filter_status = $_GET['status'] ?? '';
$filter_dusun = $_GET['dusun'] ?? '';
$cari = trim($_GET['cari'] ?? '');

$filtered = array_filter($semua, function($item) use ($filter_status, $filter_dusun, $cari) {
    if (!empty($filter_status) && ($item['status'] ?? '') !== $filter_status) return false;
    if (!empty($filter_dusun) && ($item['dusun'] ?? '') !== $filter_dusun) return false;
    if (!empty($cari)) {
        $c = strtolower($cari);
        $match = str_contains(strtolower($item['nama'] ?? ''), $c) ||
                 str_contains(strtolower($item['nik'] ?? ''), $c) ||
                 str_contains(strtolower($item['kode_tiket'] ?? ''), $c) ||
                 str_contains(strtolower($item['jenis_surat'] ?? ''), $c);
        if (!$match) return false;
    }
    return true;
});
?>

<!-- Header Halaman & Filter -->
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Permohonan Surat Warga</h2>
            <p class="text-xs text-slate-500">Kelola dan verifikasi surat mandiri yang diajukan oleh masyarakat Desa Ngembe.</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs font-semibold px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200">
                Total: <?= count($filtered) ?> Permohonan
            </span>
        </div>
    </div>

    <!-- Form Filter & Pencarian -->
    <form action="permohonan_surat.php" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs pt-2 border-t border-slate-100">
        <div>
            <input type="text" name="cari" value="<?= e($cari) ?>" placeholder="Cari Nama, NIK, atau Kode Tiket..." class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500">
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 bg-white">
                <option value="">-- Semua Status --</option>
                <option value="Diajukan" <?= $filter_status === 'Diajukan' ? 'selected' : '' ?>>Diajukan (Baru)</option>
                <option value="Diproses" <?= $filter_status === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                <option value="Selesai" <?= $filter_status === 'Selesai' ? 'selected' : '' ?>>Selesai (Siap Ambil)</option>
                <option value="Ditolak" <?= $filter_status === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>
        </div>
        <div>
            <select name="dusun" class="w-full px-3 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 bg-white">
                <option value="">-- Semua Dusun --</option>
                <option value="Dusun Ngembe" <?= $filter_dusun === 'Dusun Ngembe' ? 'selected' : '' ?>>Dusun Ngembe</option>
                <option value="Dusun Krikilan" <?= $filter_dusun === 'Dusun Krikilan' ? 'selected' : '' ?>>Dusun Krikilan</option>
                <option value="Dusun Grogolan" <?= $filter_dusun === 'Dusun Grogolan' ? 'selected' : '' ?>>Dusun Grogolan</option>
                <option value="Dusun Simpar" <?= $filter_dusun === 'Dusun Simpar' ? 'selected' : '' ?>>Dusun Simpar</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-filter"></i>
                <span>Terapkan</span>
            </button>
            <?php if (!empty($cari) || !empty($filter_status) || !empty($filter_dusun)): ?>
            <a href="permohonan_surat.php" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl" title="Reset Filter">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Tabel Permohonan -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-200">
                <tr>
                    <th class="px-5 py-3.5">Kode Tiket</th>
                    <th class="px-5 py-3.5">Nama &amp; NIK Pemohon</th>
                    <th class="px-5 py-3.5">Dusun &amp; Kontak</th>
                    <th class="px-5 py-3.5">Jenis Surat &amp; Keperluan</th>
                    <th class="px-5 py-3.5">Status &amp; Catatan Petugas</th>
                    <th class="px-5 py-3.5 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (count($filtered) === 0): ?>
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-slate-400">
                        Tidak ada data permohonan surat yang sesuai filter.
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach ($filtered as $row): ?>
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="px-5 py-4 align-top">
                        <span class="font-mono font-bold text-slate-900 block"><?= e($row['kode_tiket'] ?? '-') ?></span>
                        <span class="text-[10px] text-slate-400 block mt-0.5"><?= format_tgl_indo($row['created_at'] ?? '') ?></span>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <span class="font-bold text-slate-900 block"><?= e($row['nama']) ?></span>
                        <span class="text-[10px] font-mono text-slate-400 block mt-0.5">NIK: <?= e($row['nik']) ?></span>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <span class="font-medium text-slate-700 block"><?= e($row['dusun']) ?></span>
                        <span class="text-[10px] text-slate-400 block"><?= e($row['rt_rw']) ?></span>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $row['no_hp']) ?>" target="_blank" class="text-[10px] text-emerald-600 hover:underline font-bold inline-flex items-center gap-1 mt-1">
                            <i class="fa-brands fa-whatsapp"></i> <?= e($row['no_hp']) ?>
                        </a>
                    </td>
                    <td class="px-5 py-4 align-top">
                        <span class="font-bold text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded text-[11px] block w-fit">
                            <?= e($row['jenis_surat']) ?>
                        </span>
                        <p class="text-slate-600 text-[11px] mt-1 leading-relaxed max-w-xs">
                            <?= e($row['keperluan']) ?>
                        </p>
                    </td>
                    <td class="px-5 py-4 align-top">
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
                        <?php if (!empty($row['catatan_petugas'])): ?>
                        <p class="text-[10px] text-slate-400 mt-1 italic">
                            Catatan: "<?= e($row['catatan_petugas']) ?>"
                        </p>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 align-top text-right">
                        <!-- Form Update Cepat -->
                        <form action="permohonan_surat.php" method="POST" class="space-y-1.5 inline-block text-left">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            
                            <select name="status" class="w-full px-2 py-1 rounded-lg border border-slate-300 text-[11px] bg-white font-medium">
                                <option value="Diajukan" <?= $st === 'Diajukan' ? 'selected' : '' ?>>Diajukan</option>
                                <option value="Diproses" <?= $st === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
                                <option value="Selesai" <?= $st === 'Selesai' ? 'selected' : '' ?>>Selesai (Siap Ambil)</option>
                                <option value="Ditolak" <?= $st === 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                            </select>

                            <input type="text" name="catatan" value="<?= e($row['catatan_petugas'] ?? '') ?>" placeholder="Tulis catatan warga..." class="w-full px-2 py-1 rounded-lg border border-slate-200 text-[10px] bg-slate-50 focus:bg-white">

                            <button type="submit" class="w-full py-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg text-[10px] transition">
                                Simpan Perubahan
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>
