<?php
$page_title = 'Manajemen Surat Keluar';
require_once __DIR__ . '/includes/header.php';

// Handle Aksi Form (Tambah, Edit, Hapus)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // 1. TAMBAH SURAT KELUAR
    if ($action === 'create') {
        $nomor_surat = trim($_POST['nomor_surat'] ?? '');
        $tanggal_surat = trim($_POST['tanggal_surat'] ?? '');
        $tujuan = trim($_POST['tujuan'] ?? '');
        $perihal = trim($_POST['perihal'] ?? '');
        $kategori = trim($_POST['kategori'] ?? 'Umum');
        $penandatangan = trim($_POST['penandatangan'] ?? '');
        $status_kirim = trim($_POST['status_kirim'] ?? 'Terkirim');

        if (empty($nomor_surat) || empty($tujuan) || empty($perihal) || empty($penandatangan) || empty($tanggal_surat)) {
            set_flash('error', 'Semua kolom wajib diisi dengan lengkap.');
        } else {
            $payload = [
                'nomor_surat' => $nomor_surat,
                'tanggal_surat' => $tanggal_surat,
                'tujuan' => $tujuan,
                'perihal' => $perihal,
                'kategori' => $kategori,
                'penandatangan' => $penandatangan,
                'status_kirim' => $status_kirim
            ];

            $res = supabase_request('POST', 'surat_keluar', $payload);
            if ($res['code'] >= 200 && $res['code'] < 300) {
                set_flash('success', "Surat keluar dengan nomor '{$nomor_surat}' berhasil diterbitkan!");
            } else {
                $err = is_array($res['data']) && isset($res['data']['message']) ? $res['data']['message'] : ($res['error'] ?? 'Terjadi kesalahan');
                set_flash('error', "Gagal menerbitkan surat keluar: " . $err);
            }
        }
        header('Location: surat_keluar.php');
        exit;
    }

    // 2. EDIT SURAT KELUAR
    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $nomor_surat = trim($_POST['nomor_surat'] ?? '');
        $tanggal_surat = trim($_POST['tanggal_surat'] ?? '');
        $tujuan = trim($_POST['tujuan'] ?? '');
        $perihal = trim($_POST['perihal'] ?? '');
        $kategori = trim($_POST['kategori'] ?? 'Umum');
        $penandatangan = trim($_POST['penandatangan'] ?? '');
        $status_kirim = trim($_POST['status_kirim'] ?? 'Terkirim');

        if ($id <= 0 || empty($nomor_surat) || empty($tujuan) || empty($perihal) || empty($penandatangan)) {
            set_flash('error', 'Data tidak valid atau kolom penting masih kosong.');
        } else {
            $payload = [
                'nomor_surat' => $nomor_surat,
                'tanggal_surat' => $tanggal_surat,
                'tujuan' => $tujuan,
                'perihal' => $perihal,
                'kategori' => $kategori,
                'penandatangan' => $penandatangan,
                'status_kirim' => $status_kirim
            ];

            $res = supabase_request('PATCH', "surat_keluar?id=eq.{$id}", $payload);
            if ($res['code'] >= 200 && $res['code'] < 300) {
                set_flash('success', "Surat keluar '{$nomor_surat}' berhasil diperbarui!");
            } else {
                $err = is_array($res['data']) && isset($res['data']['message']) ? $res['data']['message'] : ($res['error'] ?? 'Terjadi kesalahan');
                set_flash('error', "Gagal memperbarui surat keluar: " . $err);
            }
        }
        header('Location: surat_keluar.php');
        exit;
    }

    // 3. HAPUS SURAT KELUAR
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $res = supabase_request('DELETE', "surat_keluar?id=eq.{$id}");
            if ($res['code'] >= 200 && $res['code'] < 300) {
                set_flash('success', "Surat keluar berhasil dihapus dari agenda.");
            } else {
                $err = is_array($res['data']) && isset($res['data']['message']) ? $res['data']['message'] : ($res['error'] ?? 'Terjadi kesalahan');
                set_flash('error', "Gagal menghapus surat keluar: " . $err);
            }
        }
        header('Location: surat_keluar.php');
        exit;
    }
}

