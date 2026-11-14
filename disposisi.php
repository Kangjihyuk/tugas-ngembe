<?php
$page_title = 'Disposisi Surat Masuk';
require_once __DIR__ . '/includes/header.php';

// Ambil parameter surat_id jika diarahkan dari halaman Surat Masuk
$preselectedSuratId = (int)($_GET['surat_id'] ?? 0);

// Handle Aksi Form (Tambah, Ubah Status Selesai, Hapus)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. TAMBAH DISPOSISI
    if ($action === 'create') {
        $surat_masuk_id = (int)($_POST['surat_masuk_id'] ?? 0);
        $tujuan_unit = trim($_POST['tujuan_unit'] ?? '');
        $instruksi = trim($_POST['instruksi'] ?? '');
        $sifat = trim($_POST['sifat'] ?? 'Segera');
        $batas_waktu = !empty($_POST['batas_waktu']) ? trim($_POST['batas_waktu']) : null;
        $status = trim($_POST['status'] ?? 'Diproses');

        if ($surat_masuk_id <= 0 || empty($tujuan_unit) || empty($instruksi)) {
            set_flash('error', 'Silakan pilih surat masuk, tentukan unit tujuan, dan isi instruksi disposisi.');
        } else {
            $payload = [
                'surat_masuk_id' => $surat_masuk_id,
                'tujuan_unit' => $tujuan_unit,
                'instruksi' => $instruksi,
                'sifat' => $sifat,
                'batas_waktu' => $batas_waktu,
                'status' => $status
            ];

            $res = supabase_request('POST', 'disposisi', $payload);
            if ($res['code'] >= 200 && $res['code'] < 300) {
                // OTOMATIS PERBARUI STATUS SURAT MASUK MENJADI 'Sudah Disposisi'
                $updateStatus = supabase_request('PATCH', "surat_masuk?id=eq.{$surat_masuk_id}", [
                    'status_disposisi' => 'Sudah Disposisi'
                ]);

                set_flash('success', "Instruksi disposisi berhasil diterbitkan dan status surat masuk otomatis diperbarui menjadi 'Sudah Disposisi'!");
            } else {
                $err = is_array($res['data']) && isset($res['data']['message']) ? $res['data']['message'] : ($res['error'] ?? 'Terjadi kesalahan');
                set_flash('error', "Gagal membuat disposisi: " . $err);
            }
        }
        header('Location: disposisi.php');
        exit;
    }

    // 2. TANDAI DISPOSISI SELESAI
    if ($action === 'mark_complete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $res = supabase_request('PATCH', "disposisi?id=eq.{$id}", [
                'status' => 'Selesai'
            ]);

            if ($res['code'] >= 200 && $res['code'] < 300) {
                set_flash('success', "Disposisi telah ditandai 'Selesai' ditindaklanjuti.");
            } else {
                set_flash('error', "Gagal memperbarui status disposisi.");
            }
        }
        header('Location: disposisi.php');
        exit;
    }

    // 3. HAPUS DISPOSISI
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $res = supabase_request('DELETE', "disposisi?id=eq.{$id}");
            if ($res['code'] >= 200 && $res['code'] < 300) {
                set_flash('success', "Lembar instruksi disposisi berhasil dihapus.");
            } else {
                set_flash('error', "Gagal menghapus disposisi.");
            }
        }
        header('Location: disposisi.php');
        exit;
    }
}

// Filter Status & Sifat Disposisi
$filterStatus = trim($_GET['status'] ?? '');
$filterSifat = trim($_GET['sifat'] ?? '');

// Ambil seluruh daftar Surat Masuk untuk pilihan dropdown
$suratMasukList = [];
$suratMasukMap = [];

if ($isConfigured) {
    $resSM = supabase_request('GET', 'surat_masuk?order=id.desc');
    if ($resSM['code'] >= 200 && $resSM['code'] < 300 && is_array($resSM['data'])) {
        $suratMasukList = $resSM['data'];
        foreach ($suratMasukList as $row) {
            $suratMasukMap[$row['id']] = $row;
        }
    }
}

// Ambil data Disposisi (menggunakan embedded foreign key surat_masuk)
$endpoint = 'disposisi?select=*,surat_masuk(*)&order=created_at.desc';

if (!empty($filterStatus)) {
    $endpoint .= "&status=eq." . urlencode($filterStatus);
}
if (!empty($filterSifat)) {
    $endpoint .= "&sifat=eq." . urlencode($filterSifat);
}

$disposisiList = [];
$apiError = null;

if ($isConfigured) {
    $response = supabase_request('GET', $endpoint);
    if ($response['code'] >= 200 && $response['code'] < 300 && is_array($response['data'])) {
        $disposisiList = $response['data'];
    } else {
        // Fallback jika PostgREST embedded join gagal (misal cache schema Supabase belum refresh)
        $fbRes = supabase_request('GET', 'disposisi?order=created_at.desc');
        if ($fbRes['code'] >= 200 && $fbRes['code'] < 300 && is_array($fbRes['data'])) {
            $disposisiList = $fbRes['data'];
        } else {
            $apiError = $response['error'] ?? 'Gagal memuat data disposisi.';
        }
    }
}
?>

