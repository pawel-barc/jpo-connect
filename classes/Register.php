<?php

require_once(__DIR__ . '/../classes/MainClass.php');

class Register extends MainClass{
    public function __construct(){
        parent::__construct();
    }

    public function registerUsingGoogle($data){
        $data = $this->fromJSON($data);

        $sql = "SELECT id, role_id FROM users WHERE google_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->id]);

        $user = $stmt->fetch();
        if($user){
            return $this->toJSON([
                'id' => $user['id'],
                'role' => $user['role_id']
            ]);
        }

        $sql = "INSERT INTO users (first_name, surname, email, google_id, role_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->given_name, $data->family_name, $data->email, $data->id, 1]);

        return $this->toJSON([
            'id' => $this->pdo->lastInsertId(),
            'role' => 1
        ]);
    }

    public function registerUsingFacebook($data){        
        $sql = "SELECT id, role_id FROM users WHERE facebook_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->id]);

        $user = $stmt->fetch();
        if($user){
            return $this->toJSON([
                'id' => $user['id'],
                'role' => $user['role_id']
            ]);
        }

        $sql = "INSERT INTO users (first_name, surname, email, facebook_id, role_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->first_name, $data->surname, $data->email, $data->id, 1]);

        return $this->toJSON([
            'id' => $this->pdo->lastInsertId(),
            'role' => 1
        ]);
    }

    public function standardRegister($data){
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->email]);

        $user = $stmt->fetch();
        if($user){
            return $this->toJSON([
                'error' => 'Exists user with this email!',
            ]);
        }

        $sql = "INSERT INTO users (first_name, surname, email, password, role_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->first_name, $data->surname, $data->email, password_hash($data->password, PASSWORD_BCRYPT), 1]);

        return $this->toJSON([
            'id' => $this->pdo->lastInsertId(),
            'role' => 1
        ]);

    }
}