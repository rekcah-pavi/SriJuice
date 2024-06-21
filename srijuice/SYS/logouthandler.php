<?php
include 'server.php';

session_start();
unset($_SESSION['logged_in']);
unset($_SESSION['admin']);
setcookie('admin', '', time() - 3600, "/");
header("Location: ../login.php?status=logout");
exit;
?>
