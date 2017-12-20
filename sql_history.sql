SELECT v.user_id, SUM(v.vote),  AS score FROM votes AS v 
INNER JOIN (SELECT user_id, selection FROM answers WHERE selection = TRUE) AS map ON v.user_id = map.user_id
GROUP BY v.user_id ORDER BY score DESC LIMIT 10;

SELECT user_id FROM answers;

SELECT a.answer_id, a.user_id, (SUM(a.selection) * 100 + SUM(v.vote)) AS score FROM answers AS a INNER JOIN votes AS v ON a.answer_id = v.answer_id GROUP BY user_id ORDER BY score DESC;

SELECT answer_id, COUNT(*) AS vote_cnt FROM votes WHERE vote = 1 GROUP BY answer_id; 

SELECT a.*, IFNULL(plus.plus_vote_cnt, 0) AS plus_vote_cnt, IFNULL(minus.minus_vote_cnt, 0) AS minus_vote_cnt FROM answers AS a 
LEFT JOIN (SELECT answer_id, COUNT(*) AS plus_vote_cnt FROM votes WHERE vote = 1 GROUP BY answer_id) AS plus ON plus.answer_id = a.answer_id
LEFT JOIN (SELECT answer_id, COUNT(*) AS minus_vote_cnt FROM votes WHERE vote = -1 GROUP BY answer_id) AS minus ON minus.answer_id = a.answer_id
WHERE question_id = 41

SELECT a.answer_id, a.question_id, a.user_id AS author, a.content, a.create_date, a.modify_date, a.title, u.user_type AS label, IFNULL(plus.plus_vote_cnt, 0) AS plus_vote_cnt, IFNULL(minus.minus_vote_cnt, 0) AS minus_vote_cnt FROM answers AS a 
        LEFT JOIN (SELECT answer_id, COUNT(*) AS plus_vote_cnt FROM votes WHERE vote = 1 GROUP BY answer_id) AS plus ON plus.answer_id = a.answer_id
        LEFT JOIN (SELECT answer_id, COUNT(*) AS minus_vote_cnt FROM votes WHERE vote = -1 GROUP BY answer_id) AS minus ON minus.answer_id = a.answer_id
        LEFT JOIN users AS u ON a.user_id = u.user_id
        WHERE question_id = 41

SELECT a.answer_id, a.question_id, a.user_id AS author, a.content, a.create_date
        , a.modify_date, u.user_type AS label, a.title, v.user_id, IFNULL(v.vote, 0) AS vote
        FROM answers AS a 
        LEFT JOIN votes AS v ON a.answer_id = v.answer_id 
        LEFT JOIN users AS u ON a.user_id = u.user_id
        WHERE a.question_id = 32