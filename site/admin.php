<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'admin';
require_role('admin');

$errors   = array();
$products = catalog()->all();
$values   = array('product_id' => '', 'price' => '', 'stock' => '');

if (is_post()) {
    $action = post('action');
    if (!csrf_valid()) {
        flash('error', 'Your session expired. Please try again.');
        redirect('admin.php');
    }
    if ($action === 'reset') {
        unset($_SESSION['catalog_overrides']);
        flash('success', 'All product edits were reset to the original values.');
        redirect('admin.php');
    }
    if ($action === 'update') {
        $values['product_id'] = post('product_id');
        $values['price']      = post('price');
        $values['stock']      = post('stock');
        if (!Validator::intBetween($values['product_id'], 1, 999) || catalog()->find($values['product_id']) === null) {
            $errors[] = 'Choose a product from the list.';
        }
        if (!preg_match('/^[0-9]{1,4}(\.[0-9]{1,2})?$/', $values['price']) || (float) $values['price'] <= 0) {
            $errors[] = 'Enter a price greater than zero, such as 19.99.';
        }
        if (!Validator::intBetween($values['stock'], 0, 999)) {
            $errors[] = 'Stock must be a whole number from 0 to 999.';
        }
        if (count($errors) === 0) {
            $id = (int) $values['product_id'];
            $_SESSION['catalog_overrides'][$id] = array(
                'price_cents' => (int) round((float) $values['price'] * 100),
                'stock'       => (int) $values['stock'],
            );
            flash('success', 'Product updated: ' . catalog()->find($id)->getName() . '.');
            redirect('admin.php');
        }
    }
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
$posts = content_store()->all();
?>
<h1>Administrator Panel</h1>
<p class="lead">Manage the store, review the pages of the site, and see who can sign in. Edits are kept in your session during this phase and become database updates in the final project.</p>

<div class="stats">
<div class="stat"><strong><?php echo count($products); ?></strong>Products</div>
<div class="stat"><strong><?php echo count(site_data('pages')); ?></strong>Pages</div>
<div class="stat"><strong><?php echo count(site_data('users')); ?></strong>Accounts</div>
<div class="stat"><strong><?php echo count($posts); ?></strong>Field posts</div>
</div>

<h2>Store Inventory</h2>
<table summary="Products with price and stock">
<thead><tr><th scope="col">ID</th><th scope="col">Product</th><th scope="col">Category</th><th scope="col" class="num">Price</th><th scope="col" class="num">Stock</th></tr></thead>
<tbody>
<?php foreach ($products as $product): ?>
<tr>
<td><?php echo (int) $product->getId(); ?></td>
<td><?php echo h($product->getName()); ?></td>
<td><?php echo h($product->getCategory()); ?></td>
<td class="num"><?php echo h($product->getPrice()); ?></td>
<td class="num"><?php echo (int) $product->getStock(); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h3>Edit Price and Stock</h3>
<?php echo render_errors($errors); ?>
<form method="post" action="admin.php">
<fieldset>
<legend>Update a product</legend>
<div class="form-row"><label class="block" for="product_id">Product</label>
<select id="product_id" name="product_id">
<option value="">Choose a product</option>
<?php foreach ($products as $product): ?>
<option value="<?php echo (int) $product->getId(); ?>"<?php echo (string) $values['product_id'] === (string) $product->getId() ? ' selected="selected"' : ''; ?>><?php echo h($product->getName()); ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row"><label class="block" for="price">New price in dollars</label>
<input type="text" id="price" name="price" maxlength="7" value="<?php echo h($values['price']); ?>" /></div>
<div class="form-row"><label class="block" for="stock">New stock quantity</label>
<input type="text" id="stock" name="stock" maxlength="3" value="<?php echo h($values['stock']); ?>" /></div>
<div class="form-row"><?php echo csrf_field(); ?>
<input type="hidden" name="action" value="update" />
<button type="submit">Save Changes</button></div>
</fieldset>
</form>
<form method="post" action="admin.php"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="action" value="reset" />
<button type="submit" class="small-btn danger">Reset All Product Edits</button>
</div></form>

<h2>Pages</h2>
<table summary="Pages and access levels">
<thead><tr><th scope="col">Page</th><th scope="col">File</th><th scope="col">Access</th></tr></thead>
<tbody>
<?php foreach (site_data('pages') as $page): ?>
<tr>
<td><?php echo h($page['title']); ?></td>
<td><?php echo h($page['file']); ?></td>
<td><span class="tag role"><?php echo h($page['access']); ?></span></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h2>Accounts</h2>
<table summary="Accounts and roles">
<thead><tr><th scope="col">Username</th><th scope="col">Display name</th><th scope="col">Role</th></tr></thead>
<tbody>
<?php foreach (site_data('users') as $username => $account): ?>
<tr>
<td><?php echo h($username); ?></td>
<td><?php echo h($account['display']); ?></td>
<td><span class="tag role"><?php echo h($account['role']); ?></span></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php require_once INC_PATH . '/footer.php'; ?>
