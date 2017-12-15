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
  `title` varchar(100) NOT NULL,
  `selection` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`answer_id`),
  KEY `FK_answers_user_id_users_user_id` (`user_id`),
  KEY `FK_answers_question_id_questions_question_id` (`question_id`),
  CONSTRAINT `FK_answers_question_id_questions_question_id` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_answers_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

/*Data for the table `answers` */

insert  into `answers`(`answer_id`,`question_id`,`user_id`,`content`,`create_date`,`modify_date`,`title`,`selection`) values 
(44,32,'momo','안녕하세요. 네이버 지식iN 상담 약사 정일영 입니다.\n어떤 감기약인지 모르겠는데요. 대부분은 시간이 지나면 별 문제 없이 원상태로 회복될 것입니다. 약에 따라서는 아기가 많이 잘 수도 있겠습니다.','2017-12-15 09:06:09','2017-12-15 09:06:09','약사님 답변입니다.',0),
(45,31,'momo','저희집막내는더심하게튀어나왓어용..그것도아주빵빵하게...걱정되는마음에병원을2곳갔었는데두곳다탈장인데혹시장기가끼이면바로수술하는데그런게아니고단순탈장이기때문에돌까지기다려보고안들어가면수술하자고하더라구요~그래서지켜보고있는데서서히들어가고있네요^^혹시모르니병원다녀오시는게좋을듯하네용...','2017-12-15 09:07:24','2017-12-15 09:07:24','저희집막내는더심하게튀어나왓어용',0),
(46,39,'dahyun','좋은 안전문 저도 추천좀 부탁드려요~','2017-12-15 09:33:15','2017-12-15 09:33:15','저랑 아기 시기가 비슷한거 같네요~',0),
(47,39,'dahyun','북유럽풍 디자인으로 어느곳이나 어울리는 안전문이에요!! ㅎㅎ\n저도 사용하고있는데 너무 유용한것 같아요 ^_^\n완전 강추해요!!\n이미지 첨부해드릴테니 참고하세요 ㅎㅎ','2017-12-15 09:33:45','2017-12-15 09:33:45',' 노스**이츠라는 브랜드 소개해드려요!!',0),
(48,38,'dahyun','호비인가?? 호랑이캐릭터로 그려진 교재교구가 있어요 이름이 호비라고 하는것같던데 그게 좋더라고요 아기 교구도 다양하구요','2017-12-15 09:35:01','2017-12-15 09:35:01','호비',0),
(49,41,'mina','벌써 포기하지 마세요. 우선 다 해볼 수 있는 건 다 해본 뒤에 후회하셔도 늦지 않습니다. 파이팅!','2017-12-15 09:51:41','2017-12-15 09:51:41','화이팅',0),
(50,41,'momo','요즘 4년제 미대의 경우 비실기로도 학생들 많이 뽑아요.\n미술계열로 한번 지원해보시기 바랍니다.\n아직 늦지 않았습니다. 대학가서 배 우면되요!\n대학알리미를 통해서 확인해 보시기 바랍니다.\n채택부탁드립니다.\n채택된콩은 불우한 이웃에게 기부됩니다.','2017-12-15 09:52:23','2017-12-15 09:52:23','채택부탁드립니다.',0),
(51,41,'sana','수시에서 합격을 못하셨다니 우선 굉장히 안타깝다는 말씀을 전해드리고 싶습니다.\n\n수시를 봐라보고 입시를 준비하셨더라면 더더욱\n\n 허탈감과 허망함이 있으실 텐데\n\n언제까지 힘없이 마냥 시간만\n\n보내실 수는 없지않을까 합니다.\n\n\n\n\n\n성적이 그렇게 나쁘신 것도 아니시기에\n\n남은 두달 정시특강준비를 하시면서\n\n열심히 입시준비를 하신다면 충분히\n\n 지원하시는 대학에 합격하실 수 있다고\n\n생각합니다.\n\n\n\n\n\n우선 담당선생님, 원장님과의 상담등을 통해서\n현재 질문자님의 성적대에 지원이가능한대학 성적이 조금 부족하더라고 실기로 그 부족함을  채울 수 있는 대학들의 리스트를 작성해보시고\n질문자님께서 대학, 과를 정하신 뒤 열심히 두달간 입시준비를 하시면 되겠습니다.\n\n물론 지금은 의욕도 없고 자신감이 많이\n\n떨어져계시겠지만 두달이라는 특강기간이 결코 짧은 시간이 아닌만큼 질문자님의 노력으로도 충분히 커버가 가능하다고 생각합니다.\n\n그러니 자신감을 가지시고 남은기간 최선을 다해서 특강을 마무리하시길 바랍니다.\n추가적으로 꼭 지원하시는\n학교, 과에 합격하시길 바랍니다.\n감사합니다.','2017-12-15 09:53:59','2017-12-15 09:53:59','힘내요',0),
(52,40,'nayeon','첫번째 내용입니다.','2017-12-15 09:57:38','2017-12-15 09:57:38','첫번째 댓글입니다.',0),
(53,35,'nayeon','추천 해주세요.','2017-12-15 09:57:57','2017-12-15 09:57:57','할 말이 없습니다.',0),
(54,34,'nayeon','먹여도 됩니다^^','2017-12-15 09:58:47','2017-12-15 09:58:47','네',0),
(55,37,'nayeon','제가 어떻게 알겠어요?ㅎㅎㅎㅎㅎ','2017-12-15 09:59:12','2017-12-15 09:59:12','님이 모르시는데',0),
(56,40,'jeongyeon','두번째 내용입니다.','2017-12-15 10:00:00','2017-12-15 10:00:00','두번째 댓글입니다.',0),
(60,40,'user','답글입니다.','2017-12-15 13:22:11','2017-12-15 13:22:11','답글',0),
(61,40,'momo','전문가입니다.','2017-12-15 13:30:56','2017-12-15 13:30:56','전문가입니다.',0);

