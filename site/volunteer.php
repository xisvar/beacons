<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'volunteer';

$skills = site_data('skills');
$fieldChoices = array();
foreach (site_data('fields') as $field) {
    $fieldChoices[] = $field['name'];
}
$fieldChoices[] = 'Wherever I am needed';
$terms = array('short' => 'Short term (1 to 3 weeks)', 'mid' => 'Mid term (3 to 12 months)', 'long' => 'Long term (1 year or more)');

$values = array('name' => '', 'email' => '', 'phone' => '', 'age' => '', 'field' => '', 'term' => '', 'start' => '', 'story' => '');
$chosenSkills = array();
$agree  = false;
$errors = array();
$done   = false;

if (is_post()) {
    foreach ($values as $key => $unused) {
        $values[$key] = post($key);
    }
    $chosenSkills = isset($_POST['skills']) && is_array($_POST['skills']) ? array_values(array_filter($_POST['skills'], 'is_string')) : array();
    $agree = post('agree') === 'yes';

    if (!csrf_valid()) {
        $errors[] = 'Your session expired. Please try again.';
    }
    if (!Validator::personName($values['name'])) {
        $errors[] = 'Enter your name using letters, spaces, apostrophes, periods, or hyphens.';
    }
    if (!Validator::email($values['email'])) {
        $errors[] = 'Enter a valid email address that contains an @ symbol.';
    }
    if (!Validator::phone($values['phone'])) {
        $errors[] = 'Enter a phone number with 7 to 15 digits.';
    }
    if (!Validator::intBetween($values['age'], 18, 85)) {
        $errors[] = 'Age must be a whole number from 18 to 85.';
    }
    if (!Validator::inList($values['field'], $fieldChoices)) {
        $errors[] = 'Choose a field of service.';
    }
    if (!array_key_exists($values['term'], $terms)) {
        $errors[] = 'Choose a length of service.';
    }
    if (!Validator::date($values['start'])) {
        $errors[] = 'Enter your earliest start date as YYYY-MM-DD, for example 2027-03-15.';
    } elseif ($values['start'] <= date('Y-m-d') || $values['start'] > date('Y-m-d', strtotime('+2 years'))) {
        $errors[] = 'The start date must be in the future and within two years.';
    }
    if (count($chosenSkills) === 0) {
        $errors[] = 'Check at least one skill you can offer.';
    } else {
        foreach ($chosenSkills as $skillKey) {
            if (!array_key_exists($skillKey, $skills)) {
                $errors[] = 'One of the selected skills is not valid.';
                break;
            }
        }
    }
    if (!Validator::lengthBetween($values['story'], 30, 800)) {
        $errors[] = 'Tell us about your faith and why you want to serve (30 to 800 characters).';
    }
    if (!$agree) {
        $errors[] = 'You must confirm the statement of faith and background check acknowledgment.';
    }
    $done = count($errors) === 0;
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
?>
<h1>Serve With Us</h1>
<p class="lead">Our teams need teachers, nurses, builders, writers, and people who love to pray. If God is stirring your heart, start here.</p>

<?php if ($done): ?>
<div class="notice success">
<p><strong>Thank you, <?php echo h($values['name']); ?>. Your application passed verification.</strong></p>
<p>You applied to serve in <?php echo h($values['field']); ?> for a <?php echo h(strtolower($terms[$values['term']])); ?> beginning on or after <?php echo h($values['start']); ?>.</p>
<p>Skills you offered:</p>
<ul>
<?php foreach ($chosenSkills as $skillKey): ?>
<li><?php echo h($skills[$skillKey]); ?></li>
<?php endforeach; ?>
</ul>
<p>In this phase applications are validated but not stored. Saving them arrives with the database in the final project.</p>
</div>
<?php else: ?>
<?php echo render_errors($errors); ?>
<form method="post" action="volunteer.php">
<fieldset>
<legend>About you</legend>
<div class="form-row"><label class="block" for="name">Full name <span class="required">*</span></label>
<input type="text" id="name" name="name" maxlength="60" value="<?php echo h($values['name']); ?>" /></div>
<div class="form-row"><label class="block" for="email">Email <span class="required">*</span></label>
<input type="text" id="email" name="email" maxlength="254" value="<?php echo h($values['email']); ?>" /></div>
<div class="form-row"><label class="block" for="phone">Phone <span class="required">*</span></label>
<input type="text" id="phone" name="phone" maxlength="20" value="<?php echo h($values['phone']); ?>" /></div>
<div class="form-row"><label class="block" for="age">Age <span class="required">*</span></label>
<input type="text" id="age" name="age" class="qty" maxlength="2" value="<?php echo h($values['age']); ?>" />
<span class="hint">Volunteers must be 18 or older. Numbers only.</span></div>
</fieldset>

<fieldset>
<legend>Your service</legend>
<div class="form-row"><label class="block" for="field">Field of service <span class="required">*</span></label>
<select id="field" name="field">
<option value="">Choose a field</option>
<?php foreach ($fieldChoices as $choice): ?>
<option value="<?php echo h($choice); ?>"<?php echo $values['field'] === $choice ? ' selected="selected"' : ''; ?>><?php echo h($choice); ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row"><span class="block"><strong>Length of service <span class="required">*</span></strong></span>
<?php foreach ($terms as $key => $label): ?>
<label class="inline" for="term-<?php echo h($key); ?>"><input type="radio" id="term-<?php echo h($key); ?>" name="term" value="<?php echo h($key); ?>"<?php echo $values['term'] === $key ? ' checked="checked"' : ''; ?> /> <?php echo h($label); ?></label><br />
<?php endforeach; ?>
</div>
<div class="form-row"><label class="block" for="start">Earliest start date <span class="required">*</span></label>
<input type="text" id="start" name="start" class="qty" maxlength="10" value="<?php echo h($values['start']); ?>" />
<span class="hint">Format YYYY-MM-DD.</span></div>
<div class="form-row"><span class="block"><strong>Skills you can offer <span class="required">*</span></strong></span>
<?php foreach ($skills as $key => $label): ?>
<label class="inline" for="skill-<?php echo h($key); ?>"><input type="checkbox" id="skill-<?php echo h($key); ?>" name="skills[]" value="<?php echo h($key); ?>"<?php echo in_array($key, $chosenSkills, true) ? ' checked="checked"' : ''; ?> /> <?php echo h($label); ?></label><br />
<?php endforeach; ?>
</div>
</fieldset>

<fieldset>
<legend>Your story</legend>
<div class="form-row"><label class="block" for="story">Tell us about your faith and why you want to serve <span class="required">*</span></label>
<textarea id="story" name="story" rows="6" cols="60"><?php echo h($values['story']); ?></textarea>
<span class="hint">30 to 800 characters.</span></div>
<div class="form-row"><label class="inline" for="agree"><input type="checkbox" id="agree" name="agree" value="yes"<?php echo $agree ? ' checked="checked"' : ''; ?> /> I agree with the Beacon Road statement of faith and understand that all volunteers complete a background check. <span class="required">*</span></label></div>
<div class="form-row"><?php echo csrf_field(); ?>
<button type="submit">Submit Application</button></div>
</fieldset>
</form>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
