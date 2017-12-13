<?php
class VoteModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function add($answerId, $userId, $vote){
        $stmt = $this->conn->prepare("INSERT INTO votes (`answer_id`, `user_id`, `vote`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $answerId);
        $stmt->bindParam(2, $userId);
        $stmt->bindParam(3, $vote);
        
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
}