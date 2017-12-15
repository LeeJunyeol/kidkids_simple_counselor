<?php
class AnswerModel {
    public $conn;
    
    public function __construct($conn){
        $this->conn = $conn;
        require_once "../Util/Util.php";
    }

    function add($answer){
        $stmt = $this->conn->prepare("INSERT INTO answers (question_id, user_id, title, content) VALUES (:question_id, :user_id, :title, :content)");
        $stmt->bindParam(':question_id', $answer['question_id']);
        $stmt->bindParam(':user_id', $answer['user_id']);
        $stmt->bindParam(':title', $answer['title']);
        $stmt->bindParam(':content', $answer['content']);
        
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    function getForPage($offset, $limit){
        try {
            $sql = "SELECT * FROM answers LIMIT $offset, $limit";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $answers = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $answers[] = $row;
            }
            return $answers;
        } catch (PDOException $e) {
            print $e->getMessage();
            exit;
        }
    }
        
    function getById($id){
        $stmt = $this->conn->prepare("SELECT a.answer_id, a.question_id, a.user_id as author, a.content, a.create_date
        , a.modify_date, u.user_type as label, a.title, v.user_id, IFNULL(v.vote, 0) AS vote
        FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id
        LEFT JOIN users AS u ON a.user_id = u.user_id
        WHERE a.answer_id = :answer_id");
        $stmt->bindValue(':answer_id', $id);
        $stmt->execute();
        $answer = $stmt->fetchObject();
        return $answer;
    }

    function getByQuestionIdAndUserId($questionId, $userId){
        $stmt = $this->conn->prepare("SELECT a.answer_id, a.question_id, a.user_id as author, a.content, a.create_date
        , a.modify_date, u.user_type as label, a.title, v.user_id, IFNULL(v.vote, 0) AS vote
        FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
        LEFT JOIN users AS u ON a.user_id = u.user_id
        WHERE a.question_id = :question_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }

        $grouped = array_group_by($results, 'answer_id'); // answer_id를 기준으로 그룹
        $finalAnswers = array();
        
        // vote를 합쳐서 votesum을 구하고, 내가 투표한 답변이라면 내 정보를 추가
        foreach ($grouped as &$value) {
            $initial = array_shift($value); 
            if(!isset($userId)){
                if($initial['user_id'] == $userId){
                    $initial['myuser'] = $initial['user_id'];
                    $initial['myvote'] = $initial['vote'];
                }
            }
        
            $initial['votesum'] = $initial['vote'];
            
            $t = array_reduce($value, function($result, $item) { 
                if(!isset($userId)){
                    if($result['user_id'] == $item['user_id']){
                        $result['myuser'] = $item['user_id'];
                        $result['myvote'] = $item['vote'];
                    }
                }
                $result['votesum'] += $item['vote'];

                return $result;
            }, $initial);
            array_push($finalAnswers, $t);
        }
        usort ($finalAnswers, array("AnswerModel", "cmp"));
        
        return $finalAnswers;
    }

    function getByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT a.answer_id, a.question_id, a.user_id as author, a.content, a.create_date
        , a.modify_date, u.user_type as label, a.title, v.user_id, IFNULL(v.vote, 0) AS vote
        FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
        LEFT JOIN users AS u ON a.user_id = u.user_id
        WHERE a.question_id = :question_id");
        $stmt->bindValue(':question_id', $questionId);
        $stmt->execute();
        $results = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $results[] = $row;
        }

        $grouped = array_group_by($results, 'answer_id'); // answer_id를 기준으로 그룹
        $finalAnswers = array();
        
        // vote를 합쳐서 votesum을 구하고, 내가 투표한 답변이라면 내 정보를 추가
        foreach ($grouped as &$value) {
            $initial = array_shift($value); 
            $initial['votesum'] = $initial['vote'];
            
            $t = array_reduce($value, function($result, $item) { 
                $result['votesum'] += $item['vote'];
                return $result;
            }, $initial);
            array_push($finalAnswers, $t);
        }
        usort ($finalAnswers, array("AnswerModel", "cmp"));
        
        return $finalAnswers;
    }

    
    function getJoinOnAnswerByQuestionId($questionId){
        $stmt = $this->conn->prepare("SELECT c.commnet_id, c.user_id
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

    function deleteByQuestionId($questionId){
        // var_dump($questionId);
        // exit;
        $sql = "DELETE FROM `answers` WHERE `question_id`=:question_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":question_id", $questionId, PDO::PARAM_INT);
        if($stmt->execute()){
            echo "됨";
            return true;
        } else {
            echo "안됨";
            return false;
        }
    }

    // 투표합계 정렬하는 사용자함수.
    static function cmp($a, $b)
    {
        if ($a['votesum'] == $b['votesum']) {
            return 0;
        }
        return ($a['votesum'] > $b['votesum']) ? -1 : 1;
    }
}
?>