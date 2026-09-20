<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageId = 'publisher';
require_role('publisher');

$user       = current_user();
$store      = content_store();
$fieldNames = array();
foreach (site_data('fields') as $field) {
    $fieldNames[] = $field['name'];
}
$fieldNames[] = 'All Fields';

$errors = array();
$values = array('title' => '', 'field' => 'All Fields', 'body' => '');

if (is_post()) {
    $action = post('action');
    if (!csrf_valid()) {
        flash('error', 'Your session expired. Please try again.');
        redirect('publisher.php');
    }
    if ($action === 'create') {
        $values['title'] = post('title');
        $values['field'] = post('field');
        $values['body']  = post('body');
        if (!Validator::lengthBetween($values['title'], 5, 80)) {
            $errors[] = 'The title must be 5 to 80 characters long.';
        }
        if (!Validator::inList($values['field'], $fieldNames)) {
            $errors[] = 'Choose a field from the list.';
        }
        if (!Validator::lengthBetween($values['body'], 40, 1200)) {
            $errors[] = 'The update must be 40 to 1200 characters long.';
        }
        if (count($errors) === 0) {
            $store->create($values['title'], $values['body'], $values['field'], $user['display']);
            flash('success', 'Draft saved. Publish it when you are ready.');
            redirect('publisher.php');
        }
    } elseif ($action === 'publish' || $action === 'unpublish') {
        $ok = $store->setStatus(post('id'), $action === 'publish' ? 'published' : 'draft');
        flash($ok ? 'success' : 'error', $ok ? 'Post status updated.' : 'That post could not be found.');
        redirect('publisher.php');
    } elseif ($action === 'delete') {
        $ok = $store->remove(post('id'));
        flash($ok ? 'success' : 'error', $ok ? 'Post deleted.' : 'That post could not be found.');
        redirect('publisher.php');
    }
}

require_once INC_PATH . '/header.php';
require_once INC_PATH . '/menu.php';
$posts = $store->all();
?>
<h1>Publisher Desk</h1>
<p class="lead">Write field updates and publish them to the <a href="stories.php">Field Stories</a> page. Posts are kept in your session during this phase.</p>

<h2>New Field Update</h2>
<?php echo render_errors($errors); ?>
<form method="post" action="publisher.php">
<fieldset>
<legend>Write an update</legend>
<div class="form-row"><label class="block" for="title">Title</label>
<input type="text" id="title" name="title" maxlength="80" value="<?php echo h($values['title']); ?>" /></div>
<div class="form-row"><label class="block" for="field">Field</label>
<select id="field" name="field">
<?php foreach ($fieldNames as $name): ?>
<option value="<?php echo h($name); ?>"<?php echo $values['field'] === $name ? ' selected="selected"' : ''; ?>><?php echo h($name); ?></option>
<?php endforeach; ?>
</select></div>
<div class="form-row"><label class="block" for="body">Update</label>
<textarea id="body" name="body" rows="6" cols="60"><?php echo h($values['body']); ?></textarea>
<span class="hint">40 to 1200 characters.</span></div>
<div class="form-row"><?php echo csrf_field(); ?>
<input type="hidden" name="action" value="create" />
<button type="submit">Save Draft</button></div>
</fieldset>
</form>

<h2>Your Posts</h2>
<?php if (count($posts) === 0): ?>
<p>No posts yet. Write your first update above.</p>
<?php else: ?>
<table summary="Field update posts and their status">
<thead><tr><th scope="col">Title</th><th scope="col">Field</th><th scope="col">Status</th><th scope="col">Actions</th></tr></thead>
<tbody>
<?php foreach ($posts as $post): ?>
<tr>
<td><?php echo h($post['title']); ?></td>
<td><?php echo h($post['field']); ?></td>
<td><span class="tag<?php echo $post['status'] === 'draft' ? ' draft' : ''; ?>"><?php echo h($post['status']); ?></span></td>
<td>
<form method="post" action="publisher.php" class="inline-form"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="id" value="<?php echo (int) $post['id']; ?>" />
<?php if ($post['status'] === 'draft'): ?>
<input type="hidden" name="action" value="publish" />
<button type="submit" class="small-btn">Publish</button>
<?php else: ?>
<input type="hidden" name="action" value="unpublish" />
<button type="submit" class="small-btn">Unpublish</button>
<?php endif; ?>
</div></form>
<form method="post" action="publisher.php" class="inline-form"><div>
<?php echo csrf_field(); ?>
<input type="hidden" name="id" value="<?php echo (int) $post['id']; ?>" />
<input type="hidden" name="action" value="delete" />
<button type="submit" class="small-btn danger">Delete</button>
</div></form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
<?php require_once INC_PATH . '/footer.php'; ?>
