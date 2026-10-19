<?php require_once '../includes/config.php';
if (isset($_GET['add'])) { $_SESSION['cart'][(int)$_GET['add']] = ($_SESSION['cart'][(int)$_GET['add']] ?? 0) + 1; header('Location: cart.php'); exit; }
if (isset($_GET['remove'])) { unset($_SESSION['cart'][(int)$_GET['remove']]); header('Location: cart.php'); exit; }
$items = []; $total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $in = implode(',', array_fill(0, count($ids), '?'));
    $s = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)"); $s->execute($ids);
    $items = $s->fetchAll();
}
include '_nav.php'; ?>
<div class="wrap"><h2>Your Cart</h2>
<?php if (!$items): ?><p>Cart is empty.</p><?php else: ?>
<table><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
<?php foreach ($items as $p): $q = $_SESSION['cart'][$p['id']]; $total += $q * $p['price']; ?>
<tr><td><?= e($p['name']) ?></td><td><?= e($p['price']) ?></td><td><?= $q ?></td><td><?= number_format($q * $p['price'], 2) ?></td>
<td><a href="?remove=<?= $p['id'] ?>">Remove</a></td></tr><?php endforeach; ?>
<tr><th colspan="3">Total</th><th colspan="2">Rs. <?= number_format($total, 2) ?></th></tr></table><?php endif; ?></div>
