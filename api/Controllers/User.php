<?php
require_once "../Config/Database.php";
require_once '../Models/UserModel.php';
require_once '../Models/VoteModel.php';
require_once '../Models/QuestionModel.php';
require_once '../Models/AnswerModel.php';


session_start();
$conn = Database::getConnection();

$userModel = new UserModel($conn);
$voteModel = new VoteModel($conn);
$questionModel = new QuestionModel($conn);
$answerModel = new AnswerModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $user = $userModel->getById($id);
        $myscore = $voteModel->getMyTotalScore($id);
        $user->score = $myscore->score;

        $recentAnswer = $answerModel->getMyAnswerRecent5($id);
        $recentQuestion = $questionModel->getMyQuestionRecent5($id);
        $currentRank = $userModel->getCurrentRank($id);
        
        echo json_encode([
            "success" => true,
            "user" => $user,
            "recentAnswer" => $recentAnswer,
            "recentQuestion" => $recentQuestion,
            "currentRank" => $currentRank

        ]);
        return;
    }
    $userScores = $userModel->getUserScoreAll();
    echo json_encode($userScores);
    break;
    case 'POST':
    if(isset($_POST['login'])){
        $id = $_POST['id'];
        $user = $userModel->getById($id);
        $myscore = $voteModel->getMyTotalScore($id);
        if($user == null){
            $_SESSION['message'] = '아이디가 존재하지 않습니다. 회원가입을 해주세요.';
            header("location: /ksc/signup");
            exit;
        } else {
            if ( password_verify($_POST['password'], $user->password) ) {
                $_SESSION['id'] = $user->user_id;
                $_SESSION['email'] = $user->email;
                $_SESSION['name'] = $user->name;
                $_SESSION['user_type'] = $user->user_type;
                $_SESSION['user_image'] = $user->user_pic;
                $_SESSION['myscore'] = $myscore->score;
                
                $_SESSION['logged_in'] = true;

                if($_SESSION['id'] == 'admin'){
                    header("location: /ksc/admin");
                    return;
                }
                header("location: /ksc/home");
                return;
            }
            else {
                $_SESSION['message'] = "아이디 또는 비밀번호가 일치하지 않습니다.";
                header("location: /ksc/login");
            }
        }
        return;
    }
    if(isset($_POST['register'])){
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $name = $_POST['name'];
        $email = $_POST['email'];

		$imgFile = $_FILES['image']['name'];
		$tmp_dir = $_FILES['image']['tmp_name'];
		$imgSize = $_FILES['image']['size'];

		if(empty($id)){
			$_SESSION['message'] = "Please Enter User ID.";
            header("location: /ksc/signup");
            exit;
		}
		else if(empty($name)){
			$_SESSION['message'] = "Please Enter Your Name.";
            header("location: /ksc/signup");
            exit;
		}
		else if(empty($imgFile)){
			$_SESSION['message'] = "Please Select Image File.";
            header("location: /ksc/signup");
            exit;
		}
		else
		{
			$upload_dir = '../../user_images/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$_SESSION['message'] = "Sorry, your file is too large.";
                    header("location: /ksc/signup");
                    exit;
                }
			}
			else{
				$_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
                header("location: /ksc/signup");
                exit;
            }
		}

        $hash = md5(rand(0,1000));

        if($userModel->getById($id) != null){
            $_SESSION['message'] = 'User with this email already exists!';
            header("location: /ksc/signup");
            exit;
        }

        if($userModel->register($id, $password, $name, $email, $hash, $userpic)){
            $_SESSION['message'] = '회원으로 등록되었습니다. 로그인해주세요!';
            header("location: /ksc/login");
        } else {
            $_SESSION['message'] = '회원가입에 실패하였습니다.';
        };
        return;
    };
    break;
    case 'PUT':
    $user = json_decode(file_get_contents('php://input'));
    $userModel -> updateUserType($user->user_id, $user->user_type);
    echo json_encode("success");
    break;
}

?>