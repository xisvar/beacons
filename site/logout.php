<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (current_user() !== null) {
    Auth::logout();
    flash('success', 'You have been signed out.');
}
redirect('login.php');
