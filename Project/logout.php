<?php
    require_once('includes/init.php');

    // If the user tries to log out while not being logged in.. :)
    if($session->signed_in==false){
        $_SESSION["Message"] = "You are not logged in";
    }
    // Succesfully logging out.
    else{
        $_SESSION["Message"] = "You have have been successfully logged out";
    }
    $session->logout();
    header('Location: login.php');
    exit;
?>