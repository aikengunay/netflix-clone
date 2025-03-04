<?php
    require_once("includes/config.php");
    require_once("includes/classes/FormSanitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // create new object
    $account = new Account($con);

    // Check if the form was submitted by looking for the "submitButton" in the POST data
    if (isset($_POST["submitButton"])) {
        // Sanitize all form inputs to prevent malicious data
        // FormSanitizer is a custom class that cleans and validates input data
        
        // Clean up the first and last name fields - remove special characters
        $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
        $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
        
        // Clean up username - ensure it meets username format requirements
        $username = FormSanitizer::sanitizeFormUsername($_POST["userName"]);
        
        // Clean up email addresses - ensure they are in valid email format
        $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);
        
        // Clean up passwords - remove unwanted characters while preserving security
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

        // Verify authenthication information
        $account->register($firstName, $lastName, $username, $email, $email2, $password, $password2);
        
        // Debug lines (commented out) to check sanitized values
        // echo $firstName;
        // echo $lastName;
        // echo $username;
        // echo $email;
        // echo $email2;
        // echo $password;
        // echo $password2;
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
                <h3>Sign Up</h3>
                <span>to continue to Reeexeflix</span>
            </div>
            <form method="POST" autocomplete="off">
                <!-- This line displays an error message if the first name validation fails
                     getError() checks if there's an error message stored for the firstNameCharacters rule
                     Constants::$firstNameCharacters is the specific error message identifier -->
                <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                <input type="text" name="firstName" placeholder="First name" required>
                <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                <input type="text" name="lastName" placeholder="Last name" required>
                <?php echo $account->getError(Constants::$usernameCharacters); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
                <input type="text" name="userName" placeholder="Username" required>
                <?php echo $account->getError(Constants::$emailsDontMatch); ?>
                <?php echo $account->getError(Constants::$emailInvalid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="email" name="email2" placeholder="Confirm email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password2" placeholder="Confirm password" required>
                <input type="submit" name="submitButton" value="SUBMIT" required>
            </form>

            <a href="login.php" class="signInMessage">Already have an account? sign in here!</a>

        </div>
    </div>
</body>
</html>