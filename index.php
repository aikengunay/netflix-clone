<?php
require_once("includes/header.php");

$userLoggedIn = $_SESSION["userLoggedIn"];
$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);

$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showAllCategories();
?>