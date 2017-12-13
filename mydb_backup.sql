/*
SQLyog Community v12.5.0 (64 bit)
MySQL - 10.1.28-MariaDB : Database - mydb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mydb` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mydb`;

/*Table structure for table `answers` */

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `content` text NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `label` enum('일반','전문가','우수') NOT NULL,
  `title` varchar(100) NOT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `FK_answers_user_id_users_user_id` (`user_id`),
  KEY `FK_answers_question_id_questions_question_id` (`question_id`),
  CONSTRAINT `FK_answers_question_id_questions_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_answers_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

/*Data for the table `answers` */

insert  into `answers`(`answer_id`,`question_id`,`user_id`,`content`,`create_date`,`modify_date`,`label`,`title`) values 
(21,21,'tipa','달자','2017-12-12 17:56:05','2017-12-12 17:56:05','일반','답글'),
(22,21,'tipa','또 달자','2017-12-12 17:56:14','2017-12-12 17:56:14','일반','답글'),
(23,5,'tipa','달립니다.','2017-12-12 18:49:10','2017-12-12 18:49:10','일반','달립ㄴ디ㅏ.'),
(24,11,'tipa','남겨보자.','2017-12-13 10:17:34','2017-12-13 10:17:34','일반','답글을'),
(25,8,'tipa','입니다.','2017-12-13 10:32:49','2017-12-13 10:32:49','일반','첫 답글'),
(26,8,'tipa','답글 입니다.','2017-12-13 10:33:00','2017-12-13 10:33:00','일반','두번째'),
(27,22,'tipa','그래그래','2017-12-13 16:22:19','2017-12-13 16:22:19','일반','답글등록해볼까'),
(28,22,'tipa','그래그래','2017-12-13 16:22:31','2017-12-13 16:22:31','일반','또 답글 달아볼까'),
(29,22,'tipa','응응','2017-12-13 16:23:18','2017-12-13 16:23:18','일반','해볼까'),
(31,22,'tipa','답니다.','2017-12-13 17:10:08','2017-12-13 17:10:08','일반','답글답니다.');

/*Table structure for table `opinions` */

DROP TABLE IF EXISTS `opinions`;

CREATE TABLE `opinions` (
  `opinion_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `parent_idx` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`opinion_id`),
  KEY `FK_opinions_user_id_users_user_id` (`user_id`),
  KEY `FK_opinions_answer_id_answers_answer_id` (`answer_id`),
  CONSTRAINT `FK_comments_answer_id_answers_answer_id` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_comments_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `opinions` */

/*Table structure for table `questions` */

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `category` enum('육아/건강','교육/놀이','안전','음식','기타') NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tags` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `FK_questions_user_id_users_user_id` (`user_id`),
  CONSTRAINT `FK_questions_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `questions` */

insert  into `questions`(`question_id`,`user_id`,`category`,`title`,`content`,`view`,`create_date`,`modify_date`,`tags`) values 
(5,'jylee','기타','수정된 제목임','수정된 내용이다',1,'2017-12-07 14:58:40','2017-12-07 14:58:40','얍얍얍'),
(8,'jylee','교육/놀이','질문을 해보았어요.','내용을 입력해보아요용용용~',1,'2017-12-07 16:11:04','2017-12-07 16:11:04','얍얍얍'),
(11,'tipa','안전','등록','',4,'2017-12-08 17:55:19','2017-12-08 17:55:19','얍얍얍/얍얍얍'),
(13,'happa','안전','하자','',4,'2017-12-08 17:55:27','2017-12-08 17:55:27','고기/소/맥'),
(21,'jylee','음식','됩니다.','배고픕니다.',10,'2017-12-12 17:52:45','2017-12-12 17:52:45',''),
(22,'jylee','음식','로그인','했습니다.',18,'2017-12-13 14:26:28','2017-12-13 14:26:28','이제/제대로/해보자');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` varchar(45) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` enum('일반','전문가','우수') NOT NULL DEFAULT '일반',
  `email` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`user_id`,`name`,`password`,`user_type`,`email`,`hash`,`active`) values 
('','','','일반','','',0),
('admin','관리자','123','일반','chljy33@naver.com','',0),
('happa','하파','123','일반','black@naver.com','',0),
('jylee','이준열','123','전문가','abc@naver.com','',0),
('realmaster','마스터','$2y$10$6ivy0z4l3IkXwVryUv.ueOZqQHmaWYelmJ6uaJPBYSuNv7bW2w4H2','일반','master@naver.com','49182f81e6a13cf5eaa496d51fea6406',0),
('tipa','티파','123','우수','abcd@naver.com','',0),
('yes','이준열','$2y$10$D8p9wNf1Z2ClrnPmswTkz.9K5m2aVz9GIOCWqTl4rkLDFJiDd0esW','일반','chljy33@naver.com','72da7fd6d1302c0a159f6436d01e9eb0',0);

/*Table structure for table `votes` */

DROP TABLE IF EXISTS `votes`;

CREATE TABLE `votes` (
  `answer_id` int(11) NOT NULL,
  `user_id` varchar(45) NOT NULL,
  `vote` int(11) NOT NULL,
  PRIMARY KEY (`answer_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `votes` */

insert  into `votes`(`answer_id`,`user_id`,`vote`) values 
(21,'jylee',1),
(24,'jylee',1),
(25,'jylee',1),
(26,'jylee',-1),
(27,'jylee',1),
(28,'jylee',-1),
(29,'jylee',1),
(31,'jylee',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
