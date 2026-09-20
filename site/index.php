<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'home';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$fields     = site_data('fields');
$objectives = site_data('objectives');
$featured   = array_slice(catalog()->all(), 0, 3, true);
?>
<div class="hero"><img src="https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=1600&q=80" width="900" height="360" alt="Open Bible and prayerful mission work in a faith-centered setting" /></div>

<h1>Follow the light. Carry it to others.</h1>
<p class="lead">Beacon Road Missions partners with local churches in four countries to bring clean water, education, medical care, and the good news of Jesus Christ to communities that have waited too long for help.</p>
<p>We believe the gospel is both spoken and lived. Jesus fed the hungry, healed the sick, and taught the ignorant, and he sent his followers to do the same. Every well we drill, every reading class we start, and every clinic day we run is offered in his name and led by neighbors who will remain long after our teams fly home.</p>

<div class="stats">
<?php foreach ($objectives as $objective): ?>
<div class="stat"><strong><?php echo h($objective['year']); ?></strong><?php echo h($objective['goal']); ?> goal</div>
<?php endforeach; ?>
</div>

<h2>Where We Serve</h2>
<div class="cards">
<?php foreach ($fields as $field): ?>
<div class="card">
<img src="<?php echo h(image_url($field['image'])); ?>" width="400" height="240" alt="Scene from <?php echo h($field['name']); ?>" />
<div class="card-body">
<h3><?php echo h($field['name']); ?></h3>
<p><?php echo h($field['summary']); ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
<p><a class="button" href="fields.php">Meet our four fields</a></p>

<h2>From the Mission Store</h2>
<p>Every book, gift, and cup of coffee in our store carries a purpose. Proceeds fund wells, classrooms, and clinics.</p>
<div class="product-grid">
<?php foreach ($featured as $product): ?>
<?php echo render_product_card($product, 'index.php'); ?>
<?php endforeach; ?>
</div>
<p><a class="button gold" href="store.php">Browse the whole store</a></p>

<div class="callout">
<p><strong>Will you pray with us?</strong> Every project begins on our knees. Send us a request or join our weekly intercession list.</p>
<p><a href="prayer.php">Share a prayer request</a> or <a href="volunteer.php">apply to serve on a team</a>.</p>
</div>
<?php require_once INC_PATH . '/footer.php'; ?>
