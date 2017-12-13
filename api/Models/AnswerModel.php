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
        $stmt = $this->conn->prepare("SELECT a.*, SUM(v.vote) as vote_cnt FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
        WHERE a.answer_id = :answer_id");
        $stmt->bindValue(':answer_id', $id);
        $stmt->execute();
        $answer = $stmt->fetchObject();
        
        return $answer;
    }

    function getByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT a.answer_id, a.question_id, a.user_id, a.content, a.create_date, a.modify_date, a.label, a.title, SUM(v.vote) as vote_cnt FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
        WHERE a.question_id = :question_id group by a.answer_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // 아직 투표가 없을 경우 null이 아닌 기본값 0을 지정
            if($row['vote_cnt'] == null){
                $row['vote_cnt'] = 0;
            }
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

    function deleteByQuestionId($questionId){
        // var_dump($questionId);
        // exit;
        $sql = "DELETE FROM `answers` WHERE `question_id`=:question_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":question_id", $questionId, PDO::PARAM_INT);
        if($stmt->execute()){
            echo "됨";
            return true;
        } else {
            echo "안됨";
            return false;
        }
    }
}



?>