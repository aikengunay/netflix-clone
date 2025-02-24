<?php
require_once("includes/config.php");

/**
 * Check if user is logged in by looking for session variable
 * This is a security measure to protect private pages
 */
if (!isset($_SESSION["userLoggedIn"])) {
    // If user is not logged in:
    // - Redirect them to the login page
    // - This prevents unauthorized access to this page
    header("Location: login.php");
}
?>