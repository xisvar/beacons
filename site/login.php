<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'login';

if (current_user() !== null) {
    redirect('account.php');
}

$errors   = array();
$username = '';
$maxTries = 5;
$lockSecs = 60;

if (is_post()) {
    $username = post('username');
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';
    $locked   = isset($_SESSION['login_lock_until']) && $_SESSION['login_lock_until'] > time();

    if (!csrf_valid()) {
        $errors[] = 'Your session expired. Please try again.';
    } elseif ($locked) {
        $wait = $_SESSION['login_lock_until'] - time();
        $errors[] = 'Too many failed attempts. Please wait ' . $wait . ' seconds and try again.';
    } elseif ($username === '' || $password === '') {
        $errors[] = 'Enter both a username and a password.';
    } else {
        $record = auth()->attempt($username, $password);
        if ($record === null) {
            $_SESSION['login_fails'] = (isset($_SESSION['login_fails']) ? $_SESSION['login_fails'] : 0) + 1;
            if ($_SESSION['login_fails'] >= $maxTries) {
                $_SESSION['login_lock_until'] = time() + $lockSecs;
                $_SESSION['login_fails'] = 0;
            }
            $errors[] = 'That username and password do not match our records.';
        } else {
            unset($_SESSION['login_fails'], $_SESSION['login_lock_until']);
            Auth::login($record);
            flash('success', 'Welcome, ' . $record['display'] . '. You are signed in with ' . $record['role'] . ' access.');
            if ($record['role'] === 'admin') {
                redirect('admin.php');
            }
            if ($record['role'] === 'publisher') {
                redirect('publisher.php');
            }
            redirect('account.php');
        }
    }
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<h1>Log In</h1>
<p class="lead">Customers, publishers, and administrators sign in here. Your access level is stored in your session and controls which pages you can open.</p>

<?php echo render_errors($errors); ?>
<form method="post" action="login.php">
<fieldset>
<legend>Account sign in</legend>
<div class="form-row"><label class="block" for="username">Username</label>
<input type="text" id="username" name="username" maxlength="30" value="<?php echo h($username); ?>" /></div>
<div class="form-row"><label class="block" for="password">Password</label>
<input type="password" id="password" name="password" maxlength="64" /></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Log In</button></div>
</fieldset>
</form>
<p>New here? <a href="register.php">Create an account</a>.</p>

<div class="callout">
<p><strong>Accounts for course review</strong></p>
<table summary="Demonstration accounts">
<thead><tr><th scope="col">Role</th><th scope="col">Username</th><th scope="col">Password</th><th scope="col">Can open</th></tr></thead>
<tbody>
<tr><td>Customer</td><td>customer</td><td>Customer123!</td><td>My Account</td></tr>
<tr><td>Publisher</td><td>publisher</td><td>Publisher123!</td><td>My Account, Publisher Desk</td></tr>
<tr><td>Administrator</td><td>admin</td><td>Admin123!</td><td>All pages including Admin Panel</td></tr>
</tbody>
</table>
</div>
<?php require_once INC_PATH . '/footer.php'; ?>
