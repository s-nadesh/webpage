<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
//   $dbhost = 'localhost';
//   $dbuser = 'rajencba_webpage';
//   $dbpass = 'kkPc)bI[ab86';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db("webpage");

if (!defined('SITE_URL')) {
    define('SITE_URL', 'http://localhost/webpage/branches/dev/');
}
?>
