<?php

include("config.php");
include_once("include/dbcon.php");
include_once("include/myclass.php");

$dbconnect = new dbconnect();
$myclass = new myclass();

$admin_email = $myclass->getSettingValue('ADMIN_EMAIL');

//    $dbconnect->sql = 'SELECT * FROM TESTHEADER WHERE  RCA_BY IS NULL OR ROOT_CAUSE IS NULL OR EXPLAINATION IS NULL AND OVERALLSTATUS NOT LIKE "PASS%"';    
$dbconnect->sql = "SELECT * FROM TESTHEADER WHERE  (RCA_BY IS NULL OR RCA_BY='') OR (ROOT_CAUSE IS NULL OR ROOT_CAUSE='') OR (EXPLAINATION IS NULL OR EXPLAINATION='') AND OVERALLSTATUS NOT LIKE 'PASS%'";
$dbconnect->selecttb();
$testheader = $dbconnect->res;

while ($row = mysql_fetch_array($testheader)) {

    $start = strtotime($row['CREATED_ON']);
    $end = strtotime(date('Y-m-d H:i:s'));

    $days_between = ceil(abs($end - $start) / 86400);
    if ($days_between >= 3) {
//            echo "[IMDB-ALERT]::".$row['PRODUCT'].','.$row['ID'].','.$row['SN'].','.$row['PN'].','.$row['STATIONID'].','.$row['OVERALLSTATUS'].'<br>'; 
//            continue;
//        $date1 = new DateTime("2016-12-08 23:59:59");
//        $date2 = new DateTime("2016-12-10 00:00:00");
//
//        echo $diff = $date2->diff($date1)->format("%a");
//            echo "[IMDB-RCA-REMINDER]:: ".$row['SN'].",".$row['STARTTIME'].", ".$row['STATIONID'].", ".$row['OVERALLSTATUS'];  
        $from = $admin_email['OPTION_VALUE'];
        $subject = "[IMDB-ALERT]::" . $row['SN'] . ',' . $row['PN'] . ',' . $row['STATIONID'] . ',' . $row['OVERALLSTATUS'];

        $alert_product_query = 'SELECT EMAIL_DISTRIBUTION FROM ALERT_PER_PRODUCT WHERE STATUS = 1 AND PRODUCT= "' . $row['PRODUCT'] . '"';
        $dbconnect->sql = $alert_product_query;
        $dbconnect->selecttb();


        while ($row1 = mysql_fetch_array($dbconnect->res)) {

//                $from= $admin_email['OPTION_VALUE'];
            $to = $row1['EMAIL_DISTRIBUTION'];
//                $subject = "[IMDB-ALERT]::".$row['SN'].'-'.$row['PN'].'-'.$row['STATIONID'].'-'.$row['OVERALLSTATUS'];                        
            $msg_header = file_get_contents(SITE_URL . EMAILTEMPLATE . 'header.html');
            $msg_footer = file_get_contents(SITE_URL . EMAILTEMPLATE . 'footer.html');
            $msg_body = '<tr>
                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td  style="padding:20px 20px 0 20px">
                                        <p style="color: #545454; font-size: 13px; line-height: 20px;">Dear User!</p>                                    
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="padding:20px 20px 20px 20px">
                                        <span style="color: #545454; font-size: 13px; line-height: 20px;">Please login to IMDB system and enter the root cause analysis for this test record.</span>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                ';

            $body = $msg_header . $msg_body . $msg_footer;

            $uid = md5(uniqid(time()));

            $headers = "From:  " . $from . "\r\n";
            $headers .= "Reply-To: " . $from . "\r\n";

//
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";

            $nmessage = "--" . $uid . "\r\n";
            $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
            $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $nmessage .= $body . "\r\n\r\n";

            mail($to, $subject, $nmessage, $headers);            
        }
    }
}
echo 'success';
?>