/*Table structure for table `opinions` */

DROP TABLE IF EXISTS `opinions`;

CREATE TABLE `opinions` (
  `question_id` int(11) DEFAULT NULL,
  `opinion_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) NOT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `parent_idx` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`opinion_id`),
  KEY `FK_opinions_user_id_users_user_id` (`user_id`),
  KEY `FK_opinions_answer_id_answers_answer_id` (`answer_id`),
  CONSTRAINT `FK_comments_answer_id_answers_answer_id` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`answer_id`) ON DELETE CASCADE,
  CONSTRAINT `FK_comments_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `opinions` */

insert  into `opinions`(`question_id`,`opinion_id`,`user_id`,`answer_id`,`content`,`parent_idx`,`level`,`create_date`,`modify_date`) values 
(37,18,'dahyun',NULL,'하루에도 참을인 많이 씁니다.',0,0,'2017-12-15 09:35:39','2017-12-15 09:35:39'),
(37,19,'dahyun',NULL,'그런 아이 꼭 있지요..',0,0,'2017-12-15 09:36:02','2017-12-15 09:36:02'),
(36,20,'dahyun',NULL,'저도 그게 고민이네요.',0,0,'2017-12-15 09:44:36','2017-12-15 09:44:36'),
(38,21,'dahyun',NULL,'저는 또봇이요.',0,0,'2017-12-15 09:48:20','2017-12-15 09:48:20'),
(35,22,'nayeon',NULL,'입이 당기는 그런 거...?',0,0,'2017-12-15 09:58:17','2017-12-15 09:58:17'),
(37,23,'nayeon',NULL,'이아이 나빠요',0,0,'2017-12-15 09:58:31','2017-12-15 09:58:31'),
(40,24,'user',NULL,'댯굴',0,0,'2017-12-15 13:23:56','2017-12-15 13:23:56'),
(40,25,'user',NULL,'댯굴',0,0,'2017-12-15 13:24:01','2017-12-15 13:24:01');

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
  `selected_answer_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`question_id`),
  KEY `FK_questions_user_id_users_user_id` (`user_id`),
  CONSTRAINT `FK_questions_user_id_users_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

/*Data for the table `questions` */

insert  into `questions`(`question_id`,`user_id`,`category`,`title`,`content`,`view`,`create_date`,`modify_date`,`tags`,`selected_answer_id`) values 
(29,'nayeon','교육/놀이','어린이집 교사, 아동학학사취득?','체육전공 4넌대 졸업한 주부 입니다.\n아이도 있고 아이들을 좋아합니다. 관련전공을 졸업하진 않았지만\n어린이집 교사가 시험을 보고 싶은데 아동학사취득 하려면\n타전공 학사과정으로 아동학 학사취득을 해야한드는데( 4년대졸업자는 48학점 이수 (1학기)) 어떤 방법으로 이루어 지는지\n알고 싶습니다. 홍보는 무시 하게씁니다.',4,'2017-12-15 08:46:10','2017-12-15 08:46:10','아동학학사/어린이집교사',0),
(30,'nayeon','교육/놀이','명절에 주로 했던 놀이','안녕하세요?!\n\n저는 초등학교 4학년인데요~\n\n학교에서 명절에 주로 했던 놀이 3가지를 알아오라고 하는데,,,\n\n3가지로2줄씩 요약 해주실수 있는 분.....?',2,'2017-12-15 08:51:58','2017-12-15 08:51:58','',0),
(31,'nayeon','육아/건강','애기 배꼽 봐주세요ㅠ','배꼽탈장인가 싶어서 소아과갔더니 만져보니 딱딱하다하네요\n탈장은 아니라하고 큰병원가보라고하는데\n육아종이라는건가요?\n수술해야할까요? ㅠ\n이제30개월 애기인데 걱정됩니다',3,'2017-12-15 08:53:49','2017-12-15 08:53:49','육아종/배꼽탈장/배꼽',0),
(32,'nayeon','육아/건강','애기 감기약 과다복용','애가 잠깐 한눈 파는 사이에 4일치 받아온 감기약을 다 먹어버렸는데 무슨 문제가 있을까요 애기는 30개월정도 됐습니다',4,'2017-12-15 08:54:15','2017-12-15 08:54:15','',0),
(33,'momo','음식','6개월아기 음식','6개월아기한테 당근이나 오이같은거 잇몸자극용으로 물려줘도 되나요??? 이유식은 시작했는데 아직 접해보진 않은 채소들이라.. ㅜㅜㅜ 그리고 촉감놀이는 언제부터 가능한가요 미역이나 국수같은것도 아직 안접해봣아요~',3,'2017-12-14 09:02:53','2017-12-15 09:02:53','아기/음식',0),
(34,'momo','음식','11개월아기음식','제친조카가 11개월인데\n다사주고싶을만큼이쁜데\n장이 약해서 자주뭉쳐요 뭘먹여두되나요\n뭐과일이나음식뭐먹여두되요?',4,'2017-12-15 09:03:41','2017-12-15 09:03:41','조카/11개월',0),
(35,'momo','음식','모유수유에좋은음식 아기한테 좋은거?!!','아가랑 저한테도 좋은거 좀 챙겨먹으려는데\n모유수유에좋은음식 뭐가 있을까요??\n모유기간 중인데 머리가 빠져요 ㅜㅜ.. 뭔가 영양분이 없어서\n빠지는건가 싶기도 한데 제일 신경쓰이는건\n우리 아기한테 건강한 영양분이 가지 못할까봐 젤 걱정되네요ㅜㅜ..\n요새들어 피곤하고 기력도 없고ㅜ...\n집안일 육아에 수유까지 하려니 모유수유에좋은음식이라고 \n뭘 잘 챙겨먹기도 어렵고 다른분들은 어떻게 하시는지..\n돌 까지 먹여서 완모하고 싶은데 아기한테도 도움되고 \n저한테도 도움되는 모유수유에좋은음식 뭐 없을까요?! ㅜㅜ',4,'2017-12-13 09:04:11','2017-12-15 09:04:11','',0),
(36,'momo','교육/놀이','아이가 장난감을 쌓아놔요','35개월된 남자아이로 장난감을 산처럼 쌓아놓곤 합니다. 신발도 소복히 산 모양으로 쌓아놓고, 장난감 자동차등은 나란히 나열합니다. 아이의 놀이에 문제가 있나요? 있다면 어떻게 도움을 줄 수 있나요?',4,'2017-12-15 09:05:12','2017-12-15 09:05:12','35개월/남아',0),
(37,'sana','교육/놀이','혼낼 때 더 화나게 하는 아이','우리 반에서 가장 나이가 많고 똑똑한 아이가 있는데 이 아이 가정이 기초수급자여서 동정심이 발생 되고 해서 불쌍히 여기게 되어 잘못을 저질러도 왠만한건 좋게좋게 부드러운 투로 잠깐씩 혼내거나 그냥 넘기기도 하는데 오늘 이 아이가 점심시간에 밥 먹고 식판 버리러 가는 도중 이 아이의 부주의로\n\n한 아이와 부딪혀 그 아이는 다행히도 넘어지진 않았고 그냥 남은 국물이 쏟아지면서 옷에 묻었는데 제가 이 아이에게 미안하다 라고 말하고 국물에 엉망이 된 바닥을 닦으라고 했는데 이 아이가 하는 말이 \"제가 왜 해야 되죠?\" 라고 해서 순간 욱 했지만 참고 해야 하는 이유를 말해주고 다시 닦으라는 지시를 내리고 이 아이가 대충 닦고 마지막으로 다음에 주의하라는 언어지도를 하면서 혼내고 있는데\n\n갑자기 이 아이가 혼나면서도 \'크큭~\' 소리를 내며 마치 제 말이 우습게 들린다는 듯이 비웃고 있더라구요..-_-\n\n순간 화나서 그래도 이성의 끈은 잡고 너 지금 혼나는게 웃기냐고 말을 해줬더니 더 크게 웃어서 순간의 이성의 끈을 놓게 되고 저도 모르게 이 아이를 벽에 밀어 부치고 아이는 차마 때리진 못하겠고 벽을 때렸는데 다른 반 아이들이 그걸 쳐다보는데 좀 민망하기는 하더라구요...동시에 화도 많이 나고요..\n\n이 아이가 나이는 어려도 얼마나 얍삽하고 똑똑하냐면 한번은 지하철 타고 외부활동 중 분명 교사 옆에 붙어 있었는데 어느샌가 근처에 스타킹 신고 짧은 치마 입은 다른 여성 치마를 들추는데 그 실행 시간이 몇초도 안 걸렸고..그래놓고선 올렸어? 안올렸어? 라고 혼내듯이 이야기 해도 거짓말하고.. 반대로 부드럽게 혼내는게 아니니깐 이야기 해볼래? 라고 해도 눈치는 있어서 안 올렸다는 거짓말 하고..\n\n그래도 평소 자기를 무섭게 대하는 남교사는 무섭다는걸 인지 하고 그 남교사 앞에선 말 잘 듣는 아이처럼 있다가 그 남교사 없는 데서는 언제 말 잘들었냐는 듯이 수업 집중도 안될 정도로 자기는 어제 뭐했고 오늘 누가 데리러 오고...엄청 떠들어댑니다..조용히 하라해도 그것도 몇초뿐..ㅡㅡ 그 몇초 지나면 다시 떠들고..\n\n우리 원 밖 현관이 비밀번호 눌러야 열리는 자동문인데 어차피 평소엔 비밀번호를 모르니 나가지는 못하지만 누군가 나가려는 기미가 보이면 현관문 옆에 따로 방이 있는데 그 방에 있다가 누군가 현관문 열고 나가면 잽싸게 자동문 완전히 닫히기 전에 나간 적도 여러 번 있었네요..-_-\n\n그래서 이러이러해서 그냥.... \n\n오늘인 만큼은 진짜...아직까지 분이 안 풀리네요.ㅠㅠ\n\n이 아이를 어찌 다뤄야 좋을지 모르겠어요.ㅠㅠ\n\n이 아이 엄마는 성적행동에 대해선 엄마랑 같이 있어도 지나가는 여자 다리도 만진다고 자랑하듯 이야기 하는 엄마라 대화도 안 통하고ㅠㅠ\n\n혼날 때 비웃는건 제 입장에서 굉장히 심각한건데 제3자 이상인 사람들 눈으론 아무것도 아닌 일이라 이걸 아이들을 무척 사랑하는 원장한테 말해도 괜히 혼나는건 오히려 나니...진짜 미쳐버릴꺼 같네요.ㅠㅠ\n',8,'2017-12-15 09:26:40','2017-12-15 09:26:40','',0),
(38,'chaeyoung','교육/놀이','두살 아이 교재 교구 어떤게 좋나요?','7월 23일부터 부산에서 유아교육전이 열린다고 해서요.\n\n아이 데리고 가볼까 해요. 블록이나 장난감류는 많은데, 아직 교구랑 책이 별로 없어요.\n\n사실 첫애 때 쓰던 애플비 전집이 다 인데..그마저도 헤져서 버린 책이 더 많구요.\n\n돌 전후로 해서 어떤 교재 교구가 좋을까요?\n\n원목교구가 나을지..아니면 또 좋은 교구가 있는지 궁금해요.\n\n부산 유아교육전에 들어 오는 교재 교구 중 추천해주실만한 제품들 있을까요?\n저번에도 사야지하면서 갔다가 그냥 돌아 왔거든요...ㅠㅠ\n\n이번에는 둘째에게 선물해주고픈데, 어떤게 좋은지 모르겠어요.',8,'2017-12-15 09:28:31','2017-12-15 09:28:31','',0),
(39,'chaeyoung','안전','아기 안전문 사려고 하는데 어떤것이 좋은가요?','저희 아기가 열심히 기어다니는 중인데\n\n자꾸 현관이나 화장실로 가려고 하더라구요\n\n그래서 안전문을 설치하면 편하다는 주변 분들의 말씀이 있어서\n\n이번에 사려고하는데 좋은 안전문 추천 좀 해주세요^^',15,'2017-12-15 09:29:05','2017-12-15 09:29:05','/안전문',0),
(40,'dahyun','안전','불만제로 아기로션 안전한거 좀','안녕하세요 불만제로 아기로션 뭐가 있나요\n안전한 불만제로 아기로션 좀 가르쳐주세요 우리 애기 만큼은 정말 깔끔하고 좋은거 쓰게 해주고싶어요\n불만제로 아기로션 아시는 분 꼭좀 부탁드릴게요 감사합니다',16,'2017-12-15 09:34:33','2017-12-15 09:34:33','아기/로션',0),
(41,'jihyo','기타','미대 정시 지금부터 하면 많이 늦나요','수시 6개 광탈하고 삶의 희망을 잃었습니다..ㅜㅜ\n정시 37244 나왔는데 두달동안 학원 다니고 실기반영비 낮은 대학 노려서 대학붙을 확률은 없을까요???ㅠㅠㅠ저도 택도 없는 소리하는 거 알아요 예체능 얕보는 것도 아니구요 그냥 너무 절박해서 질문남깁니다...ㅜㅜ',29,'2017-12-15 09:51:04','2017-12-15 09:51:04','',0);

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
('chaeyoung','채영','$2y$10$3nohkNsvu7hd4qiDRq0taeDDPgE7RXSx0PoPjP71xikn8e9WvkKoS','일반','chaeyoung@kidkids.net','f9b902fc3289af4dd08de5d1de54f68f',0),
('dahyun','다현','$2y$10$PvlZ7oq7ZhMlZzX2p4RwauPtn1GN9tB.2448XT3hpKIW6SULTgMHe','일반','dahyun@kidkids.net','e97ee2054defb209c35fe4dc94599061',0),
('jeongyeon','정연','$2y$10$TcJfNG/sINN0xV6Azto9K.x0k8ZgVVnacZQNwt6ccApL3pYBm1lj.','일반','jeongyeon@kidkids.net','da4fb5c6e93e74d3df8527599fa62642',0),
('jihyo','지효','$2y$10$0MtH3Kssi/c.j6hX8/94CuzFf9abbGjoiiDLdP9OJ0xHW21ecJTPO','전문가','jihyo@kidkids.net','6ea9ab1baa0efb9e19094440c317e21b',0),
('mina','미나','$2y$10$9w3KmGazjE377M9G4CDTYuMGlA41j/SgZ44ZuE.GWA9NKwC.Vd5/.','일반','mina@kidkids.net','31839b036f63806cba3f47b93af8ccb5',0),
('momo','모모','$2y$10$iOYIbp4.5MeJb0dQj9EDBedWkNrzjZ2.f763g6LOvKBtTY69Eu.vq','전문가','momo@kidkids.net','69adc1e107f7f7d035d7baf04342e1ca',0),
('nayeon','나연','$2y$10$2kiR.iBQ0jc7jDb.9vDDTuMYWDyLukGNfxRIyo4bY/HeddfXIp/A.','일반','nayeon@kidkids.net','01f78be6f7cad02658508fe4616098a9',0),
('sana','사나','$2y$10$r29dBL2TAEhMyMxURnL5ae1cdwr5PKDDGIl85DZ3hAwuhzXbeD/Yi','전문가','sana@kidkids.net','fe8c15fed5f808006ce95eddb7366e35',0),
('tzuyu','쯔위','$2y$10$DkumTGjfOH/TPHkjjonINOl9SVWpgyNPAhsRENnj.dzng4mUr2lk6','일반','tzuyu@kidkids.net','edfbe1afcf9246bb0d40eb4d8027d90f',0),
('user','쥰욜','$2y$10$GIjDiHGSWu9A5Yk8w4QhGu5MKiGldoZxVjTHstYewkynAG6G1cbZm','일반','user@naver.com','51ef186e18dc00c2d31982567235c559',0);

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
(45,'jeongyeon',1),
(46,'momo',1),
(46,'nayeon',1),
(46,'sana',1),
(47,'momo',-1),
(47,'nayeon',-1),
(47,'sana',1),
(48,'jeongyeon',1),
(48,'jihyo',1),
(49,'sana',1),
(50,'sana',-1),
(51,'sana',1),
(51,'user',1),
(52,'jeongyeon',1),
(52,'momo',1),
(52,'user',1),
(55,'momo',1),
(55,'nayeon',-1),
(56,'momo',-1),
(56,'user',1),
(60,'user',-1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
