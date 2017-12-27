<?php 
namespace KCS\Model;

use KCS\Config\Database;
use \PDO;

class CategoryModel {
    public $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
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
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function searchByCategoryName($categoryName){
        try {
            $sql = "SELECT me.*, parent.category_id as p_c_id, 
            parent.category_name as p_c_name, parent.depth as p_c_depth,
            parent.parent_idx as p_p_idx FROM 
            (SELECT * FROM categories WHERE category_name LIKE '%$categoryName%') AS me 
            INNER JOIN categories AS parent 
            ON parent.category_id = me.parent_idx;";
            $stmt = $this->conn->prepare($sql);
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                print_r($stmt->errorInfo());
                exit;
            }
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    function searchAll() {
        try {
            $sql = "SELECT me.*, parent.category_id as p_c_id, 
            parent.category_name as p_c_name, parent.depth as p_c_depth,
            parent.parent_idx as p_p_idx FROM 
            (SELECT * FROM categories) AS me INNER JOIN categories AS parent 
            ON parent.category_id = me.parent_idx;";
            $stmt = $this->conn->prepare($sql);
            if($stmt->execute()){
                $categories = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $categories[] = $row;
                }
                return $categories;
            } else {
                print_r($stmt->errorInfo());
                exit;
            }
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
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
        } catch (\PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }
}

?>