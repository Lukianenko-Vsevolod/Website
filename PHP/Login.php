<?php
session_start();
if (isset($_SESSION['user'])){
    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang = "ru">
<head>
    <meta charset="UTF-8">
    <title>Авторизация</title>
</head>
<body>
    <?php
    if (isset($_GET['error'])){
        echo '<p style="color: red;">Пароль или логин не верны</p>';
    }
    ?>
    <h1><strong>Авторизация</strong></h1>
    <form method="POST" action = "auth.php">
        <input type = "text" name = "login" placeholder = "Логин" required>
        <input type = "password" name = "password" placeholder = "Пароль" required>
        <button type = "submit">Войти</button>
    </form>
</body>
</html>