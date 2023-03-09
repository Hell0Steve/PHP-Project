<?php
define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASS','');
define('DB_NAME', 'database');

class Database{
  	private $connection;
	//Methods

    public function __construct(){
        $this->open_db_connection();
    }

    private function open_db_connection(){
        
        $this->connection=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if ($this->connection->connect_error){
            $this->connection=null;
        }
    }
    
    public function get_connection(){
        return $this->connection;
    }

    public function query($sql){
        $result=$this->connection->query($sql);
        if (!$result){
 	return null;
        }
        else{
            return $result;
        }
    }
}
$database=new Database();