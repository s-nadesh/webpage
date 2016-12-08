<?php
include("config.php");
include_once("include/dbcon.php");
include_once("include/myclass.php");


$dbconnect = new dbconnect();
$myclass = new myclass();

$admin_email = $myclass->getSettingValue('ADMIN_EMAIL');
    $passed = array();
    $failed = array();
    
    $passed_query = 'SELECT ID FROM TESTHEADER WHERE FLAG=0 AND OVERALLSTATUS LIKE "PASS%"';
    $dbconnect->sql = $passed_query;
    $dbconnect->selecttb();
    
    while ($row = mysql_fetch_array($dbconnect->res)){
        $passed[] = $row['ID'];
        $passed_query = 'UPDATE TESTHEADER SET FLAG=2 WHERE ID='.$row['ID'];
        $dbconnect->sql = $passed_query;
        $dbconnect->updatetb();
    }
    
     $failed_query = 'SELECT * FROM TESTHEADER WHERE FLAG=0 AND OVERALLSTATUS NOT LIKE "PASS%"';
    $dbconnect->sql = $failed_query;
    $dbconnect->selecttb();
    $testheader = $dbconnect->res;
    while ($row = mysql_fetch_array($testheader)){
        
//        $id = $row['ID'];
//        $product = $row['PRODUCT'];
        
        $alert_product_query = 'SELECT EMAIL_DISTRIBUTION FROM ALERT_PER_PRODUCT WHERE STATUS = 1 AND PRODUCT= "'.$row['PRODUCT'].'"';
        $dbconnect->sql = $alert_product_query;
        $dbconnect->selecttb();
        
        while ($row1 = mysql_fetch_array($dbconnect->res)){
            
            $from= $admin_email['OPTION_VALUE'];
            $to = $row1['EMAIL_DISTRIBUTION'];
            $subject = "[IMDB-ALERT]::".$row['SN'].'-'.$row['PN'].'-'.$row['STATIONID'].'-'.$row['OVERALLSTATUS'];                        
            $msg_header = file_get_contents(SITE_URL . EMAILTEMPLATE . 'header.html');
            $msg_footer = file_get_contents(SITE_URL . EMAILTEMPLATE . 'footer.html'); 
            $msg_body ='<tr>
                            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <p style="color: #545454; font-size: 13px; line-height: 20px;">Dear User!</p>                                    
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <span style="color: #545454; font-size: 13px; line-height: 20px;">SN</span> : '.$row['SN'].'                                   
                                </td>
                                
                            </tr>
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <span style="color: #545454; font-size: 13px; line-height: 20px;">PN<span> :'.$row['PN'].'    
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <span style="color: #545454; font-size: 13px; line-height: 20px;">STATIONID</span> :'.$row['STATIONID'].'    
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <span style="color: #545454; font-size: 13px; line-height: 20px;">OVERALLSTATUS</span> :'.$row['OVERALLSTATUS'].'    
                                </td>
                            </tr>
                            <tr>
                                <td  style="padding:20px 20px 0 20px">
                                    <span style="color: #545454; font-size: 13px; line-height: 20px;">TESTREPORT</span> :'.$row['TESTREPORT'].'    
                                </td>
                            </tr>';
           
            $body = $msg_header . $msg_body . $msg_footer;
            
            $attachment = ATTACHMENT.$row['TESTREPORT'];            
            $filename = basename($attachment);            
            $file = $attachment;
            $content = chunk_split(base64_encode(file_get_contents($attachment)));
            
        
            $uid = md5(uniqid(time()));
            
            $headers = "From: Webpage <".$from.">\r\n"; 
                                    
             
            
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

            $nmessage = "--".$uid."\r\n";
            $nmessage .= "Content-type:text/html; charset=iso-8859-1\r\n";
            $nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $nmessage .= $body."\r\n\r\n";
            if($attachment!='')
            { 
                $nmessage .= "--".$uid."\r\n";
                $nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; 
                $nmessage .= "Content-Transfer-Encoding: base64\r\n";
                $nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
                $nmessage .= $content."\r\n\r\n";
                $nmessage .= "--".$uid."--";
            }
            
            
            
            mail($to, $subject, $nmessage, $headers);
        }
              
        
        $passed_query = 'UPDATE TESTHEADER SET FLAG=1 WHERE ID='.$row['ID'];
        $dbconnect->sql = $passed_query;
        $dbconnect->updatetb();
    }
    
    echo 'success';

?>
