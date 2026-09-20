<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'prayer';

$categories = array('Healing and health', 'Family and relationships', 'Guidance and decisions', 'Provision and work', 'Salvation of a loved one', 'Missionaries and the field', 'Thanksgiving', 'Other');
$visibility = array('team' => 'Share only with the intercession team', 'anon' => 'Share anonymously on the weekly prayer list');

$values = array('name' => '', 'email' => '', 'category' => '', 'visibility' => 'team', 'request' => '');
$errors = array();
$sent   = false;

if (is_post()) {
    foreach ($values as $key => $unused) {
        $values[$key] = post($key);
    }
    if (!csrf_valid()) {
        $errors[] = 'Your session expired. Please try again.';
    }
    if ($values['name'] !== '' && !Validator::personName($values['name'])) {
        $errors[] = 'If you give a name, use letters, spaces, apostrophes, periods, or hyphens.';
    }
    if ($values['email'] !== '' && !Validator::email($values['email'])) {
        $errors[] = 'If you give an email address, it must be valid and contain an @ symbol.';
    }
    if (!Validator::inList($values['category'], $categories)) {
        $errors[] = 'Choose a category for your request.';
    }
    if (!array_key_exists($values['visibility'], $visibility)) {
        $errors[] = 'Choose who may see your request.';
    }
    if (!Validator::lengthBetween($values['request'], 10, 800)) {
        $errors[] = 'Your prayer request must be 10 to 800 characters long.';
    }
    $sent = count($errors) === 0;
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<div class="banner"><img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80" width="900" height="220" alt="Candlelight and prayer in a quiet evening setting" /></div>
<h1>Prayer Requests</h1>
<p class="lead">&#8220;Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.&#8221; <strong>Philippians 4:6</strong></p>
<p>Our intercession team prays over every request each week. Share as much or as little as you like. Your name and email are optional.</p>

<?php if ($sent): ?>
<div class="notice success">
<p><strong><?php echo $values['name'] !== '' ? 'Thank you, ' . h($values['name']) . '.' : 'Thank you.'; ?> Your request passed verification.</strong></p>
<p>Category: <?php echo h($values['category']); ?><br />Visibility: <?php echo h($visibility[$values['visibility']]); ?></p>
<p>In this phase requests are validated but not stored. Saving them arrives with the database in the final project. We are praying with you.</p>
</div>
<?php else: ?>
<?php echo render_errors($errors); ?>
<form method="post" action="prayer.php">
<fieldset>
<legend>Share a request</legend>
<div class="form-row"><label class="block" for="name">Your name (optional)</label>
<input type="text" id="name" name="name" maxlength="60" value="<?php echo h($values['name']); ?>" /></div>
<div class="form-row"><label class="block" for="email">Email (optional)</label>
<input type="text" id="email" name="email" maxlength="254" value="<?php echo h($values['email']); ?>" />
<span class="hint">Only if you would like a reply.</span></div>
<div class="form-row"><label class="block" for="category">Category <span class="required">*</span></label>
<select id="category" name="category">
<option value="">Choose a category</option>
<?php foreach ($categories as $category): ?>
<option value="<?php echo h($category); ?>"<?php echo $values['category'] === $category ? ' selected="selected"' : ''; ?>><?php echo h($category); ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row"><span class="block"><strong>Who may see this request? <span class="required">*</span></strong></span>
<?php foreach ($visibility as $key => $label): ?>
<label class="inline" for="vis-<?php echo h($key); ?>"><input type="radio" id="vis-<?php echo h($key); ?>" name="visibility" value="<?php echo h($key); ?>"<?php echo $values['visibility'] === $key ? ' checked="checked"' : ''; ?> /> <?php echo h($label); ?></label><br />
<?php endforeach; ?>
</div>
<div class="form-row"><label class="block" for="request">Your request <span class="required">*</span></label>
<textarea id="request" name="request" rows="6" cols="60"><?php echo h($values['request']); ?></textarea>
<span class="hint">10 to 800 characters.</span></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Send Prayer Request</button></div>
</fieldset>
</form>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
