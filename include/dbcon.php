<?php

class dbconnect {

    //   $dbhost = 'localhost';
//   $dbuser = 'rajencba_webpage';
//   $dbpass = 'kkPc)bI[ab86';
//    public $host = 'localhost';
//    public $user = 'root';
//    public $pass = '';
    public $host;
    public $user;
    public $pass;
    public $dbcon;
    public $dbname;
    public $sql;
    public $res;
    public $nrow;
    public $ires;
    public $iid;
    public $count;
    public $l_id;
    public $primary_key;

    function __construct() {
        if($_SERVER['SERVER_NAME']=='localhost'){
            $this->host = 'localhost';
            $this->user = 'root';
            $this->pass = '';
            $this->dbname = 'webpage';
        }else{
            $this->host = 'localhost';
            $this->user = 'rajencba_webpage';
            $this->pass = 'kkPc)bI[ab86';
            $this->dbname = 'rajencba_webpage';
        }
            
        $this->dbcon = mysql_connect($this->host, $this->user, $this->pass);
        $connected = mysql_select_db($this->dbname, $this->dbcon);
        if (!$this->dbcon) {
            throw new Exception("Unable to use the database " . $dbname . "!");
        }        
        if(isset($_SESSION['id'])){
            $this->l_id = $_SESSION['id'];
        }
        
    }
    function getTableColumn($table){
        $this->sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->dbname."' AND TABLE_NAME='".$table."'";
        $this->selecttb();                
    }
    function getPrimaryKey($table){
        $this->sql = "SHOW KEYS FROM ".$table." WHERE Key_name = 'PRIMARY'";
        $this->selecttb();
        if($this->nrow != '0'){
            $result = mysql_fetch_assoc($this->res);
            $this->primary_key =  $result['Column_name'];
        }  else {
            $this->primary_key =  '';
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
        $this->audit_log('insert');
    }

    function updatetb() {
        mysql_query($this->sql);
        $this->audit_log('update');
    }

    function deletetb() {
        mysql_query($this->sql);
        $this->audit_log('delete');
    }
    
    function countresult() {
        $result = mysql_query($this->sql);
        $this->count = mysql_num_rows($result);
    }
    
    function audit_log($type){      
        $create_date = date('Y-m-d h:m:s');
        mysql_query('INSERT INTO AUDIT_LOG(LOGIN_ID,TYPE,QUERY,CREATED_ON) VALUES ("'.$this->l_id.'","'.$type.'","' . $this->sql. '","' . $create_date .'")');
    }

}

?>