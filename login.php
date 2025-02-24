<?php
    require_once("includes/config.php");
    require_once("includes/classes/FormSanitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    // check all post data that was submitted
    // collect all data input from the post method of th efom
    //ensures the submit button was clicked.
    // Check if the form was submitted

    // Create a new Account object with database connection
    $account = new Account($con);

    // Check if the login form was submitted
    if (isset($_POST["submitButton"])) {
        
        // Clean and sanitize the username input to prevent security issues
        // FormSanitizer is a custom class that handles input cleaning
        $username = FormSanitizer::sanitizeFormUsername($_POST["userName"]);
        
        // Clean and sanitize the password input
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        // Attempt to log in with the provided credentials
        // The login() method likely checks against the database
        $success = $account->login($username, $password);
        
        // If login was successful
        if ($success) {
            // Store the username in the session to keep the user logged in
            $_SESSION["userLoggedIn"] = $username;
            // Redirect the user to the homepage
            header("Location: index.php");
            // Stop executing the rest of the code
            exit();
        } 
    }

    /**
     * Preserves form input values after form submission
     * This is useful when the login fails and user needs to try again
     * 
     * @param string $name The name attribute of the form field
     * @return void Directly outputs the previously entered value
     */
    function getInputValue($name) {
        // Check if this form field was submitted in the previous request
        if (isset($_POST[$name])) {
            // Output the previously entered value
            // This prevents users from having to retype everything if login fails
            echo $_POST[$name];
        }
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
                <?php echo $account->getError(Constants::$loginFailed); ?>
                <input type="text" name="userName" placeholder="Username" value="<?php getInputValue("userName"); ?>" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="submitButton" value="SUBMIT" required>
            </form>

            <a href="register.php" class="signInMessage">Need an account? Sign up here!</a>

        </div>
    </div>
</body>
</html>