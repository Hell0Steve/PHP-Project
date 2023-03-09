<?php
require_once('includes/init.php');
require_once("pollClass.php");

if(isset($_GET) && !empty($_GET)){ //  If there's a poll in the system with the poll_id of the user , LOAD IT. 
    $poll_id = $_GET['poll_id'];
    $sql = "SELECT g.*, p.workout, p.activity, d.meals, d.diet 
    FROM poll_general_info as g 
    LEFT JOIN poll_physical_shape as p ON p.poll_id = g.poll_id 
    LEFT JOIN poll_diet as d ON d.poll_id = g.poll_id 
    WHERE g.poll_id = '$poll_id'";
    
    global $database;
    $result=$database->query($sql);
    $row = $result->fetch_assoc();
    echo json_encode($row);
}