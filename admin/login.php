<?php
require_once __DIR__ . '/../includes/config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $st = $pdo->prepare('SELECT * FROM admins WHERE username=?');
    $st->execute([$_POST['username'] ?? '']);
    $a = $st->fetch();
    if ($a && password_verify($_POST['password'] ?? '', $a['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $a['username'];
        header('Location: index.php'); exit;
    }
    $err = 'Invalid username or password';
}
?>
<!DOCTYPE html><html><head><title>Admin Login</title><link rel="stylesheet" href="../includes/style.css"></head><body>
<div class="wrap" style="max-width:350px"><h2>Admin Login</h2>
<p class="err"><?= e($err) ?></p>
<form method="post">Username<input name="username" required>Password<input type="password" name="password" required><br><button>Login</button></form>
<p><small></small></p></div></body></html>
