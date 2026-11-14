<?php
require_once __DIR__ . '/config/supabase.php';
require_auth();

$id = (int)($_GET['id'] ?? 0);
$disposisi = null;
$surat_masuk = null;

if ($id > 0 && is_supabase_configured()) {
    $res = supabase_request('GET', "disposisi?select=*,surat_masuk(*)&id=eq.{$id}");
    if ($res['code'] >= 200 && $res['code'] < 300 && is_array($res['data']) && count($res['data']) > 0) {
        $disposisi = $res['data'][0];
        $surat_masuk = $disposisi['surat_masuk'] ?? null;
    } else {
        // Fallback jika tidak embedded
        $fb = supabase_request('GET', "disposisi?id=eq.{$id}");
        if ($fb['code'] >= 200 && is_array($fb['data']) && count($fb['data']) > 0) {
            $disposisi = $fb['data'][0];
            $smId = $disposisi['surat_masuk_id'];
            $resSm = supabase_request('GET', "surat_masuk?id=eq.{$smId}");
            if ($resSm['code'] >= 200 && is_array($resSm['data']) && count($resSm['data']) > 0) {
                $surat_masuk = $resSm['data'][0];
            }
        }
    }
}

if (!$disposisi) {
    die("Lembar disposisi tidak ditemukan atau Supabase belum terhubung.");
}

