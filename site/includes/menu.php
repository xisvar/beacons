<?php
/*
 * menu.php: main navigation, built from the pages array so a new page
 * only needs one new row of data. Also opens the content and main columns
 * that footer.php closes.
 */
$menuPages = site_data('pages');
?>
<div id="nav">
<ul>
<?php foreach ($menuPages as $id => $page): ?>
<?php if ($page['nav'] === 'main'): ?>
<li<?php echo is_current($page['file']) ? ' class="current"' : ''; ?>><a href="<?php echo h($page['file']); ?>"><?php echo h($page['title']); ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</div>

<div id="content">
<div id="main">
<?php echo render_flash(); ?>
