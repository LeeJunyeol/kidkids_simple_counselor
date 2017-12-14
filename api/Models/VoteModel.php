<?php
class VoteModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function add($answerId, $userId, $vote){
        $stmt = $this->conn->prepare("INSERT INTO votes (`answer_id`, `user_id`, `vote`) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $answerId);
        $stmt->bindParam(2, $userId);
        $stmt->bindParam(3, $vote);
        
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    function getByUserIdAndAnswerID($userId, $answerId){
        $stmt = $this->conn->prepare("SELECT vote FROM votes WHERE user_id = :user_id AND answer_id = :answer_id");
        $stmt->bindValue(':user_id', $userId);
        $stmt->bindValue(':answer_id', $answerId);
        $stmt->execute();

        $answer = $stmt->fetchObject();

        return $answer;
    }

    // 점수 순위 조회
    function getScoreGroupByUser(){
        try {
            $stmt = $this->conn->prepare("SELECT user_id, SUM(vote) AS score FROM votes, (SELECT @row_number:=0) AS t GROUP BY user_id ORDER BY score DESC limit 10");
            $stmt->execute();
            $rankers = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $rankers[] = $row;
            }
            return $rankers;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getMyTotalScore($userId){
        try {
            $stmt = $this->conn->prepare("SELECT SUM(vote) FROM votes WHERE user_id=:user_id");
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_NUM);
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

}