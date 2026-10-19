<?php require 'auth.php'; include '_nav.php';
$c = $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
$p = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
$u = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(); ?>
<div class="wrap"><h2>Admin Dashboard</h2>
<p>Categories: <b><?= $c ?></b> | Products: <b><?= $p ?></b> | Registered users: <b><?= $u ?></b></p></div>
