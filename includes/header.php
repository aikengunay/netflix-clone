<?php
require_once("includes/config.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/Entity.php");

/**
 * Check if user is logged in by looking for session variable
 * This is a security measure to protect private pages
 */
if (!isset($_SESSION["userLoggedIn"])) {
    // If user is not logged in:
    // - Redirect them to the login page
    // - This prevents unauthorized access to this page
    header("Location: register.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
    <title>Welcome to Reeceflix</title>
</head>
    <body>
        <div class="wrapper"></div>
    </body>
</html>