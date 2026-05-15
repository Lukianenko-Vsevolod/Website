<?php
session_start();
$username = $_SESSION['user'];

$time = date('Y-m-d H:i:s');
file_put_contents('logs.txt', $time . " - " . $username . " - ВЫХОД\n", FILE_APPEND);

session_destroy();
header('Location: login.php');
exit();
?>