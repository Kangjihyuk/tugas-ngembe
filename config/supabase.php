<?php
/**
 * Website Resmi Pemerintah Desa Ngembe
 * Kecamatan Beji, Kabupaten Pasuruan, Jawa Timur
 * Konfigurasi Supabase REST API & Helper Functions
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Parser .env sederhana tanpa dependency external
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
            continue;
        }
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        // Hapus tanda petik pembungkus jika ada
        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }
        $_ENV[$name] = $value;
        putenv("$name=$value");
    }
    return true;
}

// Muat file .env dari root direktori proyek
loadEnv(__DIR__ . '/../.env');

// Konfigurasi aplikasi dari environment variable atau nilai default
define('APP_NAME', $_ENV['APP_NAME'] ?? 'Pemerintah Desa Ngembe');
define('DESA_NAME', $_ENV['DESA_NAME'] ?? 'Desa Ngembe');
define('KECAMATAN', $_ENV['KECAMATAN'] ?? 'Kecamatan Beji');
define('KABUPATEN', $_ENV['KABUPATEN'] ?? 'Kabupaten Pasuruan');
define('PROVINSI', $_ENV['PROVINSI'] ?? 'Jawa Timur');
define('KODE_POS', $_ENV['KODE_POS'] ?? '67154');
define('ALAMAT_KANTOR', $_ENV['ALAMAT_KANTOR'] ?? 'Jl. Balai Desa Ngembe No. 01, Dusun Ngembe, Kec. Beji, Kab. Pasuruan, Jawa Timur 67154');
define('EMAIL_DESA', $_ENV['EMAIL_DESA'] ?? 'pemdes@ngembe.desa.id');
define('TELP_DESA', $_ENV['TELP_DESA'] ?? '(0343) 631234 / 0852-3344-5566');
define('KADES_NAME', $_ENV['KADES_NAME'] ?? "Mochammad Syafi'i");

define('SUPABASE_URL', $_ENV['SUPABASE_URL'] ?? '');
define('SUPABASE_KEY', $_ENV['SUPABASE_KEY'] ?? '');
define('ADMIN_USER', $_ENV['ADMIN_USER'] ?? 'admin');
define('ADMIN_PASS', $_ENV['ADMIN_PASS'] ?? 'admin123');

/**
 * Cek apakah Supabase sudah dikonfigurasi dengan kredensial yang valid
 */
function is_supabase_configured() {
    $url = SUPABASE_URL;
    $key = SUPABASE_KEY;
    return !empty($url) && !empty($key) && 
           strpos($url, 'your-project-id') === false && 
           strpos($key, 'your-anon-public-key') === false;
}

/**
 * Helper sanitasi string untuk mencegah serangan XSS
 */
function e($str) {
    return htmlspecialchars((string)($str ?? ''), ENT_QUOTES, 'UTF-8');
}

/**
 * Format tanggal Indonesia lengkap
 */
function format_tgl_indo($tanggal, $dengan_hari = false) {
    if (!$tanggal || $tanggal === '0000-00-00') return '-';
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $time = strtotime($tanggal);
    $str = date('j', $time) . ' ' . $bulan[(int)date('n', $time)] . ' ' . date('Y', $time);
    if ($dengan_hari) {
        $str = $hari[(int)date('w', $time)] . ', ' . $str;
    }
    return $str;
}

/**
 * Helper cURL Supabase PostgREST API
 */
function supabase_request($method, $table_query, $payload = null, $extra_headers = []) {
    if (!is_supabase_configured()) {
        return [
            'code' => 503,
            'data' => [],
            'error' => 'Supabase belum dikonfigurasi. Lengkapi SUPABASE_URL dan SUPABASE_KEY pada file .env.'
        ];
    }

    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . ltrim($table_query, '/');
    $ch = curl_init($url);

    $default_headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];

    $headers = array_merge($default_headers, $extra_headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    if ($payload !== null) {
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_err = curl_error($ch);
    
    if ($curl_err && (str_contains($curl_err, 'certificate') || str_contains($curl_err, 'SSL'))) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_err = curl_error($ch);
    }

    curl_close($ch);

    $decoded_data = $response ? json_decode($response, true) : [];

    return [
        'code' => $http_code,
        'data' => $decoded_data !== null ? $decoded_data : $response,
        'error' => !empty($curl_err) ? $curl_err : null
    ];
}

/**
 * Flash notification helper
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type, // 'success', 'error', 'warning', 'info'
        'message' => $message
    ];
}

function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Autentikasi Helpers
 */
function is_logged_in() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function require_auth() {
    if (!is_logged_in()) {
        set_flash('warning', 'Silakan masuk terlebih dahulu untuk mengakses panel administrasi desa.');
        header('Location: login.php');
        exit;
    }
}

function current_user() {
    return [
        'username' => $_SESSION['username'] ?? 'Petugas Desa',
        'nama_lengkap' => $_SESSION['nama_lengkap'] ?? 'Administrator Balai Desa',
        'role' => $_SESSION['role'] ?? 'petugas'
    ];
}

