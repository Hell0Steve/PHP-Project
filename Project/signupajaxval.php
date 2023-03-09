<?php
include_once 'includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"];
    $password= $_POST["password"];
    $email = $_POST["email"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $sex = $_POST["sex"];
    $age = $_POST["age"];

    //Validation:
    $check = "";
    
    if (empty($_POST['username'])){
        $check .= "Fill username field";
    }
    else{
        $tmpUser = new User();
        $feedback = $tmpUser->find_user_by_username($_POST['username']);
        if ($feedback=="User Found"){
            $check.= "Already in use.";
        }
        else{
            if (!(preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']))) {
                $check.= "Username should contain letters from the abc and numbers ONLY.";
            }
            if(strlen($_POST['username']) > 15){
                $check.= "Username can be of maximum of 15 in length.";

            }
        }
    }
    if (empty($_POST['password']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['firstname'])
    || empty($_POST['lastname']) || empty($_POST['sex']) || empty($_POST['age'])) {
        $check .= "Fill all fields";
    }
    elseif(strlen($_POST['password']) > 15 || strlen($_POST['password'] < 6 )){
            $check.= "Password must be between 6 and 15 character\n";  
    }
    // elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //         $check.= "Invalid email, try again";
    // }   
    elseif(!(preg_match('/^[a-zA-Z]+$/', $_POST['firstname']))) {
            $check.= "Use only letters";
    }
    elseif(!(preg_match('/^[a-zA-Z]+$/', $_POST['lastname']))) {
            $check.= "Use only letters"; 
    }
    elseif(!(preg_match('/^[0-9]+$/', $_POST['age']))){
            $check.= "Use only numbers";
    }

    // Succesfuly adding a user to the DB :)

    if (empty($check)){
        $usercheck=User::add_user($username, $password, $email, $firstname, $lastname, $sex, $age);
        if (empty($usercheck)) {
            $check ='Success';
            echo $check;
        }
        else{
            echo $usercheck; 
        }
    }
    else {
        echo $check;
    }
}