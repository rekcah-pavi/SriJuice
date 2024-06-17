<?php
include 'server.php';

session_start();
unset($_SESSION['logged_in']);
unset($_SESSION['admin']);
header("Location: ../login.php?status=logout");
exit;
?>
