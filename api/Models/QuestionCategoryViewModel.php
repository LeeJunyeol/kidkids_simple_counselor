<?php
class QuestionCategoryViewModel {
    public $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
    }

    function getPagination($offset, $limit, $sortBy, $isASC){
        $ascChar = "DESC";
        if($isASC === "true"){
            $ascChar = "ASC";
        }
        try {
            // 가장 상위 카테고리는 모든 질문들을 포함하고 있다.
            $sql = "SELECT * FROM question_category_view WHERE category_id = 1 OR category_id = 2 ORDER BY $sortBy $ascChar LIMIT $offset, $limit;";
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

    function getPaginationByCategoryId($categoryId, $offset, $limit, $sortBy, $isASC){
        $ascChar = "DESC";
        if($isASC === "true"){
            $ascChar = "ASC";
        }
        try {
            $sql = "SELECT * FROM question_category_view WHERE category_id = :categoryId ORDER BY $sortBy $ascChar LIMIT $offset, $limit";
            $stmt = $this->conn->prepare($sql);
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
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function countByCategoryId($categoryId){
        try {
            $sql = "SELECT count(*) FROM question_category_view WHERE category_id = :categoryId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':categoryId', $categoryId);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            $rowCount = $stmt->fetch(PDO::FETCH_NUM);

            return $rowCount;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }
}
?>