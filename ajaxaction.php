<?php
include_once("include/dbcon.php");
include_once("include/myclass.php");
$dbconnect = new dbconnect();
$myclass = new myclass();

if(isset($_POST['id'])){
    $query = 'SELECT STATUS FROM ALERT_PER_PRODUCT WHERE ID='.$_POST['id'];
    $dbconnect->sql = $query;
    $dbconnect->selecttb();
    $results = ($dbconnect->nrow!='0') ? mysql_fetch_array($dbconnect->res) : '0';
    
    if($results){
        $status = ($results['STATUS']=='1')? '0': '1';
        $dbconnect->sql = "UPDATE ALERT_PER_PRODUCT SET STATUS='".$status."' WHERE ID=".$_POST['id'];
        $dbconnect->updatetb();
        echo ($results['STATUS']=='1')? 'Enable': 'Disable';
    }else{
        echo 'not_found';
    }   
}
?>