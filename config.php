<?php
//date_default_timezone_set('UTC');
date_default_timezone_set('America/Los_Angeles');
if (!defined('SITE_URL')) {
    define('SITE_URL', 'http://localhost/webpage/branches/dev/');
}

if (!defined('LOGIN_URL')) {
    define('LOGIN_URL', 'http://localhost/webpage/branches/dev/login.php');
}

if (!defined('EMAILTEMPLATE')) {
    define('EMAILTEMPLATE', '/mail/');
}

if (!defined('ATTACHMENT')) {
    define('ATTACHMENT', 'http://localhost/webpage/branches/dev/webpage/uploads/');
}

if (!defined('ROOT')) {
    define('ROOT', dirname(__FILE__));
}