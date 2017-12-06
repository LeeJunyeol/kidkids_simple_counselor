<?php

require_once "../Config/Database.php";
$DB = new Database();
$conn = $DB->getConnection();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
    if(!isset($_GET['id'])){
        
        $results = array();

        $stmt = $conn->query("SELECT * FROM questions");
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }
        echo json_encode($results);
    }
    break;
    case 'POST':
    echo 'POST';
    break;
    case 'PUT':
    echo 'PUT';
    break;
    case 'DELETE':
    echo 'DELETE';
    break;
}

?>