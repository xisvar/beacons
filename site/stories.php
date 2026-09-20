<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'stories';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$stories   = site_data('stories');
$published = content_store()->published();
?>
<h1>Field Stories</h1>
<p class="lead">Behind every number is a name. These stories come from the communities we serve.</p>

<?php if (count($published) > 0): ?>
<h2>Latest Field Updates</h2>
<?php foreach ($published as $post): ?>
<div class="callout">
<h3><?php echo h($post['title']); ?> <span class="tag"><?php echo h($post['field']); ?></span></h3>
<p><?php echo nl2br(h($post['body'])); ?></p>
<p class="small">Posted <?php echo h($post['created']); ?> by <?php echo h($post['author']); ?></p>
</div>
<?php endforeach; ?>
<h2>Featured Stories</h2>
<?php endif; ?>

<?php foreach ($stories as $story): ?>
<div class="story story-feature">
<img class="story-image" src="<?php echo h(image_url($story['image'])); ?>" width="400" height="240" alt="Photo for <?php echo h($story['title']); ?>" />
<div class="story-body">
<h3><?php echo h($story['title']); ?> <span class="tag"><?php echo h($story['field']); ?></span></h3>
<p><?php echo h($story['body']); ?></p>
</div>
</div>
<?php endforeach; ?>

<p class="small">Publishers can add field updates from the <a href="publisher.php">Publisher Desk</a>.</p>
<?php require_once INC_PATH . '/footer.php'; ?>