/**
 * Helper Penyimpanan Data Lokal (Untuk Permohonan Surat & Pengaduan Warga)
 * Berjalan otomatis sehingga fitur interaktif warga langsung berfungsi tanpa harus setup database manual.
 */
function get_data_dir() {
    $dir = __DIR__ . '/../data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    return $dir;
}

function get_permohonan_list() {
    $file = get_data_dir() . '/permohonan.json';
    if (!file_exists($file)) {
        // Data inisial permohonan demo
        $initial = [
            [
                'id' => 1,
                'kode_tiket' => 'NGB-202611-001',
                'nik' => '3514051208940001',
                'nama' => 'Ahmad Fauzi',
                'no_hp' => '081234567890',
                'dusun' => 'Dusun Ngembe',
                'rt_rw' => 'RT 02 / RW 01',
                'jenis_surat' => 'Surat Keterangan Usaha (SKU)',
                'keperluan' => 'Pengajuan tambahan modal usaha warung sembako ke bank',
                'status' => 'Selesai',
                'catatan_petugas' => 'Surat telah ditandatangani Kepala Desa dan siap diambil di loket pelayanan.',
                'created_at' => '2026-11-12 09:30:00'
            ],
            [
                'id' => 2,
                'kode_tiket' => 'NGB-202611-002',
                'nik' => '3514055502980003',
                'nama' => 'Siti Nurhaliza',
                'no_hp' => '085712345678',
                'dusun' => 'Dusun Krikilan',
                'rt_rw' => 'RT 04 / RW 02',
                'jenis_surat' => 'Surat Pengantar SKCK',
                'keperluan' => 'Pemberkasan seleksi penerimaan karyawan di kawasan industri Beji',
                'status' => 'Diproses',
                'catatan_petugas' => 'Sedang diverifikasi oleh Kasi Pemerintahan.',
                'created_at' => '2026-11-13 14:15:00'
            ],
            [
                'id' => 3,
                'kode_tiket' => 'NGB-202611-003',
                'nik' => '3514052309900002',
                'nama' => 'Budi Santoso',
                'no_hp' => '087812349988',
                'dusun' => 'Dusun Grogolan',
                'rt_rw' => 'RT 01 / RW 03',
                'jenis_surat' => 'Surat Keterangan Domisili (SKD)',
                'keperluan' => 'Persyaratan pembukaan rekening bank baru',
                'status' => 'Diajukan',
                'catatan_petugas' => 'Menunggu verifikasi berkas oleh petugas loket.',
                'created_at' => '2026-11-14 10:05:00'
            ]
        ];
        file_put_contents($file, json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $initial;
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?: [];
}

function save_permohonan($data) {
    $list = get_permohonan_list();
    $data['id'] = count($list) > 0 ? (max(array_column($list, 'id')) + 1) : 1;
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['status'] = 'Diajukan';
    $data['catatan_petugas'] = 'Menunggu verifikasi berkas oleh petugas balai desa.';
    array_unshift($list, $data);
    $file = get_data_dir() . '/permohonan.json';
    file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $data;
}

function update_permohonan_status($id, $status, $catatan = '') {
    $list = get_permohonan_list();
    $updated = false;
    foreach ($list as &$item) {
        if ($item['id'] == $id) {
            $item['status'] = $status;
            if (!empty($catatan)) {
                $item['catatan_petugas'] = $catatan;
            }
            $item['updated_at'] = date('Y-m-d H:i:s');
            $updated = true;
            break;
        }
    }
    if ($updated) {
        $file = get_data_dir() . '/permohonan.json';
        file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
    return $updated;
}

function get_pengaduan_list() {
    $file = get_data_dir() . '/pengaduan.json';
    if (!file_exists($file)) {
        $initial = [
            [
                'id' => 1,
                'nama' => 'M. Rois',
                'dusun' => 'Dusun Simpar',
                'kategori' => 'Infrastruktur / Irigasi',
                'pesan' => 'Mohon bantuan perbaikan lampu penerangan jalan di pertigaan arah Simpar menuju sawah.',
                'status' => 'Ditindaklanjuti',
                'created_at' => '2026-11-10 11:20:00'
            ],
            [
                'id' => 2,
                'nama' => 'Warga Dusun Grogolan',
                'dusun' => 'Dusun Grogolan',
                'kategori' => 'Kebersihan & Wisata',
                'pesan' => 'Usulan penambahan tempat sampah pilah di sekitar area masuk wisata Grojokan Limo.',
                'status' => 'Diterima',
                'created_at' => '2026-11-13 16:45:00'
            ]
        ];
        file_put_contents($file, json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $initial;
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?: [];
}

function save_pengaduan($data) {
    $list = get_pengaduan_list();
    $data['id'] = count($list) > 0 ? (max(array_column($list, 'id')) + 1) : 1;
    $data['created_at'] = date('Y-m-d H:i:s');
    $data['status'] = 'Diterima';
    array_unshift($list, $data);
    $file = get_data_dir() . '/pengaduan.json';
    file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $data;
}
