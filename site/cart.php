<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'cart';

/* Handle cart actions, then redirect so a refresh never repeats them. */
if (is_post()) {
    $action = post('action');
    $target = 'cart.php';
    if (!csrf_valid()) {
        flash('error', 'Your session expired. Please try again.');
    } elseif ($action === 'add') {
        list($ok, $message) = cart()->add(post('product_id'), post('qty', '1'));
        flash($ok ? 'success' : 'error', $message);
        $target = safe_return(post('return'), 'cart.php');
        if ($ok) {
            $target = 'cart.php';
        }
    } elseif ($action === 'update') {
        list($ok, $message) = cart()->update(post('product_id'), post('qty'));
        flash($ok ? 'success' : 'error', $message);
    } elseif ($action === 'remove') {
        list($ok, $message) = cart()->remove(post('product_id'));
        flash($ok ? 'success' : 'error', $message);
    } elseif ($action === 'clear') {
        cart()->clear();
        flash('success', 'Your cart is now empty.');
    }
    redirect($target);
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
$lines = cart()->lines();
?>
<h1>Your Cart</h1>

<?php if (count($lines) === 0): ?>
<p class="lead">Your cart is empty.</p>
<p>Browse our books, gifts, and fair trade goods and add something you love.</p>
<p><a class="button" href="store.php">Visit the Mission Store</a></p>
<?php else: ?>
<table class="cart-table" summary="Items in your shopping cart">
<thead>
<tr>
<th scope="col">Item</th>
<th scope="col" class="num">Price</th>
<th scope="col">Quantity</th>
<th scope="col" class="num">Line Total</th>
<th scope="col">Remove</th>
</tr>
</thead>
<tfoot>
<tr><td colspan="3" class="num">Subtotal (<?php echo h(cart_label()); ?>)</td><td class="num"><?php echo h(money(cart()->subtotalCents())); ?></td><td></td></tr>
<tr><td colspan="3" class="num">Sales tax (<?php echo h(round(TAX_RATE * 100, 1)); ?> percent)</td><td class="num"><?php echo h(money(cart()->taxCents())); ?></td><td></td></tr>
<tr class="total"><td colspan="3" class="num">Order total</td><td class="num"><?php echo h(money(cart()->totalCents())); ?></td><td></td></tr>
</tfoot>
<tbody>
<?php foreach ($lines as $line): ?>
<?php $product = $line['product']; ?>
<tr>
<td><img src="<?php echo h(image_url($product->getImage())); ?>" width="56" height="56" alt="" /><a href="product.php?id=<?php echo (int) $product->getId(); ?>"><?php echo h($product->getName()); ?></a></td>
<td class="num"><?php echo h($product->getPrice()); ?></td>
<td>
<form method="post" action="cart.php" class="inline-form"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="product_id" value="<?php echo (int) $product->getId(); ?>" />
<label for="cart-qty-<?php echo (int) $product->getId(); ?>">Qty</label>
<input type="text" class="qty" id="cart-qty-<?php echo (int) $product->getId(); ?>" name="qty" value="<?php echo (int) $line['qty']; ?>" maxlength="2" />
<button type="submit" class="small-btn">Update</button>
</div></form>
<span class="hint"><?php echo h($product->stockLabel()); ?></span>
</td>
<td class="num"><?php echo h(money($line['line_cents'])); ?></td>
<td>
<form method="post" action="cart.php" class="inline-form"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="action" value="remove" />
<input type="hidden" name="product_id" value="<?php echo (int) $product->getId(); ?>" />
<button type="submit" class="small-btn danger">Remove</button>
</div></form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<p>
<a class="button gold" href="checkout.php">Proceed to Checkout</a>
<a class="button" href="store.php">Keep Shopping</a>
</p>
<form method="post" action="cart.php"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="action" value="clear" />
<button type="submit" class="small-btn danger">Empty Cart</button>
</div></form>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
