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

// 내꺼 불러오고 수정할 때
// /api/my/Question
if(isset($_GET['my'])){
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
        if(isset($_GET['id'])){
            $id  = $_GET['id'];
            $question = $questionModel->getById($id);
            echo json_encode([
                "question" => $question
            ]);
            return;
        }
        break;
        case 'PUT':
        if(isset($_GET['id'])){
            $mydata = json_decode(file_get_contents('php://input'));
            if($questionModel->updateMe($_GET['id'], $mydata)){
                echo json_encode([
                    'success'=> true,
                    'message'=> "수정이 성공했습니다!",
                    'redirectURL' => str_replace("/api/my", "", strtolower($_SERVER['REDIRECT_URL']))
                ]);
            } else {
                echo json_encode([
                    'success'=> false,
                    'message'=> "수정이 실패했습니다!"
                ]);
            };
            return;
        }
        break;
        case 'DELETE':
        if(isset($_GET['id'])){
            if($questionModel->deleteById($_GET['id'])){
                echo json_encode([
                    'success'=> true,
                    'messages'=> "삭제가 성공했습니다!"
                ]);
            } else {
                echo json_encode([
                    'success'=> false,
                    'messages'=> "삭제가 실패했습니다!"
                ]);
            };
            return;
        }
        break;
    }
} else {
    // /api/Question
    switch($_SERVER['REQUEST_METHOD']){
        case 'GET':
        // 카테고리별 출력
        if(isset($_GET['categoryId']) && isset($_GET['page']) && isset($_GET['sortBy']) && isset($_GET['isASC'])){
            $limit = $_GET['page'] * 5;
            $offset = $limit - 5;

            $categoryId = $_GET['categoryId'];
            $isASC = $_GET['isASC'];
            $sortBy = "create_date";
            switch($_GET['sortBy']){
                case "latest":
                $sortBy = "create_date";
                break;
                case "cnt":
                $sortBy = "view";
            }
            
            $questions = $questionModel->getByCategoryForPage($categoryId, $offset, $limit, $sortBy, $isASC);
            $rowCount = $questionModel->countByCategory($categoryId);
            
            echo json_encode([
                'count'=> $rowCount,
                'questions'=> $questions
            ]);
            return;
        }
        // 전체 조회 (카테고리별 X)
        if(!isset($_GET['categoryId']) && isset($_GET['page']) 
        && isset($_GET['sortBy']) && isset($_GET['isASC']) 
        && isset($_GET['limit'])){
            $limit = $_GET['limit'];
            $offset = ($_GET['page'] - 1) * $limit;

            $isASC = $_GET['isASC'];
            $sortBy = "create_date";
            switch($_GET['sortBy']){
                case "id":
                $sortBy = "question_id";
                case "latest":
                $sortBy = "create_date";
                break;
                case "cnt":
                $sortBy = "view";
            }
            $results = $questionModel->getForPage($offset, $limit, $sortBy, $isASC);
            $rowCount = $questionModel->count();

            echo json_encode([
                'count'=> $rowCount,
                'questions'=> $results
            ]);
            return;        
        }
        // 홈 -> 질문클릭했을 때 불러오는 것들
        // 질문에 대한 답변과 그에 달린 의견 전부를 불러온다.
        if(isset($_GET['id'])){
            $id  = $_GET['id'];
            $question = $questionModel->getById($id);
            $answers = $answerModel->getByQuestionId($id);
            $questionOpinions = $opinionModel->getByQuestionOnQuestion($id);
            $answerOpinions = $opinionModel->getByQuestionOnAnswer($id);
            $answerGroupOpinions = array_group_by($answerOpinions, 'answer_id');
            
            echo json_encode([
                "question" => $question,
                "answers" => $answers,
                "questionOpinions" => $questionOpinions,
                "answerOpinions" => $answerGroupOpinions
            ]);
            return;
        }
        break;
        case 'POST':
        if(isset($_POST['mydata'])){
            $mydata = $_POST['mydata'];
            $categoryIds = explode(",", $mydata['category_ids']);
            $insertedId = $questionModel->add($mydata);
            foreach ($categoryIds as $categoryId) {
                $categoryQuestionModel->add($categoryId, $insertedId);
            }
            // 질문을 등록한다.
            echo json_encode([
                'success' => true,
                'message'=> "질문이 등록되었습니다!"
            ]);
            return;
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
        if(isset($_GET['id']) && isset($_SESSION['id']) && $_SESSION['id'] == 'admin'){
            $body = json_decode(file_get_contents('php://input'));
            if($questionModel->updateById($_GET['id'], $body)){
                echo json_encode([
                    'success' => true,
                    'message' => "수정 되었습니다."
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "수정이 되지 않았습니다."
                ]);
            };
            return;
        }
        if(isset($_GET['id'])){
            $body = json_decode(file_get_contents('php://input'));
            $questionModel->updateViewById($_GET['id'], $body->view);
            return;
        }
        break;
        case 'DELETE':
        // 관리자: 삭제
        if(isset($_GET['id']) && isset($_SESSION['id']) && $_SESSION['id'] == 'admin'){
            if($questionModel->deleteById($_GET['id'])){
                echo json_encode([
                    "success" => true,
                    "message" => "삭제 되었습니다."
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "삭제가 실패했습니다."
                ]);
            }
            return;
        }
        break;
    }
}
?>