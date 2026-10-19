<?php require_once '../includes/config.php';
$cat = (int)($_GET['cat'] ?? 0); $page = max(1, (int)($_GET['page'] ?? 1)); $per = 6;
$t = $pdo->prepare('SELECT COUNT(*) FROM products WHERE category_id=?'); $t->execute([$cat]);
$total = (int)$t->fetchColumn(); $pages = max(1, ceil($total / $per));
$st = $pdo->prepare("SELECT * FROM products WHERE category_id=? ORDER BY id DESC LIMIT $per OFFSET " . (($page - 1) * $per));
$st->execute([$cat]); $rows = $st->fetchAll();
if (!$rows) { echo '<p>No products in this category.</p>'; exit; }
echo '<div class="grid">';
foreach ($rows as $p) {
    echo '<div class="card">' . ($p['image'] ? '<img src="../uploads/products/' . e($p['image']) . '">' : '') .
         '<h4>' . e($p['name']) . '</h4><p>Rs. ' . e($p['price']) . '</p>' .
         '<a class="btn" href="cart.php?add=' . $p['id'] . '">Add to cart</a></div>';
}
echo '</div><div class="pager" style="margin-top:12px">';
for ($i = 1; $i <= $pages; $i++)
    echo '<a href="#" data-cat="' . $cat . '" data-page="' . $i . '" class="' . ($i == $page ? 'cur' : '') . '">' . $i . '</a>';
echo '</div>';
