<?php 
require_once "../Domain/Category.php";

class CategoryModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    
    function add($categoryName, $depth, $parentIdx){
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (`category_name`, `depth`, `parent_idx`) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $categoryName);
            $stmt->bindParam(2, $depth);
            $stmt->bindParam(3, $parentIdx);
            if($stmt->execute()){
                return $this->conn->lastInsertId();
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function searchByCategoryName($categoryName){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_name=?");
            $stmt->bindParam(1, $categoryName);
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getSub($parentIdx){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE parent_idx=?");
            $stmt->bindParam(1, $parentIdx);
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getAll(){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories");
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getByCategoryId($categoryId){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE category_id=?");
            $stmt->bindParam(1, $categoryId);
            if($stmt->execute()){
                $category = $stmt->fetchObject();
                return $category;
            } else {
                return $stmt->errorInfo();
            };
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function getForPage($offset, $limit){
        try {
            $sql = "SELECT * FROM categories LIMIT $offset, $limit";
            $stmt = $this->conn->prepare($sql);
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                return $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }
}

?>