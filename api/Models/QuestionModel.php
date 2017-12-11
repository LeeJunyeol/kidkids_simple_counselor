<?php
class QuestionModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    
    function getById($id){
        $stmt = $this->conn->prepare("SELECT question_id, user_id, category, title, content, view, create_date, modify_date, tags
        FROM questions WHERE question_id=:question_id");
        $stmt->bindParam(':question_id', $id);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getForPage($offset, $limit){
        $stmt = $this->conn->prepare("SELECT * FROM questions LIMIT $offset, $limit");
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        return $results;
    }

    function getByCategoryForPage($category, $offset, $limit){
        $stmt = $this->conn->prepare("SELECT * FROM questions WHERE category=:category LIMIT $offset, $limit");
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