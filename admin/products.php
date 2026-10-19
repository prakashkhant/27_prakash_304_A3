<?php require 'auth.php';
$dir = __DIR__ . '/../uploads/products/';
$msg = '';
function handle_upload($dir) {
    if (empty($_FILES['image']['name']) || $_FILES['image']['error'] !== 0) return null;
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) return false;
    $fn = uniqid('p_') . '.' . $ext;
    return resize_image($_FILES['image']['tmp_name'], $dir . $fn, 300, 300) ? $fn : false; // resized to max 300x300
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $img = handle_upload($dir);
    if ($img === false) { $msg = 'Invalid image (only jpg/png/gif).'; }
    else {
        $d = [$_POST['category_id'], trim($_POST['name']), $_POST['price'], trim($_POST['description'])];
        if (!empty($_POST['id'])) {
            if ($img) {
                $old = $pdo->prepare('SELECT image FROM products WHERE id=?'); $old->execute([$_POST['id']]);
                $o = $old->fetchColumn(); if ($o && file_exists($dir . $o)) unlink($dir . $o);
                $pdo->prepare('UPDATE products SET category_id=?,name=?,price=?,description=?,image=? WHERE id=?')->execute([...$d, $img, $_POST['id']]);
            } else $pdo->prepare('UPDATE products SET category_id=?,name=?,price=?,description=? WHERE id=?')->execute([...$d, $_POST['id']]);
        } else $pdo->prepare('INSERT INTO products (category_id,name,price,description,image) VALUES (?,?,?,?,?)')->execute([...$d, $img]);
        header('Location: products.php'); exit;
    }
}
if (isset($_GET['delete'])) {
    $s = $pdo->prepare('SELECT image FROM products WHERE id=?'); $s->execute([$_GET['delete']]);
    $o = $s->fetchColumn(); if ($o && file_exists($dir . $o)) unlink($dir . $o);
    $pdo->prepare('DELETE FROM products WHERE id=?')->execute([$_GET['delete']]);
    header('Location: products.php'); exit;
}
$edit = null;
if (isset($_GET['edit'])) { $s = $pdo->prepare('SELECT * FROM products WHERE id=?'); $s->execute([$_GET['edit']]); $edit = $s->fetch(); }
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
$prods = $pdo->query('SELECT p.*, c.name cat FROM products p JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC')->fetchAll();
include '_nav.php'; ?>
<div class="wrap"><h2>Manage Products</h2><p class="err"><?= e($msg) ?></p>
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
Category <select name="category_id"><?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= ($edit['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select>
Name <input name="name" value="<?= e($edit['name'] ?? '') ?>" required>
Price <input type="number" step="0.01" name="price" value="<?= e($edit['price'] ?? '') ?>" required>
Description <textarea name="description"><?= e($edit['description'] ?? '') ?></textarea>
Picture (auto-resized) <input type="file" name="image" accept="image/*">
<button><?= $edit ? 'Update' : 'Add' ?> Product</button></form><br>
<table><tr><th>Pic</th><th>Name</th><th>Category</th><th>Price</th><th>Action</th></tr>
<?php foreach ($prods as $p): ?>
<tr><td><?php if ($p['image']): ?><img src="../uploads/products/<?= e($p['image']) ?>" height="50"><?php endif; ?></td>
<td><?= e($p['name']) ?></td><td><?= e($p['cat']) ?></td><td><?= e($p['price']) ?></td>
<td><a href="?edit=<?= $p['id'] ?>">Edit</a> | <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?></table></div>
