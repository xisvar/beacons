<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'store';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$categories = catalog()->categories();
$selected   = isset($_GET['category']) && is_string($_GET['category']) ? $_GET['category'] : '';
if ($selected !== '' && !in_array($selected, $categories, true)) {
    $selected = '';
}
$products = catalog()->inCategory($selected);
$returnTo = $selected === '' ? 'store.php' : 'store.php?category=' . $selected;
?>
<div class="banner"><img src="https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=1600&q=80" width="900" height="220" alt="Books and Bibles arranged on shelves in a Christian bookstore" /></div>

<h1>Mission Store</h1>
<p class="lead">Books, gifts, and fair trade goods that encourage your faith and fund the field. Every purchase sends help where it is needed.</p>

<div class="filter-bar">
<a href="store.php"<?php echo $selected === '' ? ' class="active"' : ''; ?>>All Items</a>
<?php foreach ($categories as $category): ?>
<a href="store.php?category=<?php echo h(urlencode($category)); ?>"<?php echo $selected === $category ? ' class="active"' : ''; ?>><?php echo h($category); ?></a>
<?php endforeach; ?>
</div>

<div class="product-grid">
<?php foreach ($products as $product): ?>
<?php echo render_product_card($product, $returnTo); ?>
<?php endforeach; ?>
</div>

<p class="small">Prices are in US dollars. A <?php echo h(round(TAX_RATE * 100, 1)); ?> percent sales tax is added in your cart.</p>
<?php require_once INC_PATH . '/footer.php'; ?>
