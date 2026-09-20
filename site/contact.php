<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'contact';

$subjects = array('General question', 'Store order help', 'Partnership or church contact', 'Media inquiry', 'Other');
$values   = array('name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => '');
$errors   = array();
$sent     = false;

if (is_post()) {
    foreach ($values as $key => $unused) {
        $values[$key] = post($key);
    }
    if (!csrf_valid()) {
        $errors[] = 'Your session expired. Please try again.';
    }
    if (!Validator::personName($values['name'])) {
        $errors[] = 'Enter your name using letters, spaces, apostrophes, periods, or hyphens.';
    }
    if (!Validator::email($values['email'])) {
        $errors[] = 'Enter a valid email address that contains an @ symbol.';
    }
    if ($values['phone'] !== '' && !Validator::phone($values['phone'])) {
        $errors[] = 'Enter a phone number with 7 to 15 digits, or leave it blank.';
    }
    if (!Validator::inList($values['subject'], $subjects)) {
        $errors[] = 'Choose a subject from the list.';
    }
    if (!Validator::lengthBetween($values['message'], 20, 1000)) {
        $errors[] = 'Your message must be 20 to 1000 characters long.';
    }
    $sent = count($errors) === 0;
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<div class="banner"><img src="https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1600&q=80" width="900" height="220" alt="Warm sunlight falling on a desk with a letter and notebook" /></div>
<h1>Contact Us</h1>
<p class="lead">We would love to hear from you. Send a note to the Beacon Road office and a team member will reply within three business days.</p>

<?php if ($sent): ?>
<div class="notice success">
<p><strong>Thank you, <?php echo h($values['name']); ?>. Your message passed verification.</strong></p>
<p>Subject: <?php echo h($values['subject']); ?><br />Reply to: <?php echo h($values['email']); ?></p>
<p>In this phase messages are validated but not stored or emailed. Delivery is added with the database in the final project.</p>
</div>
<?php else: ?>
<?php echo render_errors($errors); ?>
<form method="post" action="contact.php">
<fieldset>
<legend>Send a message</legend>
<div class="form-row"><label class="block" for="name">Your name <span class="required">*</span></label>
<input type="text" id="name" name="name" maxlength="60" value="<?php echo h($values['name']); ?>" /></div>
<div class="form-row"><label class="block" for="email">Email <span class="required">*</span></label>
<input type="text" id="email" name="email" maxlength="254" value="<?php echo h($values['email']); ?>" /></div>
<div class="form-row"><label class="block" for="phone">Phone (optional)</label>
<input type="text" id="phone" name="phone" maxlength="20" value="<?php echo h($values['phone']); ?>" />
<span class="hint">Digits, spaces, dashes, and parentheses are accepted.</span></div>
<div class="form-row"><label class="block" for="subject">Subject <span class="required">*</span></label>
<select id="subject" name="subject">
<option value="">Choose a subject</option>
<?php foreach ($subjects as $subject): ?>
<option value="<?php echo h($subject); ?>"<?php echo $values['subject'] === $subject ? ' selected="selected"' : ''; ?>><?php echo h($subject); ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row"><label class="block" for="message">Message <span class="required">*</span></label>
<textarea id="message" name="message" rows="7" cols="60"><?php echo h($values['message']); ?></textarea>
<span class="hint">20 to 1000 characters.</span></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Send Message</button></div>
</fieldset>
</form>
<?php endif; ?>

<div class="callout">
<p><strong>Beacon Road Missions</strong><br />100 Lantern Way, Suite 4<br />Lynchburg, VA 24502 (fictional address)</p>
</div>
<?php require_once INC_PATH . '/footer.php'; ?>
