<?php
    require_once('includes/init.php');
class Poll{
        protected $id;
        protected $age;
        protected $weight;
        protected $workout;
        protected $meals;
        protected $activity;
        protected $diet;


        
    //General Getter method
    public function __get($property){
        if (property_exists($this,$property))
                return $this->$property;
        
    }
    public static function fetch_polls(){ // Pull all products
        
        global $database;
        $result=$database->query("select * from polls");
        $products=null;
        if ($result){
            $i=0;
            if ($result->num_rows>0)
                while($row=$result->fetch_assoc()){ 
                    $poll=new Poll();
                    $poll->instantation($row);
                    $polls[$i]=$product;
                    $i+=1;
                }   
        }
        return $polls;
    }
        
    private function has_attribute($attribute){
        
        $object_properties=get_object_vars($this);
        return array_key_exists($attribute,$object_properties);
    }
    
    private function instantation($user_array){
        foreach ($user_array as $attribute=>$value){
            if ($result=$this->has_attribute($attribute))
                $this->$attribute=$value;
       }
    }
    
    public function find_poll_by_id ($id){ // Fetching a product by its name.
        global $database;
        $error=null;
        $sql = "select * from polls where id='".$id."'";
        $result=$database->query($sql);
        if (!$result)
            $error='Can not find the poll. Error is:'.$database->get_connection()->error;
        elseif ($result->num_rows>0){
            $found_poll=$result->fetch_assoc();
			$this->instantation($found_poll);
        }
         else
             $error="Can not find poll by this id";
		 
        return $error;
        
    }
//    Function for saving the first page of the poll in DB.
    public static function save_poll_step_1($poll_id, $id, $age ,$weight){
        global $database;
        $error=null;
        $sql = "SELECT * FROM poll_general_info WHERE poll_id = '$poll_id'";
        $result=$database->query($sql);
        if ($result->num_rows>0) {
            // update
            $sql = "UPDATE poll_general_info SET id=$id, age=$age, weight=$weight WHERE poll_id = '$poll_id'";
        }
        else {
            // insert
            $sql = "INSERT INTO poll_general_info(poll_id, id, age, weight) VALUES ('$poll_id','$id','$age','$weight')";
        }

        $result=$database->query($sql);
        
        if (!$result) {
            $error='Can not save poll.  Error is:'.$database->get_connection()->error;
            return $error;
        }
    }
// Function for saving second part of poll in DB.
    public static function save_poll_step_2($poll_id, $workout, $activity){
        global $database;
        $error=null;
        $sql = "SELECT * FROM poll_physical_shape WHERE poll_id = '$poll_id'";
        $result=$database->query($sql);
        if ($result->num_rows>0) {
            // update
            $sql = "UPDATE poll_physical_shape SET workout='$workout', activity='$activity' WHERE poll_id = '$poll_id'";
        }
        else {
            // insert
            $sql = "INSERT INTO poll_physical_shape(poll_id, workout, activity) VALUES ('$poll_id','$workout','$activity')";
        }

        $result=$database->query($sql);
        
        if (!$result) {
            $error='Can not save poll.  Error is:'.$database->get_connection()->error;
            return $error;
        }
    }
// Function for saving third part of poll in DB.
public static function save_poll_step_3($poll_id, $meals, $diet){
        global $database;
        $error=null;
        $sql = "SELECT * FROM poll_diet WHERE poll_id = '$poll_id'";
        $result=$database->query($sql);
        if ($result->num_rows>0) {
            // update
            $sql = "UPDATE poll_diet SET meals=$meals, diet='$diet' WHERE poll_id = '$poll_id'";
        }
        else {
            // insert
            $sql = "INSERT INTO poll_diet(poll_id, meals, diet) VALUES ('$poll_id',$meals,'$diet')";
        }

        $result=$database->query($sql);
        
        if (!$result) {
            $error='Can not save poll.  Error is:'.$database->get_connection()->error;
            return $error;
        }
    }
}  

?>