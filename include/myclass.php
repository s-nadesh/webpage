<?php

//include_once("dbcon.php");
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

}

?>