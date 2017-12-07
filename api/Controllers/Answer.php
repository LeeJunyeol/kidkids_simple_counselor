<?php

// require_once "../Config/Database.php";
// $DB = new Database();
// $conn = $DB->getConnection();

// 오타로 인해 comment_id가 아니라, commnet_id 이다.
function getJoinOnAnswerByQuestionId($conn, $questionId){
    $stmt = $conn->prepare("SELECT a.answer_id as A_answerId, a.question_id as A_questionId
    , a.user_id as A_userId, a.content as A_content, a.vote_cnt as A_voteCnt, a.create_date as A_createDate
    , a.modify_date as A_modifyDate, a.label as A_label
    , c.commnet_id as C_commentId, c.user_id as C_userId
    , c.answer_id as C_answerId, c.content as C_content
    , c.parent_idx as C_parentIdx, c.level as C_level, c.seq as C_seq
    , c.create_date as C_createDate, c.modify_date as C_modifyDate 
    FROM answers as a LEFT JOIN comments as c ON a.answer_id = c.answer_id WHERE a.question_id=:question_id");
    $stmt->bindValue(':question_id', $questionId);
    $stmt->execute();
    $results = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $row;
    }
    return $results;
}

?>