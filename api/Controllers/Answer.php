<?php

// 오타로 인해 comment_id가 아니라, commnet_id 이다.
function getByQuestionId($conn, $questionId){
    $stmt = $conn->prepare("SELECT * FROM answers WHERE question_id=:question_id");
    $stmt->bindValue(':question_id', $questionId);
    $stmt->execute();
    $results = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
    }
    return $results;
}

function getJoinOnAnswerByQuestionId($conn, $questionId){
    $stmt = $conn->prepare("SELECT c.commnet_id, c.user_id
    , c.answer_id, c.content
    , c.parent_idx, c.level, c.seq
    , c.create_date, c.modify_date 
    FROM answers as a JOIN opinions as c ON a.answer_id = c.answer_id WHERE a.question_id=:question_id");
    $stmt->bindValue(':question_id', $questionId);
    $stmt->execute();
    $results = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
    }
    return $results;
}


?>