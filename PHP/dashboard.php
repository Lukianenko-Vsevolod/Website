<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Кабинет</title>
</head>
<body>
    <h1>Добро пожаловать, <?php echo $_SESSION['user_login']; ?>!</h1>
    <a href="logout.php">Выйти</a>
</body>
</html>