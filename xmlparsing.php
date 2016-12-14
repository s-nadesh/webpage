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
                    $is_delete = false;

                    if ($test_headers) {
                        $serial_number = $myclass->s_no;
                        $start_time = $myclass->s_date;
                        $test_version = $myclass->xml_to_test_version($xmlArray, $file);
                        if ($test_version) {
                            $tests = $myclass->xml_to_test($xmlArray, $file);
                            if ($tests) {
                                rename($dir . $file, $archive_dir . $file);
                            } else {
                                rename($dir . $file, $errored_dir . $file);
                                $is_delete = true;
                            }
                        } else {
                            rename($dir . $file, $errored_dir . $file);
                            $is_delete = true;
                        }
                    } else {
                        if($myclass->exists){
                            rename($dir . $file, $archive_dir . $file);
                        }  else {
                            rename($dir . $file, $errored_dir . $file);
                        }
                        
                    }

                    if ($is_delete) {
                        $list_tables = ['XML_TO_TESTHEADER', 'XML_TO_TESTVERSION', 'XML_TO_TESTS'];
                        foreach ($list_tables as $list_table) {
                            $myclass->deleteRows($list_table, $serial_number, $start_time);
                        }
                    }
                }
            }
        }
        closedir($dh);
    }
}