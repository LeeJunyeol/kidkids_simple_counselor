<?php 

class CategoryQuestionModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function add($categoryId, $questionId){
        try {
            $stmt = $this->conn->prepare("INSERT INTO category_question (`category_id`, `question_id`) VALUES (?, ?)");
            $stmt->bindParam(1, $categoryId);
            $stmt->bindParam(2, $questionId);
            if($stmt->execute()){
                return $this->conn->lastInsertId();
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }        
}
?>