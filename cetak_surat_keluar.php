<?php
require_once __DIR__ . '/config/supabase.php';
require_auth();

$id = (int)($_GET['id'] ?? 0);
$surat = null;

if ($id > 0 && is_supabase_configured()) {
    $res = supabase_request('GET', "surat_keluar?id=eq.{$id}");
    if ($res['code'] >= 200 && $res['code'] < 300 && is_array($res['data']) && count($res['data']) > 0) {
        $surat = $res['data'][0];
    }
}

if (!$surat) {
    // Fallback data demo jika dibuka tanpa database terisi
    $surat = [
        'nomor_surat' => '012/SK/PEMDES-NGB/XI/2026',
        'kategori' => 'Pemberitahuan',
        'perihal' => 'Pemberitahuan Kerja Bakti Saluran Irigasi dan Penataan Lingkungan Desa',
        'tanggal_surat' => date('Y-m-d'),
        'tujuan' => 'Seluruh Kepala Dusun (Ngembe, Krikilan, Grogolan, Simpar) & Ketua RT/RW',
        'penandatangan' => KADES_NAME
    ];
}

// Format tanggal Indonesia
function tanggal_indo($tanggal) {
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
    <title>Cetak Surat Keluar Resmi &bull; <?= e(DESA_NAME) ?> - <?= e($surat['nomor_surat']) ?></title>
    
    <!-- Google Fonts & Tailwind -->
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background-color: #f8fafc;
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
                border: none !important;
                margin: 0 !important;
                padding: 1.5cm 2cm !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-6 sm:py-10">

    <!-- Action Toolbar (Hidden saat print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 px-4 flex items-center justify-between">
        <a href="surat_keluar.php" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-sans text-xs font-bold rounded-xl transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Surat Keluar</span>
        </a>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-sans text-xs font-bold rounded-xl shadow-lg shadow-emerald-600/30 transition">
                <i class="fa-solid fa-print"></i>
                <span>Cetak / Simpan PDF (Print)</span>
            </button>
        </div>
    </div>

    <!-- Halaman Kertas Resmi Format Standar Instansi -->
    <div class="page-sheet max-w-4xl mx-auto bg-white p-10 sm:p-14 shadow-xl border border-slate-200 text-black leading-relaxed">
        
        <!-- KOP SURAT RESMI PEMERINTAH DESA NGEMBE -->
        <div class="border-b-[3px] border-black pb-2 text-center relative">
            <div class="flex items-center justify-center gap-5 mb-2">
                <div class="w-16 h-16 rounded-full border-2 border-black flex items-center justify-center text-3xl font-bold font-sans">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold tracking-widest uppercase font-sans">Pemerintah Kabupaten Pasuruan</h3>
                    <h2 class="text-xl font-bold uppercase tracking-wider font-sans mt-0.5">Kecamatan Beji</h2>
                    <h1 class="text-2xl font-black uppercase tracking-tight font-sans">Kantor Kepala Desa Ngembe</h1>
                    <p class="text-xs italic mt-1 font-sans">Jl. Balai Desa Ngembe No. 01, Dusun Ngembe, Kec. Beji, Kab. Pasuruan 67154 &bull; Email: pemdes@ngembe.desa.id</p>
                </div>
            </div>
            <!-- Garis ganda kop surat -->
            <div class="border-b border-black mt-1"></div>
        </div>

        <!-- Tanggal dan Nomor Surat -->
        <div class="mt-6 flex justify-between items-start text-sm">
            <table class="w-2/3 text-sm">
                <tr>
                    <td class="w-24 align-top py-0.5">Nomor</td>
                    <td class="w-4 align-top py-0.5">:</td>
                    <td class="font-bold py-0.5"><?= e($surat['nomor_surat']) ?></td>
                </tr>
                <tr>
                    <td class="align-top py-0.5">Sifat</td>
                    <td class="align-top py-0.5">:</td>
                    <td class="py-0.5"><?= e($surat['kategori'] ?? 'Penting') ?></td>
                </tr>
                <tr>
                    <td class="align-top py-0.5">Lampiran</td>
                    <td class="align-top py-0.5">:</td>
                    <td class="py-0.5">1 (Satu) Berkas</td>
                </tr>
                <tr>
                    <td class="align-top py-0.5">Hal</td>
                    <td class="align-top py-0.5">:</td>
                    <td class="font-bold underline py-0.5"><?= e($surat['perihal']) ?></td>
                </tr>
            </table>

            <div class="text-right text-sm">
                <p>Ngembe, <?= tanggal_indo($surat['tanggal_surat']) ?></p>
            </div>
        </div>

        <!-- Tujuan Surat -->
        <div class="mt-8 text-sm leading-relaxed">
            <p>Kepada Yth.</p>
            <p class="font-bold text-base mt-1"><?= e($surat['tujuan']) ?></p>
            <p>di &mdash;</p>
            <p class="ml-4 font-semibold">Tempat</p>
        </div>

        <!-- Isi Naskah Dinas -->
        <div class="mt-8 text-base text-justify leading-loose space-y-4">
            <p>
                Dengan hormat,
            </p>
            <p class="indent-8">
                Sehubungan dengan penyelenggaraan ketertiban umum dan peningkatan tata kelola administrasi pemerintahan Desa Ngembe, bersama surat resmi ini kami sampaikan mengenai perihal <strong>"<?= e($surat['perihal']) ?>"</strong> guna diketahui dan ditindaklanjuti sebagaimana mestinya oleh pihak terkait.
            </p>
            <p class="indent-8">
                Demikian surat pemberitahuan kedinasan ini kami sampaikan. Atas perhatian, dukungan, dan kerja sama yang baik dari seluruh pihak, kami ucapkan terima kasih.
            </p>
        </div>

        <!-- Tanda Tangan Pejabat Kades -->
        <div class="mt-16 flex justify-end text-sm">
            <div class="w-72 text-center">
                <p class="font-semibold">Kepala Desa Ngembe,</p>
                
                <!-- Ruang tanda tangan dan stempel resmi -->
                <div class="h-24 my-2 flex items-center justify-center text-slate-400 italic text-xs">
                    <span class="border border-dashed border-slate-300 p-2 rounded">
                        [ Tanda Tangan &amp; Cap Stempel Resmi Kepala Desa ]
                    </span>
                </div>

                <p class="font-bold underline text-base"><?= e($surat['penandatangan'] ?: KADES_NAME) ?></p>
                <p class="text-xs text-slate-600">Pemerintah Desa Ngembe</p>
            </div>
        </div>

        <!-- Catatan Kaki / Tembusan -->
        <div class="mt-12 pt-4 border-t border-slate-300 text-xs text-slate-600 font-sans">
            <p class="font-bold">Tembusan disampaikan kepada Yth:</p>
            <ol class="list-decimal list-inside ml-2 mt-1 space-y-0.5">
                <li>Camat Beji Kabupaten Pasuruan (sebagai laporan)</li>
                <li>Ketua BPD Desa Ngembe</li>
                <li>Arsip Sekretariat Desa Ngembe</li>
            </ol>
        </div>

    </div>

</body>
</html>
