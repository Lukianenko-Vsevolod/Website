<?php
session_start();

$users = [
    'admin' => [
        'id' => 1,
        'password_hash' => => password_hash('12345', PASSWORD_DEFAULT)
    ]
];

$login = trim($_POST['login']);
$password = $_POST['password'];
$time = date('Y-m-d H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

if (!isset($users[$login]) || !password_verify($password, $users[$login]['password_hash'])) {
    file_put_contents('logs/auth.log', $time . " | ip=" . $ip . " | login=" . $login . " | action=FAIL_LOGIN\n", FILE_APPEND);
    header('Location: login.php?error=1');
    exit();
}

$_SESSION['user_id'] = $users[$login]['id'];
$_SESSION['user_login'] = $login;
file_put_contents('logs/auth.log', $time . " | ip=" . $ip . " | login=" . $login . " | action=SUCCESS_LOGIN\n", FILE_APPEND);
header('Location: dashboard.php');
exit();
?>