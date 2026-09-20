<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'about';
require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';

$values = array(
    array('title' => 'Scripture Leads',      'text' => 'We begin with the Bible. It shapes our priorities, our plans, and the way we treat every person we meet.'),
    array('title' => 'Churches Lead',        'text' => 'We serve under the direction of local pastors. We do not import a program. We support one that already belongs to the community.'),
    array('title' => 'Stewardship Matters',  'text' => 'Every gift is entrusted to us by God and by generous people. We publish our goals and report our results plainly.'),
    array('title' => 'Dignity for All',      'text' => 'Every person is made in the image of God. Help should never humiliate the one who receives it.'),
);
?>
<div class="banner"><img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1600&q=80" width="900" height="220" alt="Mission team meeting with community members at sunset" /></div>

<h1>Our Story</h1>
<p class="lead">Beacon Road began in a church basement, with seven friends and one borrowed map.</p>
<p>In the spring after a long drought, a small group in our home congregation heard a visiting pastor from Kenya describe a village where children missed school every morning to carry water. They did not have a large budget, but they had a conviction from Scripture that faith without works is dead. Within a year, the group had raised enough to help that village drill its first well. The road they walked to get there became the name of the mission.</p>
<p>Since then, the work has grown into four fields. What has stayed the same is the pattern. We listen first. We ask local pastors what their communities need. We send trained teams alongside them, and we measure success by how much of the work the community can carry on without us.</p>

<h2>What We Believe</h2>
<p>We hold to the historic Christian faith. God created the world and loves it. Jesus Christ lived, died, and rose again to rescue sinners. The Holy Spirit empowers the church to proclaim the gospel and to care for the poor, the sick, and the stranger. The Bible is our authority for faith and practice.</p>

<h2>Our Core Values</h2>
<div class="cards">
<?php foreach ($values as $value): ?>
<div class="card">
<div class="card-body">
<h3><?php echo h($value['title']); ?></h3>
<p><?php echo h($value['text']); ?></p>
</div>
</div>
<?php endforeach; ?>
</div>

<div class="callout">
<p>&#8220;And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.&#8221; <strong>Micah 6:8</strong></p>
</div>
<p><a class="button" href="mission.php">Read our vision and goals</a></p>
<?php require_once INC_PATH . '/footer.php'; ?>