<!-- Header Halaman & Tombol Buat Disposisi -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
    <div>
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-violet-600"></span>
            Disposisi Surat Masuk
        </h2>
        <p class="text-xs text-slate-500 mt-1">Pendelegasian tugas, instruksi pimpinan, batas waktu tindak lanjut, dan lembar disposisi.</p>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" onclick="openAddModal()" 
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-violet-600 hover:bg-violet-700 active:bg-violet-800 text-white text-xs font-bold shadow-md shadow-violet-600/20 transition-all cursor-pointer">
            <i class="fa-solid fa-file-signature"></i>
            <span>Buat Disposisi Baru</span>
        </button>
    </div>
</div>

<?php if ($apiError): ?>
<div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
    <i class="fa-solid fa-circle-exclamation text-rose-500 text-base"></i>
    <span><strong>Gagal menghubungi Supabase:</strong> <?= e($apiError) ?></span>
</div>
<?php endif; ?>

<!-- Filter Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
    <form method="GET" action="disposisi.php" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
        <!-- Filter Status -->
        <div class="sm:col-span-5">
            <label class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Status Disposisi</label>
            <select name="status" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                <option value="">Semua Status</option>
                <option value="Diproses" <?= $filterStatus === 'Diproses' ? 'selected' : '' ?>>Diproses (Aktif)</option>
                <option value="Selesai" <?= $filterStatus === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>

        <!-- Filter Sifat -->
        <div class="sm:col-span-4">
            <label class="block text-[11px] font-bold text-slate-500 mb-1 uppercase tracking-wider">Sifat Disposisi</label>
            <select name="sifat" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                <option value="">Semua Sifat</option>
                <option value="Segera" <?= $filterSifat === 'Segera' ? 'selected' : '' ?>>Segera</option>
                <option value="Penting" <?= $filterSifat === 'Penting' ? 'selected' : '' ?>>Penting</option>
                <option value="Sangat Segera" <?= $filterSifat === 'Sangat Segera' ? 'selected' : '' ?>>Sangat Segera</option>
                <option value="Rahasia" <?= $filterSifat === 'Rahasia' ? 'selected' : '' ?>>Rahasia</option>
                <option value="Biasa" <?= $filterSifat === 'Biasa' ? 'selected' : '' ?>>Biasa</option>
            </select>
        </div>

        <!-- Action Button -->
        <div class="sm:col-span-3 flex items-end gap-2 pt-5">
            <button type="submit" class="flex-1 py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>Terapkan Filter</span>
            </button>
            <?php if (!empty($filterStatus) || !empty($filterSifat)): ?>
            <a href="disposisi.php" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs transition" title="Reset Filter">
                <i class="fa-solid fa-arrow-rotate-left"></i>
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Tabel Daftar Disposisi -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <div>
            Menampilkan <strong><?= count($disposisiList) ?></strong> lembar disposisi
        </div>
        <span class="text-[11px] bg-violet-50 text-violet-800 font-semibold px-2.5 py-1 rounded-full border border-violet-100">
            Tabel: disposisi (PostgREST)
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50/80 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                <tr>
                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                    <th class="py-3.5 px-4">Surat Rujukan</th>
                    <th class="py-3.5 px-4">Tujuan Unit</th>
                    <th class="py-3.5 px-4">Instruksi Disposisi</th>
                    <th class="py-3.5 px-4 text-center">Sifat &amp; Batas Waktu</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($disposisiList)): ?>
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400">
                        <i class="fa-regular fa-file-lines text-4xl mb-2 block text-slate-300"></i>
                        <p class="font-semibold text-slate-600">Belum ada disposisi yang diterbitkan.</p>
                        <p class="text-xs text-slate-400 mt-1">Klik tombol "Buat Disposisi Baru" di atas untuk menugaskan unit terkait.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($disposisiList as $disp): ?>
                    <?php 
                        // Dapatkan data surat_masuk baik dari embedded object atau dictionary fallback
                        $sm = $disp['surat_masuk'] ?? ($suratMasukMap[$disp['surat_masuk_id']] ?? null);
                        $sifatColor = match($disp['sifat'] ?? '') {
                            'Sangat Segera', 'Rahasia' => 'bg-rose-100 text-rose-800',
                            'Penting' => 'bg-amber-100 text-amber-800',
                            'Segera' => 'bg-sky-100 text-sky-800',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-3.5 px-4 text-center font-bold text-slate-400"><?= $no++ ?></td>
                        <td class="py-3.5 px-4">
                            <?php if ($sm): ?>
                                <span class="font-bold text-slate-900 block"><?= e($sm['nomor_surat']) ?></span>
                                <span class="text-[11px] text-slate-500 block truncate max-w-[200px]" title="<?= e($sm['pengirim']) ?>">
                                    Pengirim: <?= e($sm['pengirim']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-slate-400 italic">ID Surat: #<?= e($disp['surat_masuk_id']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-4 font-semibold text-slate-800 whitespace-nowrap">
                            <i class="fa-solid fa-building-user text-violet-500 mr-1"></i>
                            <?= e($disp['tujuan_unit']) ?>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <p class="text-slate-700 font-medium line-clamp-2" title="<?= e($disp['instruksi']) ?>">
                                <?= e($disp['instruksi']) ?>
                            </p>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Dibuat: <?= date('d M Y H:i', strtotime($disp['created_at'])) ?></span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold <?= $sifatColor ?>">
                                <?= e($disp['sifat'] ?? 'Segera') ?>
                            </span>
                            <?php if (!empty($disp['batas_waktu'])): ?>
                                <span class="block text-[10px] text-rose-600 font-semibold mt-1">
                                    <i class="fa-regular fa-clock"></i> <?= date('d M Y', strtotime($disp['batas_waktu'])) ?>
                                </span>
                            <?php else: ?>
                                <span class="block text-[10px] text-slate-400 mt-1">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <?php if (($disp['status'] ?? '') === 'Selesai'): ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-check"></i> Selesai
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-violet-100 text-violet-800 animate-pulse">
                                    <i class="fa-solid fa-spinner animate-spin text-[9px]"></i> Diproses
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <!-- Tombol Cetak Lembar Disposisi Resmi -->
                                <a href="cetak_disposisi.php?id=<?= $disp['id'] ?>" target="_blank"
                                   title="Cetak Lembar Disposisi"
                                   class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 hover:text-sky-800 transition">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </a>

                                <!-- Tombol Tandai Selesai -->
                                <?php if (($disp['status'] ?? '') !== 'Selesai'): ?>
                                <form method="POST" action="disposisi.php" class="inline" onsubmit="return confirm('Tandai disposisi ini sebagai Selesai?');">
                                    <input type="hidden" name="action" value="mark_complete">
                                    <input type="hidden" name="id" value="<?= $disp['id'] ?>">
                                    <button type="submit" 
                                        title="Tandai Selesai"
                                        class="p-2 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 hover:text-emerald-800 transition">
                                        <i class="fa-solid fa-check-double text-xs"></i>
                                    </button>
                                </form>
                                <?php endif; ?>

                                <!-- Tombol Hapus -->
                                <form method="POST" action="disposisi.php" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lembar disposisi ini?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $disp['id'] ?>">
                                    <button type="submit" 
                                        title="Hapus Disposisi"
                                        class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 hover:text-rose-800 transition">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL BUAT DISPOSISI BARU ================= -->
<div id="modal-add" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 <?= $preselectedSuratId > 0 ? '' : 'hidden' ?>">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-file-signature text-violet-600"></i>
                Penerbitan Lembar Disposisi
            </h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="disposisi.php" class="p-6 space-y-4">
            <input type="hidden" name="action" value="create">

            <!-- Pilih Surat Masuk -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Surat Masuk Rujukan <span class="text-rose-500">*</span></label>
                <select name="surat_masuk_id" required class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                    <option value="">-- Pilih Surat Masuk --</option>
                    <?php foreach ($suratMasukList as $sm): ?>
                    <option value="<?= $sm['id'] ?>" <?= ($preselectedSuratId === (int)$sm['id']) ? 'selected' : '' ?>>
                        <?= e($sm['nomor_surat']) ?> - <?= e($sm['pengirim']) ?> (<?= e($sm['perihal']) ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-[10px] text-slate-400 mt-1">Status surat masuk akan otomatis diubah menjadi 'Sudah Disposisi' setelah formulir ini disimpan.</p>
            </div>

            <!-- Tujuan Unit & Sifat -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tujuan Unit / Divisi <span class="text-rose-500">*</span></label>
                    <input type="text" name="tujuan_unit" required placeholder="Contoh: Divisi IT &amp; Infrastruktur"
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sifat Disposisi</label>
                    <select name="sifat" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                        <option value="Segera" selected>Segera</option>
                        <option value="Penting">Penting</option>
                        <option value="Sangat Segera">Sangat Segera</option>
                        <option value="Rahasia">Rahasia</option>
                        <option value="Biasa">Biasa</option>
                    </select>
                </div>
            </div>

            <!-- Instruksi Pimpinan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Instruksi Pimpinan <span class="text-rose-500">*</span></label>
                <textarea name="instruksi" rows="3" required placeholder="Tuliskan petunjuk atau arahan tindak lanjut kepada unit penerima..."
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none"></textarea>
            </div>

            <!-- Batas Waktu & Status -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Waktu (Tenggat)</label>
                    <input type="date" name="batas_waktu"
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Disposisi</label>
                    <select name="status" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-violet-500 outline-none">
                        <option value="Diproses" selected>Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-violet-600 hover:bg-violet-700 rounded-xl shadow-md transition">
                    Terbitkan Disposisi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('modal-add').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('modal-add').classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
