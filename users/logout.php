<?php
// Initialize the session
include "../config/session.php";
include "../config/url.php";
// Unset all of the session variables
unset($_SESSION["sg"]);
// Destroy the session.
//session_destroy();
// Redirect to login page
header("location:" . URL . "index.php");
