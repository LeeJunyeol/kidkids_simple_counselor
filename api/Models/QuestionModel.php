<?php
class QuestionModel {
    public $conn;
    public $ascChar = "DESC";

    public function __construct($conn){
        $this->conn = $conn;
    }

    function deleteById($id){
        try {
            $sql = "DELETE FROM questions WHERE question_id = $id";
            $stmt = $this->conn->prepare($sql);

            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }

            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function updateSelectedAnswerId($answerId, $questionId){
        try {
            $sql = "UPDATE questions SET selected_answer_id = :sai WHERE question_id = :question_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':sai', $answerId);
            $stmt->bindParam(':question_id', $questionId);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function add($question){
        $stmt = $this->conn->prepare("INSERT INTO questions (user_id, title, content, tags) 
        VALUES (:user_id, :title, :content, :tags)");
        $stmt->bindParam(':user_id', $question['user_id']);
        $stmt->bindParam(':title', $question['title']);
        $stmt->bindParam(':content', $question['content']);
        $stmt->bindParam(':tags', $question['tags']);

        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return $this->conn->lastInsertId();
    }

    function searchByKeywords($origin, $kewords){
        $sql = "SELECT * FROM questions WHERE title LIKE '%$origin%' OR content LIKE '%$origin%'";
        foreach ($kewords as $key => $value) {
            $sql = $sql . " UNION SELECT * FROM questions WHERE title LIKE '%$value%' OR content LIKE '%$value%'";
        }
        $stmt = $this->conn->prepare($sql);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        $questions = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $questions[] = $row;
        }
        return $questions;
    }

    function getMyQuestionRecent5($userId){
        try {
            $sql = "SELECT * FROM questions WHERE user_id = '$userId' ORDER BY create_date DESC LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }
            $questions = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $questions[] = $row;
            }
            return $questions;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getById($id){
        $stmt = $this->conn->prepare("SELECT question_id, user_id, title, content, view, tags
            , selected_answer_id, create_date, modify_date FROM questions
            WHERE question_id=:question_id");
        $stmt->bindParam(':question_id', $id);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return $stmt->fetchObject();
    }

    function updateById($id, $question){
        $sql = "UPDATE `questions` SET `user_id` = :user_id, 
        `title` = :title, `tags` = :tags, `view` = :view, `content` = :content WHERE `question_id` = :question_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $question->userId);
        $stmt->bindParam(':title', $question->title);
        $stmt->bindParam(':tags', $question->tags);
        $stmt->bindParam(':view', $question->view);
        $stmt->bindParam(':content', $question->content);
        $stmt->bindParam(':question_id', $question->questionId);
        
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return true;
    }

    function count(){
        $stmt = $this->conn->query("SELECT count(*) FROM questions");
        $rowCount = $stmt->fetch(PDO::FETCH_NUM);

        return $rowCount;
    }

    function updateViewById($id, $view){
        $sql = "UPDATE `questions` SET `view` = ? WHERE `question_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, ++$view);
        $stmt->bindParam(2, $id);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return true;
    }

    function updateMe($id, $myQuestion){
        // print_r($myQuestion);
        // die;
        $sql = "UPDATE questions SET title=?, content=?, tags=? WHERE question_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $myQuestion->title);
        $stmt->bindParam(2, $myQuestion->content);
        $stmt->bindParam(3, $myQuestion->tags);
        $stmt->bindParam(4, $id);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return true;
    }
}


?>