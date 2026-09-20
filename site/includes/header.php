<?php
/*
 * header.php: document head, banner, and account bar.
 * Each page sets $pageId before including this file.
 */
$info      = page_info($pageId);
$pageTitle = $info['title'] . ' | ' . SITE_NAME;
$user      = current_user();
header('Content-Type: text/html; charset=utf-8');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo h($pageTitle); ?></title>
<meta name="description" content="<?php echo h($info['desc']); ?>" />
<meta name="keywords" content="Christian missions, clean water, Bible, mission store, volunteer, prayer, Beacon Road Missions" />
<meta name="author" content="Beacon Road Missions" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="page">

<div id="account-bar">
<ul>
<?php if ($user !== null): ?>
<li class="who">Signed in as <?php echo h($user['display']); ?> (<?php echo h($user['role']); ?>)</li>
<li><a href="account.php">My Account</a></li>
<?php if (auth()->can('publisher')): ?><li><a href="publisher.php">Publisher Desk</a></li><?php endif; ?>
<?php if (auth()->can('admin')): ?><li><a href="admin.php">Admin Panel</a></li><?php endif; ?>
<li><a href="logout.php">Log Out</a></li>
<?php else: ?>
<li><a href="login.php">Log In</a></li>
<li><a href="register.php">Create Account</a></li>
<?php endif; ?>
<li><a href="cart.php">Cart (<?php echo h(cart_label()); ?>)</a></li>
</ul>
</div>

<div id="header">
<a href="index.php" class="brand"><img src="images/logo.svg" width="64" height="64" alt="Beacon Road Missions lighthouse logo" /></a>
<div class="brand-text">
<p class="site-name"><a href="index.php"><?php echo h(SITE_NAME); ?></a></p>
<p class="tagline"><?php echo h(SITE_TAGLINE); ?></p>
</div>
</div>
