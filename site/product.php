<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'product';

$rawId   = isset($_GET['id']) && is_string($_GET['id']) ? $_GET['id'] : '';
$product = Validator::intBetween($rawId, 1, 999) ? catalog()->find($rawId) : null;
if ($product === null) {
    http_response_code(404);
}
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<?php if ($product === null): ?>
<h1>Product Not Found</h1>
<p>We could not find that item. It may have been removed from the store.</p>
<p><a class="button" href="store.php">Back to the store</a></p>
<?php else: ?>
<?php
$related = array();
foreach (catalog()->inCategory($product->getCategory()) as $other) {
    if ($other->getId() !== $product->getId()) {
        $related[] = $other;
    }
}
$related = array_slice($related, 0, 3);
?>
<p class="small"><a href="store.php">Mission Store</a> &#187; <a href="store.php?category=<?php echo h(urlencode($product->getCategory())); ?>"><?php echo h($product->getCategory()); ?></a> &#187; <?php echo h($product->getName()); ?></p>
<div class="product-detail">
<div class="photo"><img src="<?php echo h(image_url($product->getImage())); ?>" width="400" height="400" alt="<?php echo h($product->getName()); ?>" /></div>
<div class="info">
<h1><?php echo h($product->getName()); ?></h1>
<p><span class="tag"><?php echo h($product->getCategory()); ?></span></p>
<p class="price"><?php echo h($product->getPrice()); ?></p>
<p><?php echo h($product->getDescription()); ?></p>
<p class="stock<?php echo $product->getStock() <= 10 ? ' low' : ''; ?>">Availability: <?php echo h($product->stockLabel()); ?></p>
<?php echo render_add_form($product, 'product.php?id=' . $product->getId()); ?>
<p class="small">Sales tax is calculated in your cart before checkout.</p>
</div>
</div>

<?php if (count($related) > 0): ?>
<h2>More in <?php echo h($product->getCategory()); ?></h2>
<div class="product-grid">
<?php foreach ($related as $other): ?>
<?php echo render_product_card($other, 'product.php?id=' . $product->getId()); ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
