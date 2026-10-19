<?php require_once '../includes/config.php';
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll();
include '_nav.php'; ?>
<div class="wrap"><div class="layout">
<div class="side"><h3><u>Categories</u></h3>
<?php foreach ($cats as $c): ?><a href="#" class="cat" data-id="<?= $c['id'] ?>"><?= e($c['name']) ?></a><?php endforeach; ?></div>
<div class="main" id="products"><p>Click a category to view products.</p></div>
</div></div>
<script>
function load(cat, page) {
  fetch('products_ajax.php?cat=' + cat + '&page=' + page)
    .then(r => r.text()).then(html => { document.getElementById('products').innerHTML = html; });
}
document.querySelectorAll('.cat').forEach(a => a.addEventListener('click', e => { e.preventDefault(); load(a.dataset.id, 1); }));
document.getElementById('products').addEventListener('click', e => {
  if (e.target.dataset.page) { e.preventDefault(); load(e.target.dataset.cat, e.target.dataset.page); }
});
</script>
