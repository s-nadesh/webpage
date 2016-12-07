<?php

class myclass {

    public $count;
    public $res;
    public $from;
    public $to;
    private $dbconnect;

    function __construct() {
        $this->dbconnect = new dbconnect;
    }

    function getTestedCount($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }

        $query = "SELECT COUNT(*) as total  FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT LIKE '" . $product . "')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $results = mysql_fetch_array($this->dbconnect->res);
        $this->count = $results['total'];
    }

    function getTested($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }

        $query = "SELECT *  FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT LIKE '" . $product . "')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $this->res = $this->dbconnect->res;
    }

    function getPassedCount($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }
        $query = "SELECT COUNT(*) as total  FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT LIKE '" . $product . "' AND OVERALLSTATUS LIKE 'PASS%')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $results = mysql_fetch_array($this->dbconnect->res);
        $this->count = $results['total'];
    }

    function getPassed($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }
        $query = "SELECT * FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT LIKE '" . $product . "' AND OVERALLSTATUS LIKE 'PASS%')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $this->res = $this->dbconnect->res;
    }

    function getFailedCount($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }
        $query = "SELECT COUNT(*) as total  FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT NOT LIKE '" . $product . "' AND OVERALLSTATUS LIKE 'PASS%')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $results = mysql_fetch_array($this->dbconnect->res);
        $this->count = $results['total'];
    }

    function getFailed($station_id, $product, $week) {
        if ($week == 'last') {
            $this->getLastWeek();
        } else {
            $this->getCurrentWeek();
        }
        $query = "SELECT * FROM TESTHEADER D WHERE
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT NOT LIKE '" . $product . "' AND OVERALLSTATUS LIKE 'PASS%')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $this->res = $this->dbconnect->res;
    }

    function getPercentage($tested, $passed) {
        if ($tested == 0) {
            return 'NA';
        }
        $result = @($passed / $tested) * 100;
        return number_format((float) $result, 2, '.', '') . '%';
    }

    function getLastWeek() {
        $previous_week = strtotime("-1 week +1 day");
        $start_lweek = strtotime("last sunday midnight", $previous_week);
        $end_lweek = strtotime("next saturday", $start_lweek);
        $this->from = date("Y-m-d", $start_lweek);
        $this->to = date("Y-m-d", $end_lweek);
    }

    function getCurrentWeek() {
        $today = strtotime("today");
        $start_cweek = strtotime("last sunday midnight", $today);
        $this->from = date("Y-m-d", $start_cweek);
        $this->to = date("Y-m-d");
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function resetPassword($id) {
        $org_password = $this->generateRandomString();
        $password = md5($org_password);

        $login_detail_query = "UPDATE LOGIN_DETAILS SET PASSWORD='" . $password . "',ORG_PASSWORD='" . $org_password . "' WHERE ID='" . $id . "';";
        $this->dbconnect->sql = $login_detail_query;
        $this->dbconnect->updatetb();
        return true;
    }

    function setSettingValue($opt_name, $opt_value) {
        $select_query = "SELECT COUNT(*) as total FROM ADMIN_SETTINGS WHERE OPTION_NAME = '{$opt_name}'";
        $this->dbconnect->sql = $select_query;
        $this->dbconnect->selecttb();
        $results = mysql_fetch_array($this->dbconnect->res);

        if ($results['total'] > 0) {
            $query = "UPDATE ADMIN_SETTINGS SET OPTION_VALUE='{$opt_value}' WHERE OPTION_NAME='{$opt_name}';";
            $this->dbconnect->sql = $query;
            $this->dbconnect->updatetb();
        } else {
            $query = "INSERT INTO ADMIN_SETTINGS (OPTION_NAME, OPTION_VALUE) VALUES ('{$opt_name}', '{$opt_value}');";
            $this->dbconnect->sql = $query;
            $this->dbconnect->inserttb();
        }
        return true;
    }

    function getSettingValue($opt_name) {
        $select_query = "SELECT * FROM ADMIN_SETTINGS WHERE OPTION_NAME = '{$opt_name}'";
        $this->dbconnect->sql = $select_query;
        $this->dbconnect->selecttb();
        $results = mysql_fetch_array($this->dbconnect->res, MYSQL_ASSOC);

        return $results;
    }

    function everything_in_tags($string, $tagname) {
        $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
        preg_match($pattern, $string, $matches);
        return $matches[1];
    }

    function xml_to_test_header($xmlArray, $file_name) {
        $SERIAL_NUMBER = $PART_NUMBER = $COMPONENT = $CHASSIS_SERIAL_NUMBER = $HWS = '';
        $SOFTWARE_SKU = $PURCHASE_ORDER = $SALES_ORDER = $SALES_COUNTRY = $STATION_ID = '';
        $SITE_NAME = $TEST_AUTOMATION_COMPUTER = $CELL = $TESTBLOX_VERSION = $USER_ID = '';
        $DEPLOYMENT = $START_TIME = $END_TIME = $DURATION = $TEST_STATUS = '';
        $TIME_TO_FIRST_FAILURE = $FILE_NAME = '';

        if (isset($xmlArray['SerialNum']))
            $SERIAL_NUMBER = mysql_real_escape_string($xmlArray['SerialNum']);

        if (isset($xmlArray['PartNum']))
            $PART_NUMBER = mysql_real_escape_string($xmlArray['PartNum']);

        if (isset($xmlArray['Location']))
            $COMPONENT = mysql_real_escape_string($xmlArray['Location']);

        if (isset($xmlArray['ChassisSN']))
            $CHASSIS_SERIAL_NUMBER = mysql_real_escape_string($xmlArray['ChassisSN']);

        if (isset($xmlArray['HWS']))
            $HWS = mysql_real_escape_string($xmlArray['HWS']);

        if (isset($xmlArray['SoftwareSKU']))
            $SOFTWARE_SKU = mysql_real_escape_string($xmlArray['SoftwareSKU']);

        if (isset($xmlArray['PurchaseOrder']))
            $PURCHASE_ORDER = mysql_real_escape_string($xmlArray['PurchaseOrder']);

        if (isset($xmlArray['SalesOrder']))
            $SALES_ORDER = mysql_real_escape_string($xmlArray['SalesOrder']);

        if (isset($xmlArray['SalesCountry']))
            $SALES_COUNTRY = mysql_real_escape_string($xmlArray['SalesCountry']);

        if (isset($xmlArray['StationID']))
            $STATION_ID = mysql_real_escape_string($xmlArray['StationID']);

        if (isset($xmlArray['SITE_NAME'])) // NOT IN XML
            $SITE_NAME = $xmlArray['SITE_NAME'];

        if (isset($xmlArray['ComputerName']))
            $TEST_AUTOMATION_COMPUTER = mysql_real_escape_string($xmlArray['ComputerName']);

        if (isset($xmlArray['Cell']))
            $CELL = mysql_real_escape_string($xmlArray['Cell']);

        if (isset($xmlArray['TAVersion']))
            $TESTBLOX_VERSION = mysql_real_escape_string($xmlArray['TAVersion']);

        if (isset($xmlArray['UserID']))
            $USER_ID = mysql_real_escape_string($xmlArray['UserID']);

        if (isset($xmlArray['Deployment']))
            $DEPLOYMENT = mysql_real_escape_string($xmlArray['Deployment']);

        if (isset($xmlArray['StartTime']))
            $START_TIME = date('Y-m-d H:i:s',strtotime(mysql_real_escape_string($xmlArray['StartTime'])));

        if (isset($xmlArray['EndTime']))
            $END_TIME = date('Y-m-d H:i:s',strtotime(mysql_real_escape_string($xmlArray['EndTime'])));

        if (isset($xmlArray['TotalTestTime']))
            $DURATION = mysql_real_escape_string($xmlArray['TotalTestTime']);

        if (isset($xmlArray['Status']))
            $TEST_STATUS = mysql_real_escape_string($xmlArray['Status']);

        if (isset($xmlArray['TTF']))
            $TIME_TO_FIRST_FAILURE = mysql_real_escape_string($xmlArray['TTF']);

        if (isset($file_name))
            $FILE_NAME = mysql_real_escape_string($file_name);

        $query = "INSERT INTO XML_TO_TESTHEADER (SERIAL_NUMBER, PART_NUMBER, COMPONENT, CHASSIS_SERIAL_NUMBER, HWS, SOFTWARE_SKU, PURCHASE_ORDER, SALES_ORDER, SALES_COUNTRY, STATION_ID, SITE_NAME, TEST_AUTOMATION_COMPUTER, CELL, TESTBLOX_VERSION, USER_ID, DEPLOYMENT, START_TIME, END_TIME, DURATION, TEST_STATUS, TIME_TO_FIRST_FAILURE, FILE_NAME) VALUES ('{$SERIAL_NUMBER}', '{$PART_NUMBER}', '{$COMPONENT}', '{$CHASSIS_SERIAL_NUMBER}', '{$HWS}', '{$SOFTWARE_SKU}', '{$PURCHASE_ORDER}', '{$SALES_ORDER}', '{$SALES_COUNTRY}', '{$STATION_ID}', '{$SITE_NAME}', '{$TEST_AUTOMATION_COMPUTER}', '{$CELL}', '{$TESTBLOX_VERSION}', '{$USER_ID}', '{$DEPLOYMENT}', '{$START_TIME}', '{$END_TIME}', '{$DURATION}', '{$TEST_STATUS}', '{$TIME_TO_FIRST_FAILURE}', '{$FILE_NAME}');";
        $this->dbconnect->sql = $query;
        $this->dbconnect->inserttb();

        return true;
    }

    function xml_to_test_version($xmlArray, $file_name) {
        $SERIAL_NUMBER = $START_TIME = $FILE_NAME = $TESTSTATUS = '';
        if (isset($xmlArray['SerialNum']))
            $SERIAL_NUMBER = mysql_real_escape_string($xmlArray['SerialNum']);

        if (isset($xmlArray['StartTime']))
            $START_TIME = date('Y-m-d H:i:s',strtotime(mysql_real_escape_string($xmlArray['StartTime'])));

        if (isset($file_name))
            $FILE_NAME = mysql_real_escape_string($file_name);

        $TESTSTATUS = 'PASS';

        if (isset($xmlArray['SoftwareVersion'])) {
            $software_versions = (array) $xmlArray['SoftwareVersion'];
            foreach ($software_versions['LocSoftware'] as $key => $value) {
                $COMPONENT = $TEST_POINT = $SOFT_VERSION = '';

                if (isset($value->Location))
                    $COMPONENT = mysql_real_escape_string($value->Location);

                if (isset($value->Software))
                    $TEST_POINT = mysql_real_escape_string($value->Software);

                if (isset($value->Version))
                    $SOFT_VERSION = mysql_real_escape_string($value->Version);

                $query = "INSERT INTO XML_TO_TESTVERSION (SERIAL_NUMBER, START_TIME, COMPONENT, TEST_POINT, SOFT_VERSION, TESTSTATUS, FILE_NAME) VALUES ('{$SERIAL_NUMBER}', '{$START_TIME}', '{$COMPONENT}', '{$TEST_POINT}', '{$SOFT_VERSION}', '{$TESTSTATUS}', '{$FILE_NAME}');";
                $this->dbconnect->sql = $query;
                $this->dbconnect->inserttb();
            }
        }

        if (isset($xmlArray['StatusTable'])) {
            $component_status = (array) $xmlArray['StatusTable'];
            foreach ($component_status['LocStatus'] as $key => $value) {
                $COMPONENT = $TEST_POINT = $SOFT_VERSION = '';

                if (isset($value->Location))
                    $COMPONENT = mysql_real_escape_string($value->Location);

                if (isset($value->SerialNum))
                    $TEST_POINT = mysql_real_escape_string($value->SerialNum);

                if (isset($value->Status))
                    $SOFT_VERSION = mysql_real_escape_string($value->Status);

                $query = "INSERT INTO XML_TO_TESTVERSION (SERIAL_NUMBER, START_TIME, COMPONENT, TEST_POINT, SOFT_VERSION, TESTSTATUS, FILE_NAME) VALUES ('{$SERIAL_NUMBER}', '{$START_TIME}', '{$COMPONENT}', '{$TEST_POINT}', '{$SOFT_VERSION}', '{$TESTSTATUS}', '{$FILE_NAME}');";
                $this->dbconnect->sql = $query;
                $this->dbconnect->inserttb();
            }
        }

        return true;
    }

    function xml_to_test($xmlArray, $file_name) {
        if (isset($xmlArray['Tests'])) {

            $SERIAL_NUMBER = $START_TIME = $FILE_NAME = '';
            if (isset($xmlArray['SerialNum']))
                $SERIAL_NUMBER = mysql_real_escape_string($xmlArray['SerialNum']);

            if (isset($xmlArray['StartTime']))
                $START_TIME = date('Y-m-d H:i:s',strtotime(mysql_real_escape_string($xmlArray['StartTime'])));

            if (isset($file_name))
                $FILE_NAME = mysql_real_escape_string($file_name);

            $tests = (array) $xmlArray['Tests'];

//            $result = [];
            foreach ($tests['Test'] as $key => $value) {
                $value = $value . "#SD#";
                preg_match_all('/#SD#(.*?)#ED#/s', $value, $display);
                preg_match_all('/#ED#(.*?)#SD#/s', $value, $display_new);

                $TEST_NUM = "Test " . ($key + 1);
                if (count($display[1]) == 9 && count($display_new[1]) == 9) {
                    $insert_data = $display_new[1];
                    $insert_datas = [];
                    foreach($insert_data as $insert_data_key => $insert_data_value) {
                        $insert_datas[$insert_data_key] = mysql_real_escape_string($insert_data_value);
                    }
                    
                    $query = "INSERT INTO XML_TO_TESTS VALUES ('{$SERIAL_NUMBER}', '{$START_TIME}', '{$TEST_NUM}', '{$insert_datas[0]}', '{$insert_datas[1]}', '{$insert_datas[2]}', '{$insert_datas[3]}', '{$insert_datas[4]}', '{$insert_datas[5]}', '{$insert_datas[6]}', '{$insert_datas[7]}', '{$insert_datas[8]}', '{$FILE_NAME}', NOW());";
                    
//                    $result[$TEST_NUM] = [$query];
                    $this->dbconnect->sql = $query;
                    $this->dbconnect->inserttb();
                }
            }
//            return $result;
            return true;
        }
    }
    
    function runDeleteFunction($table, $primary_key, $values) {

        $select_query = "SELECT * FROM ".$table." WHERE ".$primary_key." = '" . $values . "';";
        $this->dbconnect->sql = $select_query;
        $this->dbconnect->countresult();
        if ($this->dbconnect->count > 0) {
            $delete_query = "DELETE FROM ".$table." WHERE ".$primary_key." = '" . $values . "';";
            $this->dbconnect->sql = $delete_query;
            $this->dbconnect->deletetb();
            return 1;
        } else {
            return 0;
        }
    }

}

?>