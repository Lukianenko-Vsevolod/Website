<?php

function getRoute($method, $resource, $id) {
    if ($resource === 'register' && $method === 'POST') {
        return ['controller' => 'UserController', 'action' => 'register'];
    }
    
    if ($resource === 'login' && $method === 'POST') {
        return ['controller' => 'UserController', 'action' => 'login'];
    }
    
    if ($resource === 'users' && $method === 'GET' && !$id) {
        return ['controller' => 'UserController', 'action' => 'getAllUsers'];
    }
    
    if ($resource === 'users' && $method === 'GET' && $id) {
        return ['controller' => 'UserController', 'action' => 'getUser', 'id' => $id];
    }
    
    if ($resource === 'users' && ($method === 'PUT' || $method === 'PATCH') && $id) {
        return ['controller' => 'UserController', 'action' => 'updateUser', 'id' => $id];
    }
    
    if ($resource === 'users' && $method === 'DELETE' && $id) {
        return ['controller' => 'UserController', 'action' => 'deleteUser', 'id' => $id];
    }
    
    return null;
}
?>