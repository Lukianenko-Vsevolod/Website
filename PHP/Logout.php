<?php
session_start();
$time = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SESSION['user_id'])) {
    file_put_contents('logs/auth.log', $time . " | ip=" . $ip . " | login=" . $_SESSION['user_login'] . " | action=LOGOUT\n", FILE_APPEND);
}
session_destroy();
header('Location: login.php');
exit();
?>