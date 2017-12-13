<?php
class UserModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function register($id, $password, $name, $email, $hash){
        $stmt = $this->conn->prepare("INSERT INTO users (`user_id`, `name`, `password`, `user_type`, `eamil`, `hash`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, "일반");
        $stmt->bindParam(5, $email);
        $stmt->bindParam(6, $hash);
        
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
}