<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'mission';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$objectives = site_data('objectives');
$goals = array(
    'Meet urgent physical needs such as clean water, medical care, and food security.',
    'Equip local churches to lead lasting ministry in their own communities.',
    'Teach children and adults to read so that they can read the Bible for themselves.',
    'Steward every donation with transparency and give an honest report each year.',
);
?>
<h1>Vision and Goals</h1>

<h2>Our Vision</h2>
<p class="lead">A world where every community has clean water, a place to learn, access to care, and a church that shines the light of Christ.</p>

<h2>Our Mission</h2>
<p>Beacon Road Missions serves the poor and proclaims the gospel by partnering with local churches to provide water, education, and health care in the name of Jesus.</p>

<h2>Our Goals</h2>
<ol>
<?php foreach ($goals as $goal): ?>
<li><?php echo h($goal); ?></li>
<?php endforeach; ?>
</ol>

<h2>Measurable Objectives</h2>
<p>Goals are only useful when we can check them. These are the objectives our board has adopted.</p>
<table summary="Objectives with targets and completion years">
<thead>
<tr><th scope="col">Focus</th><th scope="col">Objective</th><th scope="col" class="num">Target Year</th></tr>
</thead>
<tbody>
<?php foreach ($objectives as $objective): ?>
<tr>
<td><?php echo h($objective['goal']); ?></td>
<td><?php echo h($objective['target']); ?></td>
<td class="num"><?php echo h($objective['year']); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="callout">
<p>&#8220;Let your light shine before others, that they may see your good deeds and glorify your Father in heaven.&#8221; <strong>Matthew 5:16</strong></p>
</div>
<p><a class="button" href="fields.php">See where we work</a> <a class="button gold" href="volunteer.php">Serve with us</a></p>
<?php require_once INC_PATH . '/footer.php'; ?>
