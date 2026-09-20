<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'account';
require_role('customer');

$user  = current_user();
$roles = site_data('roles');
$abilities = array(
    'customer'  => array('Shop and manage your cart', 'View your account page'),
    'publisher' => array('Everything a customer can do', 'Write and publish field updates on the Publisher Desk'),
    'admin'     => array('Everything a publisher can do', 'Edit product prices and stock', 'View pages and accounts in the Admin Panel'),
);
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<h1>My Account</h1>
<p class="lead">Welcome, <?php echo h($user['display']); ?>.</p>

<table summary="Your session details">
<tbody>
<tr><th scope="row">Username</th><td><?php echo h($user['username']); ?></td></tr>
<tr><th scope="row">Access level</th><td><span class="tag role"><?php echo h($user['role']); ?></span> (level <?php echo (int) $roles[$user['role']]; ?> of <?php echo (int) max($roles); ?>)</td></tr>
<tr><th scope="row">Items in cart</th><td><?php echo h(cart_label()); ?></td></tr>
</tbody>
</table>

<h2>What Each Access Level Can Do</h2>
<div class="cards three-up">
<?php foreach ($abilities as $role => $list): ?>
<div class="card">
<div class="card-body">
<h3><?php echo h(ucfirst($role)); ?><?php echo $role === $user['role'] ? ' (you)' : ''; ?></h3>
<ul>
<?php foreach ($list as $item): ?>
<li><?php echo h($item); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endforeach; ?>
</div>

<p>
<a class="button" href="store.php">Shop the store</a>
<?php if (auth()->can('publisher')): ?><a class="button gold" href="publisher.php">Publisher Desk</a><?php endif; ?>
<?php if (auth()->can('admin')): ?><a class="button gold" href="admin.php">Admin Panel</a><?php endif; ?>
<a class="button danger" href="logout.php">Log Out</a>
</p>
<?php require_once INC_PATH . '/footer.php'; ?>
