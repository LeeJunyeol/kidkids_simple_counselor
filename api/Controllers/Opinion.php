<?php

require_once "../Config/Database.php";
$conn = Database::getConnection();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(isset($_GET['id'])){
        $answerId = $_GET['id'];
        $opinions = getByAnswerId($conn, $answerId);
        $success = count($opinions) > 0? true : false;
        echo json_encode([
            "success" => $success,
            "opinions" => $opinions
        ]);
        return;        
    }
    break;
}

function getByAnswerId($conn, $answerId){
    $stmt = $conn->prepare("SELECT * FROM opinions WHERE answer_id=:answer_id");
    $stmt->bindValue(':answer_id', $answerId);
    $stmt->execute();
    $results = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
    }
    return $results;
}
?>