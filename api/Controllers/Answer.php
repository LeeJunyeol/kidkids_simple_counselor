<?php
require_once "../Config/Database.php";
require_once '../Models/AnswerModel.php';

$conn = Database::getConnection();

$answerModel = new AnswerModel($conn);
//var_dump($_SERVER);
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
}

?>