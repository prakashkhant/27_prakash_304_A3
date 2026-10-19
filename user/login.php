<?php require_once '../includes/config.php';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s = $pdo->prepare('SELECT * FROM users WHERE email=?'); $s->execute([$_POST['email']]);
    $u = $s->fetch();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $u['id'], 'name' => $u['name']];
        header('Location: index.php'); exit;
    }
    $err = 'Invalid email or password';
}
include '_nav.php'; ?>
<div class="wrap" style="max-width:380px"><h2>User Login</h2><p class="err"><?= e($err) ?></p>
<form method="post">Email<input type="email" name="email" required>Password<input type="password" name="password" required><br><button>Login</button></form></div>
