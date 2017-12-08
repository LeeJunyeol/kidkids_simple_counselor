<?php

require_once "../Config/Database.php";
$DB = new Database();
$conn = $DB->getConnection();

if(isset($_GET['category']) && isset($_GET['page'])){
    // 5개씩 보여준다.
    $limit = $_GET['page'] * 5;
    $offset = $limit - 5;
    $stmt = $conn->prepare("SELECT * FROM questions WHERE category=:category LIMIT $offset, $limit");
    $stmt->bindParam(":category", $_GET['category']);
    $stmt->execute();
    $results = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
    }

    $stmt = $conn->prepare("SELECT count(*) FROM questions WHERE category=:category");
    $stmt->bindParam(":category", $_GET['category']);
    $stmt->execute();
    $rowCount = $stmt->fetch(PDO::FETCH_NUM);
    
    echo json_encode([
        'count'=> $rowCount[0],
        'data'=> $results
    ]);

    return;        
}

?>