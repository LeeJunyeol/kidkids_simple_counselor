<?php
class OpinionModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function getByQuestionOnQuestion($questionId){
        try {
            $sql = "SELECT * FROM opinions WHERE question_id = $questionId AND (answer_id IS NULL)";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }
            $opinions = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $opinions[] = $row;
            }
            return $opinions;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getByQuestionOnAnswer($questionId){
        try {
            $sql = "SELECT * FROM opinions WHERE question_id = $questionId AND (answer_id IS NOT NULL)";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }
            $opinions = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $opinions[] = $row;
            }
            return $opinions;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }



    function getById($opinionId){
        $stmt = $this->conn->prepare("SELECT * FROM opinions WHERE opinion_id = :opinion_id");
        $stmt->bindValue(':opinion_id', $opinionId);
        $stmt->execute();
        $opinion = $stmt->fetchObject();
        return $opinion;
    }

    function getByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT * FROM opinions WHERE question_id = :question_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $opinions = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $opinions[] = $row;
        }
        return $opinions;
    }

    function getByAnswerId($answerId){
        $stmt = $this->conn->prepare("SELECT * FROM opinions WHERE answer_id=:answer_id");
        $stmt->bindValue(':answer_id', $answerId);
        $stmt->execute();
        $opinions = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $opinions[] = $row;
        }
        return $opinions;
    }

    function addOnQuestion($questionId, $content, $userId){
        $stmt = $this->conn->prepare("INSERT INTO opinions (question_id, user_id, content, parent_idx, `level`) VALUES (:question_id, :user_id, :content, 0, 0)");
        $stmt->bindParam(':question_id', $questionId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }
}
?>