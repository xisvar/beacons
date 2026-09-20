<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'fields';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$fields = site_data('fields');
?>
<h1>Where We Serve</h1>
<p class="lead">Four fields, one calling. In each place we serve alongside a local church that knows the people and the language.</p>

<?php foreach ($fields as $field): ?>
<div class="story">
<img class="story-image" src="<?php echo h(image_url($field['image'])); ?>" width="400" height="240" alt="Scene from <?php echo h($field['name']); ?>" />
<div class="story-body">
<h2><?php echo h($field['name']); ?> <span class="tag"><?php echo h($field['region']); ?></span></h2>
<p><?php echo h($field['summary']); ?></p>
<ul>
<?php foreach ($field['work'] as $item): ?>
<li><?php echo h($item); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endforeach; ?>

<p><a class="button" href="stories.php">Read field stories</a> <a class="button gold" href="volunteer.php">Apply to serve</a></p>
<?php require_once INC_PATH . '/footer.php'; ?>
