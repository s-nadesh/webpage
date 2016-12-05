<?php

include("config.php");
include_once("include/dbcon.php");
include_once("include/myclass.php");
$dbconnect = new dbconnect();
$myclass = new myclass();

$dir = ROOT . '/logs/';
$archive_dir = ROOT . '/archive/';
$errored_dir = ROOT . '/errored/';

if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..") {
                $file_parts = pathinfo($file);
                if (isset($file_parts['extension']) && $file_parts['extension'] == 'xml') {
                    $info = file_get_contents($dir . $file);
                    $xml = $myclass->everything_in_tags($info, "data:data");
                    $xmlLoad = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $xmlArray = (array) $xmlLoad;

                    $test_headers = $myclass->xml_to_test_header($xmlArray, $file);
                    $test_version = $myclass->xml_to_test_version($xmlArray, $file);
                    $tests = $myclass->xml_to_test($xmlArray, $file);

                    if ($test_headers && $test_version && $tests) {
                        rename($dir . $file, $archive_dir . $file);
                    } else {
                        //TODO - Need to Delete Inserted Records
                        rename($dir . $file, $errored_dir . $file);
                    }
                }
            }
        }
        closedir($dh);
    }
}