<?php
require_once __DIR__ . '/config/supabase.php';

// Jika sudah login, langsung lempar ke admin_dashboard.php
if (is_logged_in()) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';
$flash = get_flash();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Silakan masukkan username dan password Anda.';
    } else {
        $authenticated = false;
        $user_data = [
            'username' => $username,
            'nama_lengkap' => 'Administrator Balai Desa',
            'role' => 'admin'
        ];

        // 1. Cek kredensial default dari .env
        if ($username === ADMIN_USER && $password === ADMIN_PASS) {
            $authenticated = true;
        } 
        // 2. Jika Supabase aktif, coba verifikasi dengan tabel users
        else if (is_supabase_configured()) {
            $response = supabase_request('GET', 'users?username=eq.' . urlencode($username));
            if ($response['code'] === 200 && is_array($response['data']) && count($response['data']) > 0) {
                $dbUser = $response['data'][0];
                if (password_verify($password, $dbUser['password_hash'])) {
                    $authenticated = true;
                    $user_data = [
                        'username' => $dbUser['username'],
                        'nama_lengkap' => $dbUser['nama_lengkap'],
                        'role' => $dbUser['role']
                    ];
                }
            }
        }

        if ($authenticated) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['nama_lengkap'] = $user_data['nama_lengkap'];
            $_SESSION['role'] = $user_data['role'];

            set_flash('success', 'Selamat datang di Panel Administrasi, ' . $user_data['nama_lengkap'] . '!');
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $error = 'Username atau password yang Anda masukkan salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas &bull; <?= e(APP_NAME) ?></title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-950 via-emerald-950 to-slate-950 font-sans">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white shadow-xl shadow-emerald-600/30 mb-3 transform hover:scale-105 transition-transform">
                <i class="fa-solid fa-landmark-flag text-2xl"></i>
            </div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight uppercase">Pemerintah Desa Ngembe</h1>
            <p class="text-xs text-emerald-300 font-medium">Kecamatan Beji &bull; Kabupaten Pasuruan</p>
            <p class="text-[11px] text-slate-400 mt-1">Panel Masuk Pamong, Operator Loket &amp; Pengarsipan Surat</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-6 sm:p-8">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-slate-900">Masuk Panel Administrasi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Akses khusus staf balai desa dan administrator sistem</p>
            </div>

            <!-- Flash Alert -->
            <?php if ($flash): ?>
            <div class="mb-4 p-3 rounded-xl text-xs font-semibold flex items-center gap-2 <?= $flash['type'] === 'success' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' ?>">
                <i class="fa-solid <?= $flash['type'] === 'success' ? 'fa-circle-check text-emerald-600' : 'fa-circle-info text-amber-600' ?>"></i>
                <span><?= e($flash['message']) ?></span>
            </div>
            <?php endif; ?>

            <!-- Error Banner -->
            <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600 text-base"></i>
                <span><?= e($error) ?></span>
            </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="login.php" class="space-y-4">
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username Petugas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-user-shield text-sm"></i>
                        </div>
                        <input type="text" id="username" name="username" required value="<?= e($_POST['username'] ?? 'admin') ?>"
                            class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-400 font-medium text-slate-800"
                            placeholder="Masukkan username">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kata Sandi (Password)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="password" name="password" required value="admin123"
                            class="w-full pl-10 pr-10 py-2.5 text-sm bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition placeholder-slate-400 font-medium text-slate-800"
                            placeholder="Masukkan password">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600">
                            <i id="eye-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>Masuk ke Panel Administrasi</span>
                    </button>
                </div>
            </form>

            <!-- Kredensial Default -->
            <div class="mt-5 pt-4 border-t border-slate-200">
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-200 text-xs">
                    <div class="flex items-center justify-between text-slate-600 font-semibold mb-1">
                        <span class="flex items-center gap-1.5 text-emerald-700">
                            <i class="fa-solid fa-key text-emerald-600"></i>
                            Kredensial Default Pamong:
                        </span>
                        <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Siap Uji</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-slate-700 mt-2 font-mono text-[11px]">
                        <div class="bg-white p-1.5 rounded border border-slate-200">
                            <span class="text-slate-400 block text-[9px] font-sans font-bold">USER</span>
                            <strong>admin</strong>
                        </div>
                        <div class="bg-white p-1.5 rounded border border-slate-200">
                            <span class="text-slate-400 block text-[9px] font-sans font-bold">PASS</span>
                            <strong>admin123</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link Kembali ke Website Publik -->
            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                <a href="index.php" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Website Utama Desa Ngembe</span>
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6 font-medium">
            &copy; 2026 Pemerintah Desa Ngembe &bull; Kecamatan Beji, Kabupaten Pasuruan
        </p>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
