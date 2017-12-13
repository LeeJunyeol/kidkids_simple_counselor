<?php
require_once "../Config/Database.php";
require_once '../Models/UserModel.php';

$conn = Database::getConnection();

$userModel = new UserModel($conn);

switch($_SERVER['REQUEST_METHOD']){
    case 'POST':
    if(isset($_POST['register'])){
        $id = $_POST(['id']);
        $password = password_hash($_POST(['password']), PASSWORD_BCRYPT);
        $name = $_POST(['name']);
        $email = $_POST(['email']);

        $hash = md5(rand(0,1000));

        

        $userModel->resister($id, $password, $name, $email, $hash);
    }

}

?>