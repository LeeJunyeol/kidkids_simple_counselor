<?php
require_once "../Config/Database.php";
require_once '../Models/UserModel.php';
require_once '../Models/QuestionModel.php';
require_once '../Models/AnswerModel.php';
require_once '../Models/VoteModel.php';

session_start();

$conn = Database::getConnection();

$userModel = new UserModel($conn);
$questionModel = new QuestionModel($conn);
$answerModel = new AnswerModel($conn);
$voteModel = new VoteModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(isset($_GET['all']) && $_SESSION['logged_in']){
        $user = $userModel->getById($_SESSION['id']);
        $recentAnswer = $answerModel->getMyAnswerRecent5($_SESSION['id']);
        $recentQuestion = $questionModel->getMyQuestionRecent5($_SESSION['id']);
        $currentRank = $userModel->getCurrentRank($_SESSION['id']);
        
        echo json_encode([
            "success" => true,
            "user" => $user,
            "recentAnswer" => $recentAnswer,
            "recentQuestion" => $recentQuestion,
            "currentRank" => $currentRank
            ]);
        return;
    }

    break;
}    



?>