// Pencarian & Filter
$searchQuery = trim($_GET['q'] ?? '');
$filterKategori = trim($_GET['kategori'] ?? '');
$filterStatusKirim = trim($_GET['status_kirim'] ?? '');

$endpoint = 'surat_keluar?order=tanggal_surat.desc,id.desc';

if (!empty($searchQuery)) {
    $encoded = urlencode($searchQuery);
    $endpoint .= "&or=(nomor_surat.ilike.*{$encoded}*,perihal.ilike.*{$encoded}*,tujuan.ilike.*{$encoded}*,penandatangan.ilike.*{$encoded}*)";
}

if (!empty($filterKategori)) {
    $endpoint .= "&kategori=eq." . urlencode($filterKategori);
}

if (!empty($filterStatusKirim)) {
    $endpoint .= "&status_kirim=eq." . urlencode($filterStatusKirim);
}

$suratKeluarList = [];
$apiError = null;

if ($isConfigured) {
    $response = supabase_request('GET', $endpoint);
    if ($response['code'] >= 200 && $response['code'] < 300 && is_array($response['data'])) {
        $suratKeluarList = $response['data'];
    } else {
        $apiError = $response['error'] ?? ($response['data']['message'] ?? 'Gagal memuat data surat keluar.');
    }
}
?>

<!-- Header Halaman & Tombol Aksi Tambah -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-xs">
    <div>
        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            Agenda Surat Keluar
        </h2>
        <p class="text-xs text-slate-500 mt-1">Registrasi surat dinas keluar, pengesahan penandatangan, dan cetak naskah surat.</p>
    </div>
    <div class="flex items-center gap-3">
        <button type="button" onclick="openAddModal()" 
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 active:bg-amber-800 text-white text-xs font-bold shadow-md shadow-amber-600/20 transition-all cursor-pointer">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Surat Keluar</span>
        </button>
    </div>
</div>

<?php if ($apiError): ?>
<div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
    <i class="fa-solid fa-circle-exclamation text-rose-500 text-base"></i>
    <span><strong>Gagal menghubungi Supabase:</strong> <?= e($apiError) ?></span>
</div>
<?php endif; ?>

