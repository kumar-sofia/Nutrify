<?php
// Start the session
session_start();

// Destroy all session data to log the user out
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>
