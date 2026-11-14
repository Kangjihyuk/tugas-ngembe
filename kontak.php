<?php
$page_title = 'Kontak & Pengaduan Warga';
require_once __DIR__ . '/config/supabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_pengaduan') {
    $nama = trim($_POST['nama'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $dusun = trim($_POST['dusun'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'Umum');
    $pesan = trim($_POST['pesan'] ?? '');

    if (empty($nama) || empty($pesan)) {
        set_flash('error', 'Mohon lengkapi nama dan isi pesan aspirasi / aduan Anda.');
    } else {
        save_pengaduan([
            'nama' => $nama,
            'no_hp' => $no_hp,
            'dusun' => $dusun,
            'kategori' => $kategori,
            'pesan' => $pesan
        ]);
        set_flash('success', 'Aspirasi / pengaduan Anda telah kami terima dan akan segera ditindaklanjuti oleh aparat Pemerintah Desa Ngembe.');
    }
    header('Location: kontak.php#aspirasi');
    exit;
}

require_once __DIR__ . '/includes/public_header.php';
?>

<!-- Header Banner Halaman -->
<div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white py-14">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Pusat Bantuan &amp; Alamat</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mt-2">Kontak Balai Desa &amp; Layanan Pengaduan</h1>
        <p class="text-sm text-slate-300 mt-2 max-w-2xl">
            Hubungi kami untuk informasi administrasi, layanan darurat warga, atau sampaikan saran dan kritik membangun untuk kemajuan Desa Ngembe.
        </p>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

        <!-- KARTU INFORMASI KONTAK & JAM PELAYANAN -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase">Alamat Kantor</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    <?= e(ALAMAT_KANTOR) ?>
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase">Jam Pelayanan</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Senin &ndash; Kamis: 08.00 &ndash; 15.00 WIB<br>
                    Jumat: 08.00 &ndash; 14.30 WIB<br>
                    <span class="text-rose-600 font-semibold">Sabtu - Minggu: Libur</span>
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center text-xl mb-4">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase">WhatsApp Hotline</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Pelayanan cepat &amp; konfirmasi surat:<br>
                    <a href="https://wa.me/6285233445566" target="_blank" class="font-bold text-emerald-700 text-sm hover:underline">0852-3344-5566</a>
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase">Surel Elektronik (Email)</h3>
                <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                    Korespondensi kedinasan:<br>
                    <a href="mailto:<?= e(EMAIL_DESA) ?>" class="font-bold text-slate-800 hover:text-emerald-600"><?= e(EMAIL_DESA) ?></a>
                </p>
            </div>

        </div>

        <!-- KONTAK DARURAT & PEMBINA DESA -->
        <section class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white p-8 sm:p-10 rounded-3xl shadow-xl">
            <div class="max-w-3xl mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-300 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">Siaga Warga</span>
                <h2 class="text-2xl font-extrabold mt-2">Kontak Darurat &amp; Keamanan Desa</h2>
                <p class="text-xs sm:text-sm text-slate-300 mt-1">Simpan nomor-nomor penting ini untuk kebutuhan pertolongan medis dan situasi darurat di lingkungan Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                
                <div class="bg-white/10 p-4 rounded-2xl border border-white/10 space-y-1">
                    <span class="text-emerald-300 font-bold block"><i class="fa-solid fa-kit-medical mr-1.5"></i> Ambulans Desa Siaga</span>
                    <p class="text-base font-extrabold text-white">0852-9988-1122</p>
                    <p class="text-[11px] text-slate-300">Siap melayani 24 jam</p>
                </div>

                <div class="bg-white/10 p-4 rounded-2xl border border-white/10 space-y-1">
                    <span class="text-emerald-300 font-bold block"><i class="fa-solid fa-user-doctor mr-1.5"></i> Bidan Desa Ngembe</span>
                    <p class="text-base font-extrabold text-white">0813-4455-6677</p>
                    <p class="text-[11px] text-slate-300">Persalinan &amp; darurat balita</p>
                </div>

                <div class="bg-white/10 p-4 rounded-2xl border border-white/10 space-y-1">
                    <span class="text-emerald-300 font-bold block"><i class="fa-solid fa-shield-halved mr-1.5"></i> Babinsa (TNI Beji)</span>
                    <p class="text-base font-extrabold text-white">0821-3322-1100</p>
                    <p class="text-[11px] text-slate-300">Pembina Keamanan Teritorial</p>
                </div>

                <div class="bg-white/10 p-4 rounded-2xl border border-white/10 space-y-1">
                    <span class="text-emerald-300 font-bold block"><i class="fa-solid fa-handcuffs mr-1.5"></i> Bhabinkamtibmas (Polri)</span>
                    <p class="text-base font-extrabold text-white">0857-7788-9900</p>
                    <p class="text-[11px] text-slate-300">Polsek Beji Res Pasuruan</p>
                </div>

            </div>
        </section>

        <!-- FORM ASPIRASI & PETA BALAI DESA -->
        <section id="aspirasi" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start scroll-mt-24">
            
            <!-- Form Aspirasi -->
            <div class="lg:col-span-6 bg-slate-50 border border-slate-200 p-6 sm:p-8 rounded-3xl shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-xl shadow-md">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Formulir Aspirasi &amp; Pengaduan</h3>
                        <p class="text-xs text-slate-500">Saran, masukan, dan pengaduan Anda sangat berharga bagi kami</p>
                    </div>
                </div>

                <form action="kontak.php" method="POST" class="space-y-4 text-xs">
                    <input type="hidden" name="action" value="kirim_pengaduan">

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" name="nama" required placeholder="Nama Anda atau inisial" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                            <input type="text" name="no_hp" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                        </div>
                        <div>
                            <label class="block font-semibold text-slate-700 mb-1">Wilayah Dusun *</label>
                            <select name="dusun" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                                <option value="Dusun Ngembe">Dusun Ngembe</option>
                                <option value="Dusun Krikilan">Dusun Krikilan</option>
                                <option value="Dusun Grogolan">Dusun Grogolan</option>
                                <option value="Dusun Simpar">Dusun Simpar</option>
                                <option value="Luar Desa">Masyarakat Luar Desa / Wisatawan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kategori Masalah *</label>
                        <select name="kategori" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                            <option value="Pelayanan Publik">Pelayanan Administrasi &amp; Loket Surat</option>
                            <option value="Infrastruktur & Jalan">Jalan Dusun, Jembatan, &amp; Irigasi</option>
                            <option value="Lingkungan & Wisata">Sampah, Lingkungan, &amp; Wisata Grojokan Limo</option>
                            <option value="Sosial & Bantuan">Sosial, Bantuan Masyarakat, &amp; Kesehatan</option>
                            <option value="Lainnya">Lainnya / Saran Pembangunan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Uraian Pesan / Pengaduan *</label>
                        <textarea name="pesan" rows="4" required placeholder="Tuliskan secara ringkas dan jelas apa yang ingin Anda sampaikan..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"></textarea>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Aspirasi ke Balai Desa</span>
                    </button>
                </form>
            </div>

            <!-- Peta Lokasi Google Maps -->
            <div class="lg:col-span-6 space-y-4">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                    <h3 class="text-lg font-bold text-slate-900">Lokasi Kantor Kepala Desa Ngembe</h3>
                    <p class="text-xs text-slate-500">
                        Mudah dijangkau dari jalan raya Beji maupun Pandaan. Tersedia area parkir kendaraan yang memadai bagi warga yang hendak berurusan dinas.
                    </p>
                    
                    <div class="rounded-2xl overflow-hidden border border-slate-200 h-80 bg-slate-100">
                        <iframe 
                            title="Lokasi Kantor Balai Desa Ngembe Beji Pasuruan"
                            src="https://maps.google.com/maps?q=Kantor+Balai+Desa+Ngembe+Beji+Pasuruan&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                            class="w-full h-full border-0" 
                            loading="lazy" 
                            allowfullscreen>
                        </iframe>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-2">
                        <span class="text-slate-500">Kecamatan Beji &bull; Pasuruan</span>
                        <a href="https://maps.google.com/?q=Kantor+Balai+Desa+Ngembe+Beji+Pasuruan" target="_blank" class="text-emerald-600 font-bold hover:underline flex items-center gap-1">
                            Buka Aplikasi Google Maps <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/includes/public_footer.php'; ?>
