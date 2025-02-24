<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // check all post data that was submitted
    // collect all data input from the post method of th efom
    //ensures the submit button was clicked.
    // Check if the form was submitted
    if (isset($_POST["submitButton"])) {
        echo "Form was submitted";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style/style.css"> 
    <title>Welcome to Reeceflix</title>
</head>
<body>
    <div class="signInContainer">
        <div class="column">
            <div class="header">
                <img src="assets/images/logo.png" alt="Reeceflix logo" title="logo">
                <h3>Sign In</h3>
                <span>to continue to Reeexeflix</span>
            </div>
            <form method="POST" autocomplete="off">
                <input type="text" name="userName" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submitButton" value="SUBMIT" required>
            </form>

            <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>

        </div>
    </div>
</body>
</html>