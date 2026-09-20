<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'sitemap';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

/* Group pages by the access level needed to view them. */
$groups = array('public' => array(), 'customer' => array(), 'publisher' => array(), 'admin' => array());
foreach (site_data('pages') as $id => $page) {
    $groups[$page['access']][$id] = $page;
}
$labels = array(
    'public'    => 'Public Pages',
    'customer'  => 'Customer Pages (login required)',
    'publisher' => 'Publisher Pages (publisher or administrator)',
    'admin'     => 'Administrator Pages',
);
?>
<h1>Site Map</h1>
<p class="lead">Every page on the Beacon Road Missions website, grouped by who can view it.</p>

<?php foreach ($groups as $level => $pages): ?>
<?php if (count($pages) > 0): ?>
<h2><?php echo h($labels[$level]); ?></h2>
<ul>
<?php foreach ($pages as $page): ?>
<li><a href="<?php echo h($page['file']); ?>"><?php echo h($page['title']); ?></a>: <?php echo h($page['desc']); ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php endforeach; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
