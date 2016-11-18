<?php

class dbconnect {

    //   $dbhost = 'localhost';
//   $dbuser = 'rajencba_webpage';
//   $dbpass = 'kkPc)bI[ab86';
    public $host = 'localhost';
    public $user = 'root';
    public $pass = '';
    public $dbcon;
    public $dbname = 'webpage';
    public $sql;
    public $res;
    public $nrow;
    public $ires;
    public $iid;
    public $count;

    function __construct() {
        $this->dbcon = mysql_connect($this->host, $this->user, $this->pass);
        $connected = mysql_select_db($this->dbname, $this->dbcon);
        if (!$this->dbcon) {
            throw new Exception("Unable to use the database " . $dbname . "!");
        }
    }

    function selecttb() {
        $this->res = mysql_query($this->sql);
        $this->nrow = mysql_affected_rows();
    }

    function inserttb() {
        $insert = mysql_query($this->sql);
        if (!$insert) {
            $this->ires = 0;
            return;
        }
        $this->ires = 1;
        $this->iid = mysql_insert_id();
    }

    function updatetb() {
        mysql_query($this->sql);
    }

    function deletetb() {
        mysql_query($this->sql);
    }
    
    function countresult() {
        $result = mysql_query($this->sql);
        $this->count = mysql_num_rows($result);
    }

}

?>