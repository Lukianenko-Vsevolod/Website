<?php
require_once 'UserController.php';
require_once 'User.php';
require_once 'routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');
$parts = explode('/', trim($requestUri, '/'));

if (count($parts) < 2 || $parts[0] !== 'api' || $parts[1] !== 'v1') {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Неверный API путь']);
    exit();
}

$resource = $parts[2] ?? null;
$id = $parts[3] ?? null;

$inputData = [];
if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
    $inputData = json_decode(file_get_contents('php://input'), true) ?? [];
}

$route = getRoute($method, $resource, $id);

if (!$route) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Маршрут не найден']);
    exit();
}

$controller = new UserController();
$action = $route['action'];

header('Content-Type: application/json');

try {
    if (isset($route['id'])) {
        $response = $controller->$action($route['id'], $inputData);
    } elseif ($action === 'register' || $action === 'login') {
        $response = $controller->$action($inputData);
    } else {
        $response = $controller->$action();
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => 'Ошибка сервера'];
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>