<!-- Filter & Pencarian Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs">
    <form method="GET" action="surat_keluar.php" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
        <!-- Input Search Keyword -->
        <div class="sm:col-span-5 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-xs"></i>
            </div>
            <input type="text" name="q" value="<?= e($searchQuery) ?>"
                placeholder="Cari nomor surat, tujuan, perihal, atau penandatangan..."
                class="w-full pl-9 pr-4 py-2 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
        </div>

        <!-- Filter Kategori -->
        <div class="sm:col-span-3">
            <select name="kategori" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                <option value="">Semua Kategori</option>
                <option value="Pemberitahuan" <?= $filterKategori === 'Pemberitahuan' ? 'selected' : '' ?>>Pemberitahuan</option>
                <option value="Undangan" <?= $filterKategori === 'Undangan' ? 'selected' : '' ?>>Undangan</option>
                <option value="Permohonan" <?= $filterKategori === 'Permohonan' ? 'selected' : '' ?>>Permohonan</option>
                <option value="Edaran" <?= $filterKategori === 'Edaran' ? 'selected' : '' ?>>Edaran</option>
                <option value="Keterangan" <?= $filterKategori === 'Keterangan' ? 'selected' : '' ?>>Keterangan</option>
                <option value="Umum" <?= $filterKategori === 'Umum' ? 'selected' : '' ?>>Umum</option>
            </select>
        </div>

        <!-- Filter Status Kirim -->
        <div class="sm:col-span-2">
            <select name="status_kirim" class="w-full py-2 px-3 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                <option value="">Semua Status</option>
                <option value="Terkirim" <?= $filterStatusKirim === 'Terkirim' ? 'selected' : '' ?>>Terkirim</option>
                <option value="Draft" <?= $filterStatusKirim === 'Draft' ? 'selected' : '' ?>>Draft</option>
                <option value="Tertunda" <?= $filterStatusKirim === 'Tertunda' ? 'selected' : '' ?>>Tertunda</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="sm:col-span-2 flex items-center gap-2">
            <button type="submit" class="flex-1 py-2 px-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>Filter</span>
            </button>
            <?php if (!empty($searchQuery) || !empty($filterKategori) || !empty($filterStatusKirim)): ?>
            <a href="surat_keluar.php" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs transition" title="Reset Filter">
                <i class="fa-solid fa-arrow-rotate-left"></i>
            </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Tabel Data Surat Keluar -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="p-4 border-b border-slate-100 flex items-center justify-between text-xs text-slate-500">
        <div>
            Menampilkan <strong><?= count($suratKeluarList) ?></strong> surat keluar
            <?php if (!empty($searchQuery)): ?>
                untuk "<strong><?= e($searchQuery) ?></strong>"
            <?php endif; ?>
        </div>
        <span class="text-[11px] bg-amber-50 text-amber-800 font-semibold px-2.5 py-1 rounded-full border border-amber-100">
            Tabel: surat_keluar (PostgREST)
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50/80 text-slate-700 font-bold uppercase tracking-wider text-[11px] border-b border-slate-100">
                <tr>
                    <th class="py-3.5 px-4 w-12 text-center">No</th>
                    <th class="py-3.5 px-4">Nomor &amp; Tanggal Surat</th>
                    <th class="py-3.5 px-4">Tujuan Penerima</th>
                    <th class="py-3.5 px-4">Perihal &amp; Kategori</th>
                    <th class="py-3.5 px-4">Penandatangan</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($suratKeluarList)): ?>
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400">
                        <i class="fa-regular fa-paper-plane text-4xl mb-2 block text-slate-300"></i>
                        <p class="font-semibold text-slate-600">Tidak ada surat keluar tercatat.</p>
                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol "Tambah Surat Keluar" untuk menerbitkan surat baru.</p>
                    </td>
                </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($suratKeluarList as $sk): ?>
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="py-3.5 px-4 text-center font-bold text-slate-400"><?= $no++ ?></td>
                        <td class="py-3.5 px-4">
                            <span class="font-bold text-slate-900 block"><?= e($sk['nomor_surat']) ?></span>
                            <span class="text-[11px] text-slate-400 flex items-center gap-1 mt-0.5">
                                <i class="fa-regular fa-calendar text-[10px]"></i> <?= date('d M Y', strtotime($sk['tanggal_surat'])) ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-800 block"><?= e($sk['tujuan']) ?></span>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <p class="font-medium text-slate-700 line-clamp-2" title="<?= e($sk['perihal']) ?>">
                                <?= e($sk['perihal']) ?>
                            </p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-600">
                                <?= e($sk['kategori'] ?? 'Umum') ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-4 whitespace-nowrap font-medium text-slate-700">
                            <i class="fa-solid fa-signature text-slate-400 mr-1"></i>
                            <?= e($sk['penandatangan']) ?>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <?php 
                                $statusStyle = match($sk['status_kirim'] ?? '') {
                                    'Terkirim' => 'bg-emerald-100 text-emerald-800',
                                    'Draft' => 'bg-slate-100 text-slate-700',
                                    'Tertunda' => 'bg-amber-100 text-amber-800',
                                    default => 'bg-sky-100 text-sky-800'
                                };
                            ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold <?= $statusStyle ?>">
                                <i class="fa-solid fa-circle-check text-[9px]"></i>
                                <?= e($sk['status_kirim'] ?? 'Terkirim') ?>
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1">
                                <!-- Tombol Cetak / Preview Surat (Siap Cetak window.print) -->
                                <a href="cetak_surat_keluar.php?id=<?= $sk['id'] ?>" target="_blank"
                                   title="Cetak / Preview Naskah Surat Resmi"
                                   class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 hover:text-sky-800 transition">
                                    <i class="fa-solid fa-print text-xs"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <button type="button" 
                                    onclick='openEditModal(<?= json_encode($sk, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'
                                    title="Edit Surat"
                                    class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 hover:text-amber-800 transition">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form method="POST" action="surat_keluar.php" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus surat keluar nomor: <?= e($sk['nomor_surat']) ?>?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $sk['id'] ?>">
                                    <button type="submit" 
                                        title="Hapus Surat"
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

