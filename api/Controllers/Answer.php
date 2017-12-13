<?php
require_once "../Config/Database.php";
require_once '../Models/AnswerModel.php';
require_once '../Models/VoteModel.php';

$conn = Database::getConnection();

$answerModel = new AnswerModel($conn);
$voteModel = new VoteModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
    if(isset($_POST['answer'])){
        $answer = $_POST['answer'];

        $insertedId = $answerModel->add($answer);
        if($insertedId){
            $insertedAnswer = $answerModel->getById($insertedId);
            echo json_encode([
                'success' => true,
                'data'=> $insertedAnswer
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'data'=> "Insert Failed"
            ]);
        }
    }
    case 'PUT':
    if(isset($_GET['action'])){
        if($_GET['action'] == "vote"){
            $vote = json_decode(file_get_contents('php://input'));
            if($voteModel->add($vote->answerId, $vote->userId, $vote->score)){
                echo json_encode([
                    'success' => true,
                    'message'=> "투표 완료!"
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message'=> "이미 투표하셨습니다."
                ]);
            };
        }
    }
    break;    
}

?>