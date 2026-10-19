<?php require_once '../includes/config.php';
$err = ''; $ok = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); $email = trim($_POST['email']); $pw = $_POST['password'];
    if (strcasecmp($_POST['captcha'] ?? '', $_SESSION['captcha'] ?? '#') !== 0) $err = 'Wrong CAPTCHA';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pw) < 6 || $name === '') $err = 'Enter valid details (password min 6 chars)';
    else {
        $c = $pdo->prepare('SELECT id FROM users WHERE email=?'); $c->execute([$email]);
        if ($c->fetch()) $err = 'Email already registered';
        else {
            $pdo->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)')->execute([$name, $email, password_hash($pw, PASSWORD_DEFAULT)]);
            $ok = 'Registered! You can now login.';
        }
    }
    unset($_SESSION['captcha']);
}
include '_nav.php'; ?>
<div class="wrap" style="max-width:380px"><h2>Register</h2>
<p class="err"><?= e($err) ?></p><p class="ok"><?= e($ok) ?></p>
<form method="post">Name<input name="name" required>Email<input type="email" name="email" required>
Password<input type="password" name="password" required>
<img src="captcha.php?<?= time() ?>" id="cap"> <a href="#" onclick="document.getElementById('cap').src='captcha.php?'+Date.now();return false">refresh</a>
<input name="captcha" placeholder="Enter CAPTCHA" required><br><button>Register</button></form></div>
