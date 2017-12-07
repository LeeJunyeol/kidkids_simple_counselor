<?php

require_once "../Config/Database.php";
$DB = new Database();
$conn = $DB->getConnection();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    // BY PAGE AND COUNT ALL
    if(isset($_GET['page'])){
        // 5개씩 보여준다.
        $limit = $_GET['page'] * 5;
        $offset = $limit - 5;
        $stmt = $conn->prepare("SELECT * FROM questions LIMIT $offset, $limit");
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }

        $stmt = $conn->query("SELECT count(*) FROM questions;");
        $rowCount = $stmt->fetch(PDO::FETCH_NUM);
        $rowCount[0];
        
        echo json_encode([
            'count'=> $rowCount,
            'data'=> $results
        ]);
        return;        
    }
    // SELECT ALL
    if(!isset($_GET['id'])){        
        $results = array();

        $stmt = $conn->query("SELECT * FROM questions");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        echo json_encode($results);
        return;
    // SELECT ONE AND ANSWERS
    } else {
        $stmt = $conn->prepare("SELECT q.question_id, q.user_id, q.category, q.title, q.content, q.view, q.create_date, q.modify_date, q.tags
         FROM questions as q WHERE question_id=:question_id");
        $id  = $_GET['id'];
        $stmt->bindParam(':question_id', $id);
        $stmt->execute();
        $row = $stmt->fetchObject();

        require_once "Answer.php";
        $answers = getJoinOnAnswerByQuestionId($conn, $id);

        echo json_encode([
            "question" => $row,
            "answers" => $answers
        ]);
        return;
    }
    break;
    case 'POST':
    if(isset($_POST['mydata'])){
        $mydata = $_POST['mydata'];

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO questions (user_id, category, title, content, tags) 
        VALUES (:user_id, :category, :title, :content, :tags)");
        $stmt->bindParam(':user_id', $mydata['user_id']);
        $stmt->bindParam(':category', $mydata['category']);
        $stmt->bindParam(':title', $mydata['title']);
        $stmt->bindParam(':content', $mydata['content']);
        $stmt->bindParam(':tags', $mydata['tags']);
        
        if($stmt->execute()){
            echo json_encode([
                'success' => true,
                'message'=> "Inserted!"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message'=> "Insert Failed"
            ]);
        }
    } else {
        echo "Wrong Request";
    }
    // if(!isset($_POST['category']) || !isset($_POST['title']) || !isset($_POST['content']) || 
    // !isset($_POST['tags']) || !isset($_POST['user_id'])){
    //     echo "fail";
    // } else {
    //     $category = json_decode($_POST['category']);
    //     $title = json_decode($_POST['title']);
    //     $content = json_decode($_POST['content']);
    //     $tags = json_decode($_POST['tags']);
    //     $userId = json_decode($_POST['user_id']);
    //     echo $category;
    // }
    
    break;
    case 'PUT':
    $body = json_decode(file_get_contents('php://input'));
    echo $body->id;
    break;
    case 'DELETE':
    echo 'DELETE';
    break;
}

?>