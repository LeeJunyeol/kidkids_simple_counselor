<?php
class QuestionModel {
    public $conn;
    public $ascChar = "DESC";

    public function __construct($conn){
        $this->conn = $conn;
    }

    function add($question){
        $stmt = $this->conn->prepare("INSERT INTO questions (user_id, category, title, content, tags) 
        VALUES (:user_id, :category, :title, :content, :tags)");
        $stmt->bindParam(':user_id', $question['user_id']);
        $stmt->bindParam(':category', $question['category']);
        $stmt->bindParam(':title', $question['title']);
        $stmt->bindParam(':content', $question['content']);
        $stmt->bindParam(':tags', $question['tags']);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    function getById($id){
        $stmt = $this->conn->prepare("SELECT question_id, user_id, category, title, content, view, create_date, modify_date, tags
        FROM questions WHERE question_id=:question_id");
        $stmt->bindParam(':question_id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getForPage($offset, $limit, $sortBy, $isASC){
        $ascChar = "DESC";
        if($isASC === "true"){
            $ascChar = "ASC";
        } 

        $sql = "SELECT * FROM questions ORDER BY $sortBy $ascChar LIMIT $offset, $limit" ;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        return $results;
    }

    function getByCategoryForPage($category, $offset, $limit, $sortBy, $isASC){
        $ascChar = "DESC";
        if($isASC === "true"){
            $ascChar = "ASC";
        }
        
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE category=:category ORDER BY $sortBy $ascChar LIMIT $offset, $limit");
        $stmt->bindValue(':category', $category);
        $stmt->execute();
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

    function countByCategory($category){
        $stmt = $this->conn->prepare("SELECT count(*) FROM questions WHERE category=:category");
        $stmt->bindValue(':category', $category);
        $stmt->execute();
        $rowCount = $stmt->fetch(PDO::FETCH_NUM);

        return $rowCount;
    }
}


?>