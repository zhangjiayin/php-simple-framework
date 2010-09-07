<?php
class Mysql {

    private $_conn      = null;
    private $host       = null;
    private $user       = null;
    private $password   = null;
    private $port       = null;
    private $charset    = null;

    public function __construct($host, $user, $password, $db="", $port=3306, $charset="gbk") {

        $this->host = $host;
        $this->user = $user;
        $this->db   = $db;
        $this->password = $password;
        $this->port = $port;
        $this->charset = $charset;

    }

    private function _connect() {

        $_conn = mysql_connect($this->host . ':' . $this->port, $this->user, $this->password);
    
        if(empty($_conn)) {
            $this->raiseError('cannot connect to ' . $this->host . ':' . $this->port . ' use username ' . $this->user);
        }

        if(!empty($this->db)) {
            mysql_select_db($this->db, $_conn);
        } 

        if(!empty($this->charset))
            mysql_set_charset($this->charset, $_conn);

        return $_conn;
    }

    protected function getConnection() {
        if($this->_conn  == null) {
            $this->_conn = $this->_connect();
        }    

        return $this->_conn;
    }

    public function fetchRow($sql) {
    
        if(!preg_match('#limit\s+\d+$#i', $sql)) {
            $sql = $sql . ' LIMIT 1';
        }
    
        $result = $this->query($sql);

        $return = $this->fetchAll($result);

        return  count($return) > 0 ? $return[0] : array();
    }

    public function fetchAll($sql) {

        $result = $this->query($sql);

        $return = array();

        if(empty($return)) {
            return $return;
        }   
    
        while ($row = mysql_fetch_assoc($result)) {
            $return[] = $row;
        }

        return $return;
    }

    public function update($sql){

        $result = $this->query($sql);

        if(empty($result)) {
            return 0;
        }

        return mysql_affected_rows($this->getConnection());
    }

    public function insert($sql, $returnId=true) {
        $result = $this->query($sql);
    
        if(empty($result)) {
            return 0;
        }

        if($returnId) {
            return mysql_insert_id($this->getConnection());
        } else {
            return mysql_affected_rows($this->getConnection());
        }
    }

    public function delete($sql) {
        $result = $this->query($sql);

        if(!empty($result)) {
            return mysql_affected_rows($this->getConnection());
        }

        return 0;
    }

    /**
     * query  
     * 
     * @param mixed $sql 
     * @access private
     * @return void
     */
    private function query($sql) {
        $_conn = $this->getConnection();
        $result = mysql_query($sql, $_conn);
        return $result;
    }

    /**
     * error  error info
     * 
     * @access public
     * @return void
     */
    public function error() {
        return mysql_error($this->getConnection());
    }

    public function raiseError($message, $error_level=E_USER_ERROR) {
        return trigger_error($message, E_USER_ERROR);
    }
}