function tgl_indo($tanggal) {
    if (empty($tanggal)) return '-';
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));
    return (int)$pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi - <?= e($surat_masuk['nomor_surat'] ?? ('#' . $disposisi['id'])) ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .no-print {
                display: none !important;
            }
            .page-sheet {
                box-shadow: none !important;
                border: 2px solid #000 !important;
                margin: 0 !important;
                padding: 1cm !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10">

    <!-- Action Toolbar (Hidden saat print) -->
    <div class="no-print max-w-3xl mx-auto mb-6 px-4 flex items-center justify-between">
        <a href="disposisi.php" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-sans text-xs font-bold rounded-xl transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Disposisi</span>
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white font-sans text-xs font-bold rounded-xl shadow-lg shadow-violet-600/30 transition">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Lembar Disposisi</span>
            </button>
        </div>
    </div>

    <!-- Lembar Disposisi Standar Kedinasan -->
    <div class="page-sheet max-w-3xl mx-auto bg-white p-8 sm:p-10 shadow-xl border-2 border-black text-black">
        
        <!-- Header / Kop Disposisi Resmi Pemdes Ngembe -->
        <div class="border-b-2 border-black pb-4 text-center">
            <div class="flex items-center justify-center gap-3">
                <i class="fa-solid fa-landmark text-2xl"></i>
                <div>
                    <h2 class="text-xs font-extrabold tracking-widest uppercase font-sans">Pemerintah Kabupaten Pasuruan &bull; Kecamatan Beji</h2>
                    <h1 class="text-lg font-black uppercase tracking-wider font-sans">Kantor Kepala Desa Ngembe</h1>
                    <p class="text-[11px] italic font-sans text-slate-700">Jl. Balai Desa Ngembe No. 01, Dusun Ngembe, Kec. Beji, Kab. Pasuruan 67154</p>
                </div>
            </div>
            <div class="mt-3 py-1 bg-black text-white text-center font-bold text-sm tracking-widest uppercase font-sans">
                LEMBAR DISPOSISI KEPALA DESA NGEMBE
            </div>
        </div>

        <!-- Tabel Informasi Surat Masuk Rujukan -->
        <table class="w-full border-collapse border border-black mt-4 text-xs">
            <tbody>
                <tr>
                    <td class="border border-black p-2 font-bold w-1/4 bg-slate-100">Surat Dari / Pengirim</td>
                    <td class="border border-black p-2 font-semibold w-3/4"><?= e($surat_masuk['pengirim'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="border border-black p-2 font-bold bg-slate-100">Nomor Surat</td>
                    <td class="border border-black p-2 font-mono font-bold"><?= e($surat_masuk['nomor_surat'] ?? '-') ?></td>
                </tr>
                <tr>
                    <td class="border border-black p-2 font-bold bg-slate-100">Tanggal Surat</td>
                    <td class="border border-black p-2"><?= tgl_indo($surat_masuk['tanggal_surat'] ?? '') ?></td>
                </tr>
                <tr>
                    <td class="border border-black p-2 font-bold bg-slate-100">Tanggal Diterima</td>
                    <td class="border border-black p-2"><?= tgl_indo($surat_masuk['tanggal_terima'] ?? '') ?></td>
                </tr>
                <tr>
                    <td class="border border-black p-2 font-bold bg-slate-100">Perihal / Hal</td>
                    <td class="border border-black p-2 font-medium"><?= e($surat_masuk['perihal'] ?? '-') ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Klasifikasi Sifat Disposisi (Checkbox-style) -->
        <div class="border-x border-b border-black p-3 bg-slate-50 flex items-center justify-around text-xs font-bold">
            <span class="text-slate-600">Sifat Disposisi:</span>
            <?php 
                $sifatList = ['Sangat Segera', 'Segera', 'Penting', 'Rahasia', 'Biasa'];
                foreach ($sifatList as $s):
                    $isChecked = strtolower($disposisi['sifat']) === strtolower($s);
            ?>
            <label class="inline-flex items-center gap-1.5">
                <span class="w-4 h-4 rounded border border-black inline-flex items-center justify-center font-bold text-[10px] <?= $isChecked ? 'bg-black text-white' : 'bg-white' ?>">
                    <?= $isChecked ? '✓' : '' ?>
                </span>
                <span><?= $s ?></span>
            </label>
            <?php endforeach; ?>
        </div>

        <!-- Tujuan Unit & Batas Waktu -->
        <table class="w-full border-collapse border border-black text-xs">
            <tbody>
                <tr>
                    <td class="border border-black p-3 font-bold w-1/4 bg-slate-100">Diteruskan Kepada</td>
                    <td class="border border-black p-3 font-bold text-sm text-violet-900">
                        <i class="fa-solid fa-arrow-right text-xs mr-1 text-black"></i>
                        <?= e($disposisi['tujuan_unit']) ?>
                    </td>
                </tr>
                <tr>
                    <td class="border border-black p-3 font-bold bg-slate-100">Batas Waktu Tindak Lanjut</td>
                    <td class="border border-black p-3 font-bold text-rose-700">
                        <?= !empty($disposisi['batas_waktu']) ? tgl_indo($disposisi['batas_waktu']) : 'Tidak ada batas waktu khusus' ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Instruksi Pimpinan -->
        <div class="border-x border-b border-black p-4">
            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-700 mb-2">Instruksi / Catatan Pimpinan:</h4>
            <div class="p-3 bg-amber-50/50 border border-amber-200 rounded min-h-[100px] text-xs leading-relaxed font-medium">
                <?= nl2br(e($disposisi['instruksi'])) ?>
            </div>
        </div>

        <!-- Kolom Tanda Tangan & Paraf Pengesahan -->
        <div class="border-x border-b border-black grid grid-cols-2 text-xs text-center">
            <div class="p-4 border-r border-black">
                <p class="font-bold">Paraf Penerima Disposisi</p>
                <div class="h-20 flex items-center justify-center text-slate-400 italic text-[11px]">
                    ( .................................................. )
                </div>
                <p class="text-[11px] text-slate-600">Unit: <?= e($disposisi['tujuan_unit']) ?></p>
            </div>
            <div class="p-4">
                <p class="font-bold">Kepala Desa Ngembe</p>
                <div class="h-20 flex items-center justify-center text-slate-400 italic text-[11px]">
                    ( <?= e(KADES_NAME) ?> )
                </div>
                <p class="text-[11px] text-slate-600">Pemerintah Desa Ngembe</p>
            </div>
        </div>

        <!-- Catatan Tambahan -->
        <div class="mt-4 text-[10px] text-slate-500 flex items-center justify-between">
            <span>ID Disposisi: #<?= e($disposisi['id']) ?> &bull; Tanggal Cetak: <?= date('d/m/Y H:i') ?></span>
            <span>Status: <strong><?= e($disposisi['status']) ?></strong></span>
        </div>

    </div>

</body>
</html>
