<?php
class User {
    private $dataFile = __DIR__ . '/users.json';

    public function getAll() {
        $users = json_decode(file_get_contents($this->dataFile), true);

        if ($users) {
            return $users;
        } else {
            return [];
        }
    }

    public function getById($id) {  
        $users = $this->getAll();
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public function findByEmail($email) { 
        $users = $this->getAll();
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return $user; 
            }
        }
        return null;
    }

    public function create($data) {
        $users = $this->getAll();

        if (count($users) > 0) {  
            $newid = max(array_column($users, 'id')) + 1;
        } else {
            $newid = 1;
        }
        
        $newUser = [
            'id' => $newid,
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash']
        ];
        
        $users[] = $newUser;
        $this->saveAll($users);
        return $newUser;
    }

    public function update($id, $data) {
        $users = $this->getAll();
        foreach ($users as $key => $user) {
            if ($user['id'] == $id) {  
                if (isset($data['name'])) $users[$key]['name'] = $data['name'];
                if (isset($data['email'])) $users[$key]['email'] = $data['email'];
                if (isset($data['password_hash'])) $users[$key]['password_hash'] = $data['password_hash'];       
                $this->saveAll($users);
                return $users[$key];
            }
        }
        return null;
    }
    
    public function delete($id) {
        $users = $this->getAll();
        
        foreach ($users as $key => $user) {
            if ($user['id'] == $id) {
                unset($users[$key]);
                $this->saveAll(array_values($users));
                return true;
            }
        }
        return false;
    }

    private function saveAll($users) {
        file_put_contents($this->dataFile, json_encode($users, JSON_PRETTY_PRINT));
    }
}
?>