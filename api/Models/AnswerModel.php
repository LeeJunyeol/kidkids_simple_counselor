<?php
class AnswerModel {
    public $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
    }

    function add($answer){
        $stmt = $this->conn->prepare("INSERT INTO answers (question_id, user_id, title, content) VALUES (:question_id, :user_id, :title, :content)");
        $stmt->bindParam(':question_id', $answer['question_id']);
        $stmt->bindParam(':user_id', $answer['user_id']);
        $stmt->bindParam(':title', $answer['title']);
        $stmt->bindParam(':content', $answer['content']);
        
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    function getById($id){
        $stmt = $this->conn->prepare("SELECT * FROM answers WHERE answer_id=:answer_id");
        $stmt->bindValue(':answer_id', $id);
        $stmt->execute();
        $answer = $stmt->fetchObject();
        
        return $answer;
    }

    function getByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT * FROM answers WHERE question_id=:question_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        return $results;
    }
    
    function getJoinOnAnswerByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT c.commnet_id, c.user_id
        , c.answer_id, c.content
        , c.parent_idx, c.level, c.seq
        , c.create_date, c.modify_date 
        FROM answers as a JOIN opinions as c ON a.answer_id = c.answer_id WHERE a.question_id=:question_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        return $results;
    }
}



?>