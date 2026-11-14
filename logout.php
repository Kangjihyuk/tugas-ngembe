<?php
require_once __DIR__ . '/config/supabase.php';

// Hapus seluruh session pengguna
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Mulai session baru hanya untuk flash message
session_start();
set_flash('info', 'Anda telah berhasil keluar dari sistem.');

header('Location: login.php');
exit;
