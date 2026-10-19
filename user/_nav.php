<link rel="stylesheet" href="../includes/style.css">
<nav><a href="index.php">Home</a><a href="cart.php">Cart (<?= array_sum($_SESSION['cart'] ?? []) ?>)</a>
<?php if (!empty($_SESSION['user'])): ?><a href="logout.php">Logout (<?= e($_SESSION['user']['name']) ?>)</a>
<?php else: ?><a href="login.php">Login</a><a href="register.php">Register</a><?php endif; ?></nav>
