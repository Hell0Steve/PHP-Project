<?php
    require_once('includes/init.php');
    //User must be logged in the see anything.
    if(!$session->signed_in){
        $_SESSION["Message"] = "You must be logged in to use the website";
        header('Location:login.php');
        exit;
    }

    include_once '_jquery.php';
    include_once '_fontawesome.php'; // Icons
    include_once '_bootstrap.php';
?>

<link rel="stylesheet" href="CSS/style.css">

<header>
    <navbar style="text-align: center;">
        <div>
            <button><a style="text-decoration: none" href="poll.php">Survey</a></button>
            <button><a style="text-decoration: none" href="statistics.php">Statistics</a></button>
            <button><a style="text-decoration: none" href="bmi-calc.php">BMI Calculator</a></button>

            <?php
            if ($session->signed_in) { // If signed in show buttons:
                echo '<button><a style="text-decoration: none" href="logout.php">Log out</a></button>';
            }
            else { // If signed out show buttons:
                echo '
                    <button><a style="text-decoration: none" href="login.php">Log in</a></button>
                    <button><a style="text-decoration: none" href="signup.php">Sign Up</a></button>
                ';
            }
            ?>

        </div>
    </navbar>
</header>