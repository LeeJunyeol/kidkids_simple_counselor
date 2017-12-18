<?php
require_once "../Config/Database.php";
require_once '../Models/VoteModel.php';

session_start();
$conn = Database::getConnection();

$voteModel = new VoteModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(isset($_GET['ranker'])){
        $scores = $voteModel->getScoreLimit10();

        if(count($scores) > 0){
            echo json_encode([
                'success' => true,
                'ranker' => $scores
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => '사용자가 없습니다.'
            ]);
        }
    }
    break;
}

?>