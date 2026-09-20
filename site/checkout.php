<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'checkout';

if (cart()->isEmpty()) {
    flash('error', 'Your cart is empty. Add an item before checking out.');
    redirect('store.php');
}

$fieldsList = array('name', 'email', 'phone', 'address', 'city', 'region', 'postal', 'country');
$values = array();
foreach ($fieldsList as $key) {
    $values[$key] = '';
}
$errors    = array();
$completed = false;

if (is_post()) {
    foreach ($fieldsList as $key) {
        $values[$key] = post($key);
    }
    if (!csrf_valid()) {
        $errors['form'] = 'Your session expired. Please try again.';
    }
    if (!Validator::personName($values['name'])) {
        $errors['name'] = 'Enter your full name using letters only.';
    }
    if (!Validator::email($values['email'])) {
        $errors['email'] = 'Enter a valid email address that contains an @ symbol.';
    }
    if ($values['phone'] !== '' && !Validator::phone($values['phone'])) {
        $errors['phone'] = 'Enter a phone number with 7 to 15 digits, or leave it blank.';
    }
    if (!Validator::lengthBetween($values['address'], 5, 100)) {
        $errors['address'] = 'Enter your street address (5 to 100 characters).';
    }
    if (!Validator::personName($values['city'])) {
        $errors['city'] = 'Enter a city name using letters only.';
    }
    if (!Validator::lengthBetween($values['region'], 2, 40)) {
        $errors['region'] = 'Enter your state or region.';
    }
    if (!Validator::postalCode($values['postal'])) {
        $errors['postal'] = 'Enter a postal code of 3 to 10 letters or numbers.';
    }
    if (!Validator::lengthBetween($values['country'], 2, 40)) {
        $errors['country'] = 'Enter your country.';
    }
    $completed = count($errors) === 0;
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
$lines = cart()->lines();
?>
<h1>Checkout</h1>

<h2>Order Summary</h2>
<table class="cart-table" summary="Order summary with tax">
<thead>
<tr><th scope="col">Item</th><th scope="col" class="num">Price</th><th scope="col" class="num">Qty</th><th scope="col" class="num">Line Total</th></tr>
</thead>
<tfoot>
<tr><td colspan="3" class="num">Subtotal</td><td class="num"><?php echo h(money(cart()->subtotalCents())); ?></td></tr>
<tr><td colspan="3" class="num">Sales tax (<?php echo h(round(TAX_RATE * 100, 1)); ?> percent)</td><td class="num"><?php echo h(money(cart()->taxCents())); ?></td></tr>
<tr class="total"><td colspan="3" class="num">Total due</td><td class="num"><?php echo h(money(cart()->totalCents())); ?></td></tr>
</tfoot>
<tbody>
<?php foreach ($lines as $line): ?>
<tr>
<td><?php echo h($line['product']->getName()); ?></td>
<td class="num"><?php echo h($line['product']->getPrice()); ?></td>
<td class="num"><?php echo (int) $line['qty']; ?></td>
<td class="num"><?php echo h(money($line['line_cents'])); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p><a href="cart.php">Change items in your cart</a></p>

<?php if ($completed): ?>
<div class="notice success">
<p><strong>Your order total is confirmed: <?php echo h(money(cart()->totalCents())); ?> including tax.</strong></p>
<p>Thank you, <?php echo h($values['name']); ?>. Your shipping details passed verification for <?php echo h($values['address']); ?>, <?php echo h($values['city']); ?>, <?php echo h($values['region']); ?> <?php echo h($values['postal']); ?>, <?php echo h($values['country']); ?>.</p>
<p>The checkout process ends here for this phase. Payment processing and order storage arrive with the database in the final project.</p>
</div>
<p><a class="button" href="store.php">Continue shopping</a></p>
<?php else: ?>
<h2>Shipping Details</h2>
<?php echo render_errors($errors); ?>
<form method="post" action="checkout.php">
<fieldset>
<legend>Where should we send your order?</legend>
<div class="form-row"><label class="block" for="name">Full name <span class="required">*</span></label>
<input type="text" id="name" name="name" maxlength="60" value="<?php echo h($values['name']); ?>" /></div>
<div class="form-row"><label class="block" for="email">Email <span class="required">*</span></label>
<input type="text" id="email" name="email" maxlength="254" value="<?php echo h($values['email']); ?>" /></div>
<div class="form-row"><label class="block" for="phone">Phone (optional)</label>
<input type="text" id="phone" name="phone" maxlength="20" value="<?php echo h($values['phone']); ?>" /></div>
<div class="form-row"><label class="block" for="address">Street address <span class="required">*</span></label>
<input type="text" id="address" name="address" maxlength="100" value="<?php echo h($values['address']); ?>" /></div>
<div class="form-row"><label class="block" for="city">City <span class="required">*</span></label>
<input type="text" id="city" name="city" maxlength="60" value="<?php echo h($values['city']); ?>" /></div>
<div class="form-row"><label class="block" for="region">State or region <span class="required">*</span></label>
<input type="text" id="region" name="region" maxlength="40" value="<?php echo h($values['region']); ?>" /></div>
<div class="form-row"><label class="block" for="postal">Postal code <span class="required">*</span></label>
<input type="text" id="postal" name="postal" maxlength="10" value="<?php echo h($values['postal']); ?>" /></div>
<div class="form-row"><label class="block" for="country">Country <span class="required">*</span></label>
<input type="text" id="country" name="country" maxlength="40" value="<?php echo h($values['country']); ?>" /></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Confirm Order Total</button></div>
</fieldset>
</form>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
