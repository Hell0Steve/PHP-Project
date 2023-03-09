<?php
require_once('includes/init.php');

if($session->signed_in){
    $_SESSION["Message"] = "You are already logged in!";
    header('Location:index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];    
    // Validating log in information:

    $validate = User::validateLogin($username,$password);    
    if ($validate=="User found"){
        $info= "Found";
        $session->login($username);
        header('Location: index.php');
    }
    else{
        $info = $validate;
        echo $validate;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php     
        include_once 'common/_jquery.php';
        include_once 'common/_fontawesome.php'; 
        include_once 'common/_bootstrap.php'; 
    ?>
    <link rel="stylesheet" href="CSS/loginNEW.css">
    <title>Log In</title>
</head>

<body>
    <h1 style="text-align: center;"> Log in: </h1>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Log In">
        <a style="text-decoration: none" href="signup.php" class="home-button">Sign Up</a>


    </form>
</body>

</html>