<?php
class UserModel {
    public $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    function getCurrentRank($id){
        try {
            $sql = "SELECT u.user_id,
            (SUM(ifnull(a.selection,0)) * 100 + SUM(ifnull(v.vote * 5, 0))) AS score
            FROM users AS u 
            LEFT JOIN answers AS a ON u.user_id = a.user_id 
            LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
            GROUP BY u.user_id ORDER BY score DESC LIMIT 10";
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

    function getById($id){
        $stmt = $this->conn->prepare("SELECT `user_id`, `password`, `naver_id`, `kakao_id`, `fb_id`, `email`, `name`, `user_pic`, `user_type` FROM users WHERE user_id=:user_id");
        $stmt->bindParam(':user_id', $id);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        }
        return $stmt->fetchObject();
    }

    function updateUserType($user_id, $user_type){
        try {
            $sql = "UPDATE `users` SET `user_type` = :user_type WHERE `user_id` = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":user_type", $user_type);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function getAnswerCountGroupByUser(){
        $sql = "SELECT user_id, COUNT(*) as answer_cnt FROM answers GROUP BY user_id";
        $stmt = $this->conn->prepare($sql);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        }
        $answerCnt = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $answerCnt[] = $row;
        }
        return $answerCnt;
    }

    function getQuestionCountGroupByUser(){
        $sql = "SELECT user_id, COUNT(*) as question_cnt FROM questions GROUP BY user_id";
        $stmt = $this->conn->prepare($sql);
        if(!$stmt->execute()){
            print_r($stmt->errorInfo());
            exit;
        }
        $questionCnt = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $questionCnt[] = $row;
        }
        return $questionCnt;
    }

    function getUserScoreAll() {
        try {
            $sql = "SELECT u.user_id, u.user_type, u.name,
            (SUM(ifnull(a.selection,0)) * 100 + SUM(ifnull(v.vote * 5, 0))) AS myscore, (SUM(ifnull(a.selection, 0)) / COUNT(*)) * 100 AS selection_percentage
            FROM users AS u 
            LEFT JOIN answers AS a ON u.user_id = a.user_id 
            LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
            GROUP BY u.user_id ORDER BY selection_percentage DESC";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            }
            $userScores = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $userScores[] = $row;
            }
            return $userScores;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function register($id, $password, $name, $email, $hash, $pic){
        $stmt = $this->conn->prepare("INSERT INTO users (`user_id`, `name`, `password`, `user_type`, `email`, `hash`, `user_pic`) VALUES (?, ?, ?, '일반', ?, ?, ?)");
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $password);
        $stmt->bindParam(4, $email);
        $stmt->bindParam(5, $hash);
        $stmt->bindParam(6, $pic);
        
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    function registerSNS($id, $name, $email, $pic){
        $stmt = $this->conn->prepare("INSERT INTO users (`user_id`, `name`, `user_type`, `email`, `user_pic`) 
        VALUES (?, ?, '일반', ?, ?)");
        $stmt->bindParam(1, $id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $pic);
        
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    function updateMyKakao($kcsid, $snsid){
        try {
            $sql = "UPDATE users SET kakao_id = :kakao_id WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":user_id", $kcsid);
            $stmt->bindParam(":kakao_id", $snsid);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function updateMyNaver($kcsid, $snsid){
        try {
            $sql = "UPDATE users SET naver_id = :naver_id WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":user_id", $kcsid);
            $stmt->bindParam(":naver_id", $snsid);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }

    function disconnectSNS($id, $sns_id){
        try {
            $sql = "UPDATE users SET $sns_id = NULL WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":user_id", $id);
            if(!$stmt->execute()){
                print_r($stmt->errorInfo());
                exit;
            };
            return true;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }
}