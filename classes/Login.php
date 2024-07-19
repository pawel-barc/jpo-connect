<?php

require_once(__DIR__ . '/../classes/MainClass.php');

class Login extends MainClass{
    public function __construct(){
        parent::__construct();
    }

    public function standardLogin($data){
        $sql = "SELECT id, email, password, role_id FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data->email]);

        $dbUser = $stmt->fetch();

        if(!$dbUser){
            return $this->toJSON([
                'error' => 'Email or password is incorrect!'
            ]);
        }

        if(password_verify($data->password, $dbUser['password'])){
            return $this->toJSON([
                'id' => $dbUser['id'],
                'role' => $dbUser['role_id']
            ]);
        }

        return $this->toJSON([
            'error' => 'Email or password is incorrect!'
        ]);

    }
}
