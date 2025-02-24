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
    header("Location: login.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);

?>