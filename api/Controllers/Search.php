<?php
session_start();

require_once "../Config/Database.php";
require_once '../Models/QuestionModel.php';
require_once '../Models/AnswerModel.php';
require_once '../Models/VoteModel.php';
require_once '../Models/CategoryModel.php';
require_once '../Models/CategoryQuestionModel.php';
require_once '../Models/OpinionModel.php';
require_once "../Util/Util.php";

$conn = Database::getConnection();

$categoryModel = new CategoryModel($conn);
$questionModel = new QuestionModel($conn);
$categoryQuestionModel = new CategoryQuestionModel($conn);
$opinionModel = new OpinionModel($conn);
$answerModel = new AnswerModel($conn);
$voteModel = new VoteModel($conn);

if(isset($_GET["search"]) && isset($_GET["category"])){
    switch($_GET["category"]) {
        case "all":
        $kewords = explode(" ", $_GET["search"]);

        $questionResult = $questionModel->searchByKeywords($_GET["search"], $kewords);
        $answerResult = $answerModel->searchByKeywords($_GET["search"], $kewords);
        // $userResult = $userModel->

        echo json_encode([
            "questionResult" => $questionResult,
            "answerResult" => $answerResult
            // "userResult" => $userResult
            ]);
        return;
        break;
    }

}
?>