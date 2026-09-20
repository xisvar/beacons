<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'register';

$errors    = array();
$username  = '';
$email     = '';
$checks    = array();
$submitted = false;
$passed    = false;

if (is_post()) {
    $submitted = true;
    $username  = post('username');
    $email     = post('email');
    $password  = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';
    $confirm   = isset($_POST['confirm']) && is_string($_POST['confirm']) ? $_POST['confirm'] : '';

    if (!csrf_valid()) {
        $errors[] = 'Your session expired. Please try again.';
    }
    if (!Validator::username($username)) {
        $errors[] = 'Username must be 4 to 20 characters, start with a letter, and use only letters, numbers, and underscores.';
    } elseif (isset(site_data('users')[strtolower($username)])) {
        $errors[] = 'That username is reserved. Please choose another.';
    }
    if (!Validator::email($email)) {
        $errors[] = 'Enter a valid email address that contains an @ symbol.';
    }
    $checks = Validator::passwordChecks($password, $username, site_data('common_passwords'));
    if (!Validator::allPassed($checks)) {
        $errors[] = 'Your password does not meet every strength rule listed below.';
    }
    if ($password !== $confirm) {
        $errors[] = 'The password and confirmation do not match.';
    }
    $passed = count($errors) === 0;
}

$score = Validator::passedCount($checks);
$total = count($checks);
$level = $total > 0 ? (int) floor($score / $total * 5) : 0;

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<h1>Create an Account</h1>
<p class="lead">Join the Beacon Road family to track your gifts and store orders. Choose a strong password to protect your account.</p>

<?php if ($submitted && $passed): ?>
<div class="notice success">
<p><strong>Verification passed.</strong> The username <em><?php echo h($username); ?></em> and your password meet every rule.</p>
<p>In this phase the registration process stops here. Nothing was saved to a file or database. Saving accounts is added in the final project.</p>
</div>
<?php elseif ($submitted): ?>
<div class="notice error">
<p><strong>Verification failed.</strong></p>
<ul>
<?php foreach ($errors as $error): ?>
<li><?php echo h($error); ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php endif; ?>

<?php if ($submitted): ?>
<h2>Password Strength</h2>
<div class="meter"><div class="m<?php echo (int) $level; ?>"></div></div>
<p>You passed <?php echo (int) $score; ?> of <?php echo (int) $total; ?> rules.</p>
<ul class="checklist">
<?php foreach ($checks as $check): ?>
<li class="<?php echo $check['passed'] ? 'pass' : 'fail'; ?>"><?php echo h($check['label']); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<form method="post" action="register.php">
<fieldset>
<legend>Account details</legend>
<div class="form-row"><label class="block" for="username">Username</label>
<input type="text" id="username" name="username" maxlength="20" value="<?php echo h($username); ?>" />
<span class="hint">4 to 20 characters. Start with a letter. Letters, numbers, and underscores only.</span></div>
<div class="form-row"><label class="block" for="email">Email</label>
<input type="text" id="email" name="email" maxlength="254" value="<?php echo h($email); ?>" /></div>
<div class="form-row"><label class="block" for="password">Password</label>
<input type="password" id="password" name="password" maxlength="64" />
<span class="hint">At least 10 characters with uppercase, lowercase, a number, and a symbol. No spaces.</span></div>
<div class="form-row"><label class="block" for="confirm">Confirm password</label>
<input type="password" id="confirm" name="confirm" maxlength="64" /></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Check and Register</button></div>
</fieldset>
</form>
<p>Already have an account? <a href="login.php">Log in</a>.</p>
<?php require_once INC_PATH . '/footer.php'; ?>