<!-- ================= MODAL TAMBAH SURAT KELUAR ================= -->
<div id="modal-add" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-amber-600"></i>
                Tambah Surat Keluar Baru
            </h3>
            <button onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="surat_keluar.php" class="p-6 space-y-4">
            <input type="hidden" name="action" value="create">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Surat Dinas <span class="text-rose-500">*</span></label>
                <input type="text" name="nomor_surat" required placeholder="Contoh: 015/SK/SEKRET/XI/2026"
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Surat <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_surat" required value="<?= date('Y-m-d') ?>"
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Surat</label>
                    <select name="kategori" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <option value="Umum">Umum</option>
                        <option value="Pemberitahuan">Pemberitahuan</option>
                        <option value="Undangan">Undangan</option>
                        <option value="Permohonan">Permohonan</option>
                        <option value="Edaran">Edaran</option>
                        <option value="Keterangan">Keterangan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tujuan Penerima (Kepada Yth.) <span class="text-rose-500">*</span></label>
                <input type="text" name="tujuan" required placeholder="Contoh: Seluruh Kepala Divisi Operasional"
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Perihal Surat <span class="text-rose-500">*</span></label>
                <textarea name="perihal" rows="3" required placeholder="Tuliskan perihal atau isi pokok naskah dinas..."
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Penandatangan Pejabat <span class="text-rose-500">*</span></label>
                    <input type="text" name="penandatangan" required placeholder="Contoh: Kepala Sekretariat"
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Pengiriman</label>
                    <select name="status_kirim" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <option value="Terkirim" selected>Terkirim</option>
                        <option value="Draft">Draft</option>
                        <option value="Tertunda">Tertunda</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-md transition">
                    Terbitkan Surat Keluar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT SURAT KELUAR ================= -->
<div id="modal-edit" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-amber-600"></i>
                Edit Data Surat Keluar
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="surat_keluar.php" class="p-6 space-y-4">
            <input type="hidden" name="action" value="update">
            <input type="hidden" id="edit_id" name="id">

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Surat Dinas <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_nomor_surat" name="nomor_surat" required
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Surat <span class="text-rose-500">*</span></label>
                    <input type="date" id="edit_tanggal_surat" name="tanggal_surat" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Surat</label>
                    <select id="edit_kategori" name="kategori" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <option value="Umum">Umum</option>
                        <option value="Pemberitahuan">Pemberitahuan</option>
                        <option value="Undangan">Undangan</option>
                        <option value="Permohonan">Permohonan</option>
                        <option value="Edaran">Edaran</option>
                        <option value="Keterangan">Keterangan</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Tujuan Penerima <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_tujuan" name="tujuan" required
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Perihal Surat <span class="text-rose-500">*</span></label>
                <textarea id="edit_perihal" name="perihal" rows="3" required
                    class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Penandatangan Pejabat <span class="text-rose-500">*</span></label>
                    <input type="text" id="edit_penandatangan" name="penandatangan" required
                        class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Pengiriman</label>
                    <select id="edit_status_kirim" name="status_kirim" class="w-full px-3 py-2 text-xs bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none">
                        <option value="Terkirim">Terkirim</option>
                        <option value="Draft">Draft</option>
                        <option value="Tertunda">Tertunda</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-md transition">
                    Simpan Perubahan
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

    function openEditModal(data) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_nomor_surat').value = data.nomor_surat || '';
        document.getElementById('edit_tanggal_surat').value = data.tanggal_surat || '';
        document.getElementById('edit_tujuan').value = data.tujuan || '';
        document.getElementById('edit_perihal').value = data.perihal || '';
        document.getElementById('edit_kategori').value = data.kategori || 'Umum';
        document.getElementById('edit_penandatangan').value = data.penandatangan || '';
        document.getElementById('edit_status_kirim').value = data.status_kirim || 'Terkirim';
        
        document.getElementById('modal-edit').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('modal-edit').classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
