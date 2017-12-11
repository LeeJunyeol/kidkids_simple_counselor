<?php

require_once "../Config/Database.php";
require_once '../Models/QuestionModel.php';
require_once '../Models/AnswerModel.php';

$conn = Database::getConnection();

$questionModel = new QuestionModel($conn);
$answerModel = new AnswerModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    // 카테고리별 출력
    if(isset($_GET['category']) && isset($_GET['page'])){
        $limit = $_GET['page'] * 5;
        $offset = $limit - 5;

        $category = $_GET['category'];
        $results = $questionModel->getByCategoryForPage($category, $offset, $limit);
        $rowCount = $questionModel->countByCategory($category);
        
        echo json_encode([
            'count'=> $rowCount,
            'data'=> $results
        ]);
        return;
    }
    // 전체 출력
    if(!isset($_GET['category']) && isset($_GET['page'])){
        // 5개씩 보여준다.
        $limit = $_GET['page'] * 5;
        $offset = $limit - 5;

        $results = $questionModel->getForPage($offset, $limit);
        $rowCount = $questionModel->count();

        echo json_encode([
            'count'=> $rowCount,
            'data'=> $results
        ]);
        return;        
    }
    // 질문에 대한 답변과 그에 달린 의견 전부를 불러온다.
    if(isset($_GET['id'])){
        $id  = $_GET['id'];
        $question = $questionModel->getById($id);
        $answers = $answerModel->getByQuestionId($id);
        $opinions = $answerModel->getJoinOnAnswerByQuestionId($id);
        
        echo json_encode([
            "question" => $row,
            "answers" => $answers,
            "opinions" => $opinions
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