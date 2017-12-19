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

    function getVoteCount($vote){
        try {
            $sql = "SELECT answer_id, COUNT(*) AS vote_cnt FROM votes WHERE vote = :vote GROUP BY answer_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':vote', $vote);

            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }
            $voteCounts = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $voteCounts[] = $row;
            }
            return $voteCounts;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
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

    // 점수, 채택 답변 점수 합산
    // 채택 답변 100점, 추천 1점, 비추천 -1점
    function getScoreLimit10(){
        try {
            $sql = "SELECT a.user_id, 
            (SUM(a.selection) * 100 + SUM(v.vote)) AS score 
            FROM answers AS a INNER JOIN votes AS v ON a.answer_id = v.answer_id 
            GROUP BY user_id ORDER BY score DESC LIMIT 10";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            $scores = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $scores[] = $row;
            }
            return $scores;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getMyTotalScore($userId){
        try {
            $stmt = $this->conn->prepare("SELECT (SUM(a.selection) * 100 + SUM(v.vote)) AS score 
            FROM answers AS a INNER JOIN votes AS v ON a.answer_id = v.answer_id WHERE a.user_id = :user_id");
            $stmt->bindParam(':user_id', $userId);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

}