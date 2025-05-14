<?php
// Start the session
session_start();

// Destroy all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the index page (or login page)
header("Location: index.php");
exit();
?>