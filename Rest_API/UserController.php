<?php

class UserController {   
    
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function register($data){
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])){
            return [
                'success' => false,
                'error' => 'Заполните все поля: name, email, password'
            ];
        }
        $existingUser = $this->userModel->findByEmail($data['email']);

        if ($existingUser) {
            return [
                'success' => false,
                'error' => 'Пользователь с таким email уже существует'
            ];
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $newUser = $this->userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $passwordHash
        ]);

        return [
            'success' => true,
            'data' => [
                'id' => $newUser['id'],
                'name' => $newUser['name'],
                'email' => $newUser['email']
            ]
        ];
    }

    public function login($data) {
        if (!isset($data['email']) || !isset($data['password'])) {
            return [
                'success' => false,
                'error' => 'Введите email и пароль'
            ];
        }
        
        $user = $this->userModel->findByEmail($data['email']);
        
        if (!$user) {
            return [
                'success' => false,
                'error' => 'Неверный email или пароль'
            ];
        }
        
        if (!password_verify($data['password'], $user['password_hash'])) {
            return [
                'success' => false,
                'error' => 'Неверный email или пароль'
            ];
        }
        
        return [
            'success' => true,
            'data' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ];
    }

    public function getAllUsers() {
        $users = $this->userModel->getAll();
        
        foreach ($users as &$user) {
            unset($user['password_hash']);
        }
        unset($user);
        
        return [
            'success' => true,
            'data' => $users
        ];
    }

    public function getUser($id) {
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            return [
                'success' => false,
                'error' => 'Пользователь не найден'
            ];
        }
        
        unset($user['password_hash']);
        
        return [
            'success' => true,
            'data' => $user
        ];
    }

    public function updateUser($id, $data) {
        $existingUser = $this->userModel->getById($id);
        if (!$existingUser) {
            return [
                'success' => false,
                'error' => 'Пользователь не найден'
            ];
        }
        
        if (isset($data['email'])) {
            $userWithSameEmail = $this->userModel->findByEmail($data['email']);
            if ($userWithSameEmail && $userWithSameEmail['id'] != $id) {
                return [
                    'success' => false,
                    'error' => 'Email уже используется другим пользователем'
                ];
            }
        }
        
        if (isset($data['password'])) {
            $data['password_hash'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['password']); 
        }
        
        $updatedUser = $this->userModel->update($id, $data);
        
        if (!$updatedUser) {
            return [
                'success' => false,
                'error' => 'Не удалось обновить пользователя'
            ];
        }
        
        unset($updatedUser['password_hash']);
        
        return [
            'success' => true,
            'data' => $updatedUser
        ];
    }

    public function deleteUser($id) {
        $existingUser = $this->userModel->getById($id);
        if (!$existingUser) {
            return [
                'success' => false,
                'error' => 'Пользователь не найден'
            ];
        }
        
        $result = $this->userModel->delete($id);
        
        if (!$result) {
            return [
                'success' => false,
                'error' => 'Не удалось удалить пользователя'
            ];
        }

        return [
            'success' => true,
            'message' => 'Пользователь удалён'
        ];
    }
    
} 
?>