<?php

class User {

    //I'm assuming here that you already have a User class, once again I will
    //only give here code that applies to the ACL   

    protected $id;
    protected $username;
    private $dbconnect;
    public $table;
    public $l_id;
    public $role;

    /**

     * A list of permissions for this user. Will be filled

     * by the first call to the ::can() method.

     */
    protected $permissions;
    
    function __construct() {
        
        $this->dbconnect = new dbconnect;              
        
        if(isset($_SESSION['id'])){
            $this->l_id = $_SESSION['id'];
            $this->role = $_SESSION['role'];
        }
        
    }
    function getlayout($table){
        $this->dbconnect->sql = 'SELECT LAYOUT FROM A_REPORT WHERE TYPE = "'.$table.'"';
        $this->dbconnect->selecttb();       
        $value = mysql_fetch_assoc($this->dbconnect->res);
        
        if(!empty($value)){
            $layout = $value['LAYOUT'];
        }else{
            $layout = '';
        }
            
        return $layout;
    }
    function permissions(){
        if($this->l_id != ''){            
            $this->dbconnect->sql = 'SELECT * FROM TABLE_PERMISSIONS WHERE LOGIN_ID = '.$this->l_id;
            $this->dbconnect->selecttb();
            $table_access_results = array();
            while($value = mysql_fetch_array($this->dbconnect->res)){
                 $table_access_results[] = array('TABLE_NAME'=>$value['TABLE_NAME'], 'create' => $value['CAN_CREATE'],'view' => $value['CAN_VIEW'],'edit' => $value['CAN_EDIT'],'delete' => $value['CAN_DELETE']);
            }
            $this->permissions=$table_access_results;
        }  else {
            $this->permissions = array();
        }
    }
    public function can($permission, $type) {
        $this->permissions();        
        return $this->whatever($this->permissions, $permission, $type);              
    }

    public function whatever($array, $key, $val) {
        
        foreach ($array as $item)
            if (isset($item['TABLE_NAME']) && $item['TABLE_NAME'] == $key && isset($item[$val]) && $item[$val] == 1)
                return true;
        return false;
    }
    
    function get_access_table(){
        if($this->l_id != '' && $this->role != 'admin'){
            $this->dbconnect->sql = 'SELECT TABLE_NAME FROM TABLE_PERMISSIONS WHERE LOGIN_ID = '.$this->l_id;
            $this->dbconnect->selecttb();
            $table_access_results = array();
            while($value = mysql_fetch_array($this->dbconnect->res)){
                $table_access_results[] = "'".$value['TABLE_NAME']."'";
            }
            if(!empty($table_access_results)){
                $this->dbconnect->sql = 'SELECT * FROM information_schema.tables a, A_REPORT b WHERE a.TABLE_TYPE IN("BASE TABLE","VIEW")
                    AND a.TABLE_SCHEMA LIKE "webpage"
                    AND b.LAYOUT LIKE "TABLE%"
                    AND b.TYPE = a.TABLE_NAME
                    AND b.TYPE NOT IN (' . implode($table_access_results,"," ).');';
                $this->dbconnect->selecttb();            
                $table = array();
                while ($row = mysql_fetch_array($this->dbconnect->res)) { 
                    $table[] = $row['TABLE_NAME'];
                }           
                $this->table = "AND TYPE NOT IN ( '" . implode($table, "', '") . "' )";
            }  else {
                $this->table = '';
            }
        }else{
            $this->table = '';
        }
    }

}

//instantiate a user


//var_dump($that_guy->can('BOMX', 'edit'));
//var_dump($that_guy->can('HEADER', 'view'));
?>