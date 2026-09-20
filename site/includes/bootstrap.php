<?php
/*
 * bootstrap.php: loaded first by every page.
 * Sets site constants, starts the session, and loads classes, helper
 * functions, and site data.
 */
define('SITE_NAME', 'Beacon Road Missions');
define('SITE_TAGLINE', 'Lighting the road to hope, one village at a time');
define('TAX_RATE', 0.07);                  // 7 percent sales tax used for the cart total
define('TIMEZONE', 'America/New_York');
define('ROOT_PATH', dirname(__DIR__));
define('INC_PATH', ROOT_PATH . '/includes');

date_default_timezone_set(TIMEZONE);
ob_start();                                // allows redirects after the header has been prepared

ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
session_start();

spl_autoload_register(function ($class) {
    $file = ROOT_PATH . '/classes/' . $class . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

require_once INC_PATH . '/functions.php';
