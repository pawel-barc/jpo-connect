<?php 

class MainClass{
    public $pdo;

    public function __construct(){
        $this->pdo = new PDO('mysql:host=localhost;dbname=jpo-connect', 'root', '');
    }

    public function toJSON($data){
        echo json_encode($data);
        exit;
    }

    public function fromJSON($data){
        return json_decode($data);
    }
}