<?php
session_start();
require_once "../Config/Database.php";
require_once "../Models/OpinionModel.php";

$conn = Database::getConnection();

$opinionModel = new OpinionModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    // question에 딸린 opinion 조회
    if(isset($_GET['question_id']) && !isset($_GET['opinion_id'])){
        $questionId = $_GET['question_id'];
        $opinions = $opinionModel->getByQuestionId($questionId);
        $success = count($opinions) > 0? true : false;
        echo json_encode([
            "success" => $success,
            "opinions" => $opinions
        ]);
        return;
    }
    // answer에 딸린 opinion 조회
    if(isset($_GET['answer_id']) && !isset($_GET['opinion_id'])){
        $answerId = $_GET['answer_id'];
        $opinions = getByAnswerId($answerId);
        $success = count($opinions) > 0? true : false;
        echo json_encode([
            "success" => $success,
            "opinions" => $opinions
        ]);
        return;        
    }
    // if(isset($_GET['id'])){
    //     $answerId = $_GET['id'];
    //     $opinions = getByAnswerId($conn, $answerId);
    //     $success = count($opinions) > 0? true : false;
    //     echo json_encode([
    //         "success" => $success,
    //         "opinions" => $opinions
    //     ]);
    //     return;        
    // }
    // break;
    break;
    case 'POST':
    if(isset($_POST['questionId'])){
        $questionId = $_POST['questionId'];
        $userId = $_SESSION['id'];
        $content = $_POST['content'];

        $insertedId = $opinionModel->addOnQuestion($questionId, $content, $userId);
        if($insertedId){
            $insertedOpinion = $opinionModel->getById($insertedId);
            echo json_encode([
                'success' => true,
                'myopinion' => $insertedOpinion
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => "insert Failed"
            ]);
        };
        return;
    }
    if(isset($_POST['answerId'])){
        
        return;
    }
}
?>