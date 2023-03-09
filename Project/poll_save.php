<?php
require_once('includes/init.php');
require_once("pollClass.php");

if(isset($_POST) && !empty($_POST)){
    $step = $_POST['step'];
    $poll_id = $_POST['poll_id'];
    
    switch ($step) {
        case 1:
            $id = $_POST["id"];
            $age = $_POST["age"];
            $weight = $_POST["weight"];

            // Validate required fields for step 1:
            if (empty($id) || empty($age) || empty($weight)) {
                echo "All of the questions must be answered..";
                exit;
            }
            else if (filter_var($id, FILTER_VALIDATE_INT) == false || strlen((string)$id) != 9) {
                echo "The id must be 9 digits long";
                exit;
            }
            else if (filter_var($age, FILTER_VALIDATE_INT) == false || $age > 120) {
                echo "The age must be a number less than 120";
                exit;
            }
            else if (filter_var($weight, FILTER_VALIDATE_INT) == false) {
                echo "The weight must be a number";
                exit;
            }
            else {
                // validation passed, saving the first page of the poll in DB.
                $save = Poll::save_poll_step_1($poll_id, $id, $age, $weight);
                print_r($save);
                exit;
            }

            break;

        case 2:
            $workout = $_POST["workout"];
            $activity = $_POST["activity"];

            // Validate required fields for step 2:
            if (empty($workout) || empty($activity)) {
                echo "All of the questions must be answered..";
                exit;
            }
            else if (filter_var($workout, FILTER_VALIDATE_INT) == false || $workout > 7) {
                echo "You cannot be training more than 7 times a week";
                exit;
            }
            else {
                // validation passed, saving the second page of the poll in DB.
                $save = Poll::save_poll_step_2($poll_id, $workout, $activity);
                print_r($save);
                exit;
            }
            break;
        
        case 3:
            $diet = $_POST["diet"];
            $meals = $_POST["meals"];

            // Validate required fields for step 3:
            if (empty($diet) || empty($meals)) {
                echo "All of the questions must be answered..";
                exit;
            }
            else {
                // validation passed, saving the third page of the poll in DB.
                $save = Poll::save_poll_step_3($poll_id, $meals, $diet);
                print_r($save);
                exit;
            }
            break;

        default:
            break;
    }
}