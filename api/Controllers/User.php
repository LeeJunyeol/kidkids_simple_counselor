<?php
require_once "../Config/Database.php";
require_once '../Models/UserModel.php';

session_start();
$conn = Database::getConnection();

$userModel = new UserModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
    if(isset($_POST['login'])){
        $id = $_POST['id'];
        $user = $userModel->getById($id);
        if($user == null){
            $_SESSION['message'] = 'User with this email already exists!';
            header("location: error.php");
            exit;
        } else {
            if ( password_verify($_POST['password'], $user->password) ) {
                $_SESSION['id'] = $user->user_id;
                $_SESSION['email'] = $user->email;
                $_SESSION['name'] = $user->name;
                $_SESSION['user_type'] = $user->user_type;
                
                // This is how we'll know the user is logged in
                $_SESSION['logged_in'] = true;

                header("location: http://localhost/ksc/home");
            }
            else {
                $_SESSION['message'] = "You have entered wrong password, try again!";
                header("location: error.php");
            }
        }
        return;
    }
    if(isset($_POST['register'])){
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $hash = md5(rand(0,1000));

        if($userModel->getById($id) != null){
            $_SESSION['message'] = 'User with this email already exists!';
            header("location: error.php");
            exit;
        }

        if($userModel->register($id, $password, $name, $email, $hash)){
            echo json_encode([
                'success'=> true,
                'messages'=> "회원가입에 성공했습니다!"
            ]);
            header("location: http://localhost/ksc/home");
        } else {
            echo json_encode([
                'success'=> false,
                'messages'=> "회원가입에 실패했습니다!"
            ]);
        };
        return;
    };
}

?>