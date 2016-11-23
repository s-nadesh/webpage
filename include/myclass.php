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

        $query = "SELECT * as total  FROM TESTHEADER D WHERE 
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
        $query = "SELECT * as total  FROM TESTHEADER D WHERE 
            STARTTIME = (SELECT MIN(STARTTIME) FROM TESTHEADER WHERE SN = D.SN AND STATIONID LIKE '" . $station_id . "%' AND PRODUCT LIKE '" . $product . "' AND OVERALLSTATUS LIKE 'PASS%')
            AND STARTTIME  BETWEEN '" . $this->from . " 12:00:01' AND '" . $this->to . " 23:59:00'";

        $this->dbconnect->sql = $query;
        $this->dbconnect->selecttb();
        $this->res = $this->dbconnect->res;
    }

    function getPercentage($tested, $passed) {
        $result = @($passed / $tested) * 100;
        if ($tested === 0) {
            $result = null;
        }
        return $result;
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

}

?>