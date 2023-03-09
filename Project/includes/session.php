<?php
  
require_once('includes/database.php');

class Session{
    private $signed_in;
    private $username;
    
    // Constructur:

    public function __construct(){
        session_start();
        $this->check_login();
    }
    // Checks for a logged in user:

     private function check_login(){
        if (isset($_SESSION['username'])){
            $this->username=$_SESSION['username'];
            $this->signed_in=true;
        }
        else{
            $this->signed_in=false;
        }
    }
    
    // Logs in while saving the username details.
    public function login($user){
        if($user){
            $this->username=$user;
            $_SESSION['username']=$user;
            $this->signed_in=true;
        }
    }
    
    // Logging out. 
    public function logout(){
        echo 'logout';
        unset($_SESSION['username']);
        unset($this->username);
        $this->signed_in=false;
        
    }

    // Getter
    public function __get($property){
        if (property_exists($this,$property))
            return $this->$property;
    }
     
}

// Creating a session.
$session=new Session();
    
?>