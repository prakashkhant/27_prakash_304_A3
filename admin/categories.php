<?php require 'auth.php';
// CREATE / UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    if ($name !== '') {
        if (!empty($_POST['id'])) $pdo->prepare('UPDATE categories SET name=? WHERE id=?')->execute([$name, $_POST['id']]);
        else $pdo->prepare('INSERT INTO categories (name) VALUES (?)')->execute([$name]);
    }
    header('Location: categories.php'); exit;
}
// DELETE
if (isset($_GET['delete'])) {
    $pdo->prepare('DELETE FROM categories WHERE id=?')->execute([$_GET['delete']]);
    header('Location: categories.php'); exit;
}
// READ
$edit = null;
if (isset($_GET['edit'])) { $s = $pdo->prepare('SELECT * FROM categories WHERE id=?'); $s->execute([$_GET['edit']]); $edit = $s->fetch(); }
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
include '_nav.php'; ?>
<div class="wrap"><h2>Manage Categories</h2>
<form method="post" style="display:flex;gap:8px">
<input type="hidden" name="id" value="<?= e($edit['id'] ?? '') ?>">
<input name="name" placeholder="Category name" value="<?= e($edit['name'] ?? '') ?>" required>
<button style="width:150px"><?= $edit ? 'Update' : 'Add' ?></button></form><br>
<table><tr><th>ID</th><th>Name</th><th>Action</th></tr>
<?php foreach ($cats as $c): ?>
<tr><td><?= $c['id'] ?></td><td><?= e($c['name']) ?></td>
<td><a href="?edit=<?= $c['id'] ?>">Edit</a> | <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Delete category and its products?')">Delete</a></td></tr>
<?php endforeach; ?></table></div>
