<?php
require_once "../Config/Database.php";
require_once '../Models/UserModel.php';

$conn = Database::getConnection();

$userModel = new UserModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
    if(isset($_POST['register'])){
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
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
    };
}

?>