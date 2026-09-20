<?php
/*
 * functions.php: helper functions shared by every page.
 */

/** Load the site data arrays once and return one section by key. */
function site_data($key)
{
    static $data = null;
    if ($data === null) {
        $data = require ROOT_PATH . '/data/site-data.php';
    }
    return isset($data[$key]) ? $data[$key] : array();
}

/** Escape text for safe output inside HTML. */
function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Resolve either a local image path or a remote URL for an <img> src. */
function image_url($path)
{
    if ($path === '') {
        return '';
    }
    if (preg_match('/^https?:\/\//i', (string) $path)) {
        return (string) $path;
    }
    return 'images/' . ltrim((string) $path, '/');
}

/** Format whole cents as a dollar amount. */
function money($cents)
{
    return '$' . number_format($cents / 100, 2);
}

/** Look up a page's title, description, file, and access level. */
function page_info($pageId)
{
    $pages = site_data('pages');
    return isset($pages[$pageId]) ? $pages[$pageId] : array('file' => '', 'title' => 'Page', 'desc' => '', 'access' => 'public', 'nav' => null);
}

/** Show the date the current PHP file was last modified. */
function last_modified($file = null)
{
    if ($file === null) {
        $file = $_SERVER['SCRIPT_FILENAME'];
    }
    $time = is_file($file) ? filemtime($file) : time();
    return date('F j, Y \a\t g:i A T', $time);
}

/** Redirect and stop. Only relative paths are allowed. */
function redirect($to)
{
    header('Location: ' . $to);
    exit;
}

function is_post()
{
    return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST';
}

/** Read a trimmed POST value. */
function post($name, $default = '')
{
    return isset($_POST[$name]) && is_string($_POST[$name]) ? trim($_POST[$name]) : $default;
}

/* ---------- cached service objects ---------- */

function catalog()
{
    static $catalog = null;
    if ($catalog === null) {
        $overrides = isset($_SESSION['catalog_overrides']) && is_array($_SESSION['catalog_overrides']) ? $_SESSION['catalog_overrides'] : array();
        $catalog = new Catalog(site_data('products'), $overrides);
    }
    return $catalog;
}

function cart()
{
    static $cart = null;
    if ($cart === null) {
        $cart = new Cart(catalog());
    }
    return $cart;
}

function auth()
{
    static $auth = null;
    if ($auth === null) {
        $auth = new Auth(site_data('users'), site_data('roles'));
    }
    return $auth;
}

function content_store()
{
    static $store = null;
    if ($store === null) {
        $store = new ContentStore();
    }
    return $store;
}

/* ---------- flash messages (one time notices kept in the session) ---------- */

function flash($type, $message)
{
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        $_SESSION['flash'] = array();
    }
    $_SESSION['flash'][] = array('type' => $type, 'message' => $message);
}

function render_flash()
{
    if (empty($_SESSION['flash'])) {
        return '';
    }
    $html = '';
    foreach ($_SESSION['flash'] as $note) {
        $class = $note['type'] === 'error' ? 'notice error' : 'notice success';
        $html .= '<div class="' . $class . '"><p>' . h($note['message']) . '</p></div>' . "\n";
    }
    $_SESSION['flash'] = array();
    return $html;
}

/* ---------- cross site request forgery token ---------- */

function csrf_token()
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf" value="' . h(csrf_token()) . '" />';
}

function csrf_valid()
{
    return isset($_POST['csrf'], $_SESSION['csrf']) && is_string($_POST['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

/* ---------- access control ---------- */

function current_user()
{
    return Auth::user();
}

/** Stop the page unless the visitor has the required role. */
function require_role($role)
{
    if (current_user() === null) {
        flash('error', 'Please log in to view that page.');
        redirect('login.php');
    }
    if (!auth()->can($role)) {
        flash('error', 'Your account does not have access to that page.');
        redirect('account.php');
    }
}

/* ---------- display helpers ---------- */

/** A different verse each day of the year. */
function verse_of_the_day()
{
    $verses = site_data('verses');
    $index  = (int) date('z') % count($verses);
    return $verses[$index];
}

/** Draw the list of error messages for a form. */
function render_errors(array $errors)
{
    if (count($errors) === 0) {
        return '';
    }
    $html = '<div class="notice error"><p>Please fix the following:</p><ul>';
    foreach ($errors as $error) {
        $html .= '<li>' . h($error) . '</li>';
    }
    return $html . '</ul></div>';
}

/** True when a menu link points at the page being viewed. */
function is_current($file)
{
    return basename($_SERVER['SCRIPT_NAME']) === $file;
}

/** The dollar cost of the cart as text for the menu, for example "3 items". */
function cart_label()
{
    $count = cart()->count();
    return $count === 1 ? '1 item' : $count . ' items';
}

/** Allow only known relative pages as a "return to" target after adding to the cart. */
function safe_return($value, $default = 'cart.php')
{
    $ok = preg_match('/^(index|store|product|cart)\.php(\?(id=[0-9]{1,3}|category=[A-Za-z]{1,20}))?$/', (string) $value);
    return $ok ? $value : $default;
}

/** Add to cart form used on the home page, store, and product page. */
function render_add_form(Product $product, $returnTo)
{
    if (!$product->inStock()) {
        return '<p class="stock low">Out of stock</p>';
    }
    $id = 'qty-' . $product->getId();
    return '<form method="post" action="cart.php" class="add-form"><div>'
        . csrf_field()
        . '<input type="hidden" name="action" value="add" />'
        . '<input type="hidden" name="product_id" value="' . (int) $product->getId() . '" />'
        . '<input type="hidden" name="return" value="' . h($returnTo) . '" />'
        . '<label for="' . h($id) . '">Qty</label> '
        . '<input type="text" class="qty" id="' . h($id) . '" name="qty" value="1" maxlength="2" /> '
        . '<button type="submit" class="small-btn">Add to Cart</button>'
        . '</div></form>';
}

/** One product tile for the store grid. */
function render_product_card(Product $product, $returnTo)
{
    $stockClass = ($product->getStock() <= 10) ? 'stock low' : 'stock';
    return '<div class="product-card">'
        . '<a href="product.php?id=' . (int) $product->getId() . '"><img src="' . h(image_url($product->getImage())) . '" width="400" height="400" alt="' . h($product->getName()) . '" /></a>'
        . '<div class="card-body">'
        . '<h3><a href="product.php?id=' . (int) $product->getId() . '">' . h($product->getName()) . '</a></h3>'
        . '<p>' . h($product->getShort()) . '</p>'
        . '<p><span class="price">' . h($product->getPrice()) . '</span> <span class="' . $stockClass . '">' . h($product->stockLabel()) . '</span></p>'
        . render_add_form($product, $returnTo)
        . '</div></div>';
}
