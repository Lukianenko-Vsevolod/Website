<?php
session_start();
$login = $_POST['login'];
$password = $_POST['password'];
$time = date('Y-m-d H:i:s');

if ($login === 'admin' && $password === "12345") {
    $_SESSION['user'] = $login;
    file_put_contents('logs.txt', $time . " - " . $login . " - УСПЕХ\n", FILE_APPEND);
    header('Location: dashboard.php');
} else {
    file_put_contents('logs.txt', $time . " - " . $login . " - Неудача\n", FILE_APPEND);
    header('Location: login.php?error=1');
}
exit();
?>