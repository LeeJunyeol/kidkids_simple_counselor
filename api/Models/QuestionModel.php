<?php
class QuestionModel {
    public $conn;
    public $ascChar = "DESC";

    public function __construct($conn){
        $this->conn = $conn;
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

    function getForPage($offset, $limit, $sortBy, $isASC){
        $ascChar = "ASC";
        if($isASC === "false"){
            $ascChar = "DESC";
        }

        try {
            $sql = "SELECT q.question_id, q.user_id, q.title, q.content, q.view, q.tags
            , q.selected_answer_id, q.create_date, q.modify_date, c.category_name AS category, c.category_id
            FROM 
            (
                SELECT * FROM category_question
            ) AS cq 
            INNER JOIN questions AS q
            ON q.question_id = cq.question_id
            INNER JOIN categories AS c
            ON c.category_id = cq.category_id
            WHERE c.depth = 0 
            ORDER BY $sortBy $ascChar LIMIT $offset, $limit";
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
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getByCategoryForPage($categoryId, $offset, $limit, $sortBy, $isASC){
        $ascChar = "DESC";
        if($isASC === "true"){
            $ascChar = "ASC";
        }
        $sql = "SELECT q.question_id, q.user_id, q.title, q.content, q.view, q.tags
        , q.selected_answer_id, q.create_date, q.modify_date, c.category_name AS category, c.category_id 
        FROM (
            SELECT * FROM category_question
            WHERE category_id=:categoryId
        ) AS cq 
        INNER JOIN questions AS q ON q.question_id = cq.question_id
        INNER JOIN categories AS c ON c.category_id = cq.category_id 
        ORDER BY q.$sortBy $ascChar LIMIT $offset, $limit";
        $stmt = $this->conn->prepare($sql);
        // $stmt = $this->conn->prepare("SELECT q.question_id, q.user_id, q.category_id, q.title, q.content, q.view, q.tags
        // , q.selected_answer_id, q.create_date, q.modify_date, c.category_name as category 
        // FROM questions as q JOIN categories AS c ON q.category_id = c.category_id 
        // WHERE q.category_id=:categoryId ORDER BY q.$sortBy $ascChar LIMIT $offset, $limit");
        $stmt->bindValue(':categoryId', $categoryId);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        return $results;
    }

    function count(){
        $stmt = $this->conn->query("SELECT count(*) FROM questions");
        $rowCount = $stmt->fetch(PDO::FETCH_NUM);

        return $rowCount;
    }

    function countByCategory($categoryId){
        $stmt = $this->conn->prepare("SELECT count(*) 
        FROM (
            SELECT * FROM category_question
            WHERE category_id=:categoryId
        ) AS cq 
        INNER JOIN questions AS q ON q.question_id = cq.question_id
        INNER JOIN categories AS c ON c.category_id = cq.category_id");
        $stmt->bindValue(':categoryId', $categoryId);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
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

    function delete($id){
        $sql = "DELETE FROM `questions` WHERE `question_id` = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $id);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        };
        return true;
    }
}


?>