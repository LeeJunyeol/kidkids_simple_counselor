-- 테이블 순서는 관계를 고려하여 한 번에 실행해도 에러가 발생하지 않게 정렬되었습니다.

-- users Table Create SQL
CREATE TABLE users
(
    `user_id`    VARCHAR(45)    NOT NULL, 
    `name`       VARCHAR(50)    NOT NULL, 
    `password`   VARCHAR(45)    NOT NULL, 
    `user_type`  ENUM('우수', '전문가', '일반')           NOT NULL,
    PRIMARY KEY (user_id)
) DEFAULT CHARSET=utf8;

ALTER TABLE 

-- questions Table Create SQL
CREATE TABLE questions
(
    `question_id`  INT             NOT NULL    AUTO_INCREMENT, 
    `user_id`      VARCHAR(45)     NOT NULL, 
    `category`     VARCHAR(100)    NULL, 
    `title`        VARCHAR(200)    NOT NULL, 
    `content`      TEXT            NOT NULL, 
    `view`         INT             NOT NULL, 
    `create_date`  DATETIME        NOT NULL, 
    `modify_date`  DATETIME        NOT NULL, 
    PRIMARY KEY (question_id)
);

ALTER TABLE questions ADD CONSTRAINT FK_questions_user_id_users_user_id FOREIGN KEY (user_id)
 REFERENCES users (user_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;


CREATE TABLE answers
(
    `answer_id`    INT            NOT NULL    AUTO_INCREMENT, 
    `question_id`  INT            NOT NULL, 
    `user_id`      VARCHAR(45)    NOT NULL, 
    `content`      TEXT           NOT NULL, 
    `vote_cnt`     INT            NOT NULL, 
    `create_date`  DATETIME       NOT NULL	DEFAULT CURRENT_TIMESTAMP, 
    `modify_date`  DATETIME       NOT NULL	DEFAULT CURRENT_TIMESTAMP, 
    `label`        ENUM('일반', '전문가', '우수')           NOT NULL, 
    PRIMARY KEY (answer_id)
) DEFAULT CHARSET=utf8;

ALTER TABLE answers ADD CONSTRAINT FK_answers_question_id_questions_question_id FOREIGN KEY (question_id)
 REFERENCES questions (question_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE answers ADD CONSTRAINT FK_answers_user_id_users_user_id FOREIGN KEY (user_id)
 REFERENCES users (user_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;


-- Votes Table Create SQL
CREATE TABLE Votes
(
    `vote_id`    INT            NOT NULL    AUTO_INCREMENT, 
    `answer_id`  INT            NULL, 
    `user_id`    VARCHAR(45)    NULL, 
    `vote`       INT            NULL, 
    PRIMARY KEY (vote_id)
);

ALTER TABLE Votes ADD CONSTRAINT FK_Votes_answer_id_answers_answer_id FOREIGN KEY (answer_id)
 REFERENCES answers (answer_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE Votes ADD CONSTRAINT FK_Votes_user_id_users_user_id FOREIGN KEY (user_id)
 REFERENCES users (user_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;


-- comments Table Create SQL
CREATE TABLE comments
(
    `commnet_id`   INT `answer_id``answer_vote`           NOT NULL    AUTO_INCREMENT, 
    `user_id`      VARCHAR(45)    NOT NULL, 
    `answer_id`    INT            NULL, 
    `content`      TEXT           NOT NULL, 
    `parent_idx`   INT            NULL, 
    `level`        INT            NOT NULL, 
    `seq`          INT            NOT NULL, 
    `create_date`  DATETIME       NOT NULL	DEFAULT CURRENT_TIMESTAMP, 
    `modify_date`  DATETIME       NOT NULL	DEFAULT CURRENT_TIMESTAMP, 
    PRIMARY KEY (commnet_id)
) DEFAULT CHARSET=utf8;

ALTER TABLE comments ADD CONSTRAINT FK_comments_user_id_users_user_id FOREIGN KEY (user_id)
 REFERENCES users (user_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE comments ADD CONSTRAINT FK_comments_answer_id_answers_answer_id FOREIGN KEY (answer_id)
 REFERENCES answers (answer_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;


-- answer_vote Table Create SQL
CREATE TABLE answer_vote
(
    `answer_id`  INT    NULL, 
    `vote_id`    INT    NOT NULL
) DEFAULT CHARSET=utf8;

ALTER TABLE answer_vote ADD CONSTRAINT FK_answer_vote_answer_id_answers_answer_id FOREIGN KEY (answer_id)
 REFERENCES answers (answer_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE answer_vote ADD CONSTRAINT FK_answer_vote_vote_id_Votes_vote_id FOREIGN KEY (vote_id)
 REFERENCES Votes (vote_id)  ON DELETE RESTRICT ON UPDATE RESTRICT;




