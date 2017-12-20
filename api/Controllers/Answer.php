<?php
require_once "../Config/Database.php";
require_once '../Models/AnswerModel.php';
require_once '../Models/VoteModel.php';
require_once '../Models/QuestionModel.php';

$conn = Database::getConnection();

$answerModel = new AnswerModel($conn);
$voteModel = new VoteModel($conn);
$questionModel = new QuestionModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(isset($_GET['page']) && isset($_GET['limit'])){
        $limit = $_GET['limit'];
        $offset = ($_GET['page'] - 1) * $limit;
        
        $answers = $answerModel->getForPage($offset, $limit);

        echo json_encode([
            'answers' => $answers
        ]);
        return;
    }
    break;
    case 'POST':
    if(isset($_POST['answer'])){
        $answer = $_POST['answer'];

        $insertedId = $answerModel->add($answer);
        if($insertedId){
            $insertedAnswer = $answerModel->getById($insertedId);
            $insertedAnswer->votesum = 0;
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
    break;
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
            return;
        }
    }
    $body = json_decode(file_get_contents('php://input'));
    if(isset($body->selection)){
        $answerModel->updateSelection($_GET['id'], $body->selection);
        $questionModel->updateSelectedAnswerId($_GET['id'], $body->questionId);
        echo json_encode([
            'success' => true,
            'message'=> "채택 완료!"
        ]);
    }
    break;    
}

?>