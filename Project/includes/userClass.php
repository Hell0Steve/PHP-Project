<?php

require_once('database.php');

class User {
    protected $username;
    protected $password;
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $sex;
    protected $age;

    public static function fetch_users(){  
        global $database;
        $result=$database->query("select * from users");
        $users=null;
        if ($result){
            $i=0;
            if ($result->num_rows>0){ 
                while($row=$result->fetch_assoc()){ 
                    $user=new User();
                    $user->instantation($row);
                    $users[$i]=$user;
                    $i+=1;
                }
            }
        }
        return $users;
    }
    
    public function __get($property){
        if(property_exists($this,$property))
            return $this->$property;
    }
    private function has_attribute($attribute){
        $object_properties=get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }

    private function  instantation($users_array){        
        foreach ($users_array as $attribute=>$value){
            if ($result=$this->has_attribute($attribute)){
                $this->$attribute=$value;
            }
       }
    }
   
    //Adding a user to DB:
    public static function add_user($username, $password, $email, $firstname, $lastname, $sex, $age){
        global $database;
        $error=null;
        $sql="insert into users(username, password, email, firstname, lastname, sex, age) values ('".$username."','".self::hashedWithSalt($password)."','".$email."',
        '".$firstname."','".$lastname."','".$sex."', '".$age."')";
        $result=$database->query($sql);
        if (!$result){
            $error='Cannot add user, Error:'.$database->get_connection()->error;
        }
        return $error;
    }

    //Find account by username.
    public function find_user_by_username($username){
        global $database;
        $alert=null;
        $sql = "select * from users where username='".$username."' limit 1";
        $result=$database->query($sql);
        if(!$result){
            $alert="Cannot find user, Error is: ".$database->get_connection()->error; // Cannot reach db
            return $alert;
        }
        elseif ($result->num_rows>0){ // User found in DB.
            $found=$result->fetch_assoc();
            $this->instantation($found);
            $alert = "User found";
            return $alert;
        }
        else{
            $alert="User not found"; // User not found in DB.
            return $alert;
        }
    }

    // Hashing the password with MD5 and adding salt:

    public static function hashedWithSalt ($password){
        $salt = "abcd7";
        return md5(md5($salt).$password);
    }
    
    public static function validateLogin($username, $password){ // Validating log in.
        $user = new User();
        $alert = $user->find_user_by_username($username); // Returns if the user found / not found.
        if($alert=="User found"){
            global $database;
            $hashed = self::hashedWithSalt($password); // Password hashing.
            
            // Validating hash in DB:


            $error=null;
            $result=$database->query("select * from users where username='".$username."' and password='".$hashed."'" );
            
            if(!$result){
                $query_res = "Error..";
                return $query_res;
            }
            elseif ($result->num_rows>0){
                    $found=$result->fetch_assoc();
                    $user->instantation($found);
                    $query_res ="User found";
                    return $query_res;
            }
            else{
                $query_res= "Wrong Password..";
                return $query_res;
            }
        }
        else{
            $query_res = "User doesn't exist";
            return $query_res;
        }
    }
}
?>