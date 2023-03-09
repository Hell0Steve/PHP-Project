<?php
    require_once('includes/init.php');
    //Redirects user to Home Page.
    if($session->signed_in){
        $_SESSION["Message"] = "Already logged in.";
        header('Location:index.php');
        exit;
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

    <link rel="stylesheet" href="CSS/signUP.css">
    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>
    <form>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required>
        <br>
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="sex">Sex:</label required>
        <select id="sex" name="sex">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br><br>
        <input class="button" id="submit" type="button" onclick='signup(event)' value="Sign Up" name="submit"><br><br>
        <a class="button" style="text-decoration: none" href="index.php">Home</a>
    </form>

    <script>
    //Ajax:

    function signup(event) {
        event.preventDefault();
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4 & request.status == 200) {
                if (request.responseText.trim() == 'Success') {
                    alert("Sign up complete, You can now Log in.");
                    window.location.href = "login.php";
                } else {
                    console.log(request);
                    alert(request.responseText);
                }
            } else if (request.status >= 500) {
                alert('Sorry! an internal server error occured');
            }
        }
        request.open("POST", 'signupajaxval.php', true);
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const firstname = document.getElementById("firstname").value;
        const lastname = document.getElementById("lastname").value;
        const email = document.getElementById("email").value;
        const age = document.getElementById("age").value;
        const sex = document.getElementById("sex").value;

        if (!username || !password || !firstname || !lastname || !email || !age || !sex) {
            alert('All fields are required!');
            return;
        }

        request.send(
            `username=${username}&password=${password}&firstname=${firstname}&lastname=${lastname}&email=${email}&age=${age}&sex=${sex}`
        );
    }
    </script>
</body>

</html>