-- REFRESH TABLES
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS db_local.chapter_votes;
DROP TABLE IF EXISTS db_local.offered_chapters;
DROP TABLE IF EXISTS db_local.chapter_comments;
DROP TABLE IF EXISTS db_local.novel_chapters;
DROP TABLE IF EXISTS db_local.user_favorites;
DROP TABLE IF EXISTS db_local.novels;
DROP TABLE IF EXISTS db_local.users;
SET FOREIGN_KEY_CHECKS = 1;

-- CREATE TABLES
CREATE TABLE db_local.users (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'ユーザー名',
  `email` varchar(100) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(200) NOT NULL COMMENT 'ログイン時のパスワード',
  `user_type` tinyint(4) NOT NULL COMMENT '0:仮登録 1:一般 2:管理者',
  `password_reset_token` varchar(200) DEFAULT NULL COMMENT 'パスワード再設定時とユーザー登録の際に使う',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE db_local.novels (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーid照会',
  `novel_title` varchar(100) NOT NULL COMMENT '小説のタイトル',
  `summery` varchar(1000) NOT NULL COMMENT '小説の概要',
  `category` varchar(100) DEFAULT NULL COMMENT '小説のカテゴリー',
  `favorite_count` int(11) NOT NULL DEFAULT '0' COMMENT 'お気に入り登録の人数',
  `last_chapter` int(11) NOT NULL DEFAULT '1' COMMENT '最終話数',
  `deadline_date` date NOT NULL DEFAULT '9999-12-31' COMMENT '投稿・投票締め切り日',
  PRIMARY KEY (`id`),
  KEY `novels_FK` (`user_id`),
  CONSTRAINT `novels_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


CREATE TABLE db_local.user_favorites (
  `user_id` int(11) NOT NULL COMMENT 'user_id',
  `novel_id` int(11) NOT NULL COMMENT 'ノベルid',
  PRIMARY KEY (`user_id`,`novel_id`),
  KEY `user_favorites_FK` (`novel_id`),
  CONSTRAINT `user_favorites_FK` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_favorites_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE db_local.novel_chapters (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `novel_id` int(11) NOT NULL COMMENT 'novelsテーブル照会',
  `chapter_title` varchar(100) NOT NULL COMMENT 'チャプターのタイトル',
  `chapter_number` int(11) NOT NULL COMMENT '小説の話数',
  `body` varchar(10000) NOT NULL COMMENT '小説の本文',
  `writer` varchar(100) NOT NULL COMMENT '小説の作者',
  `created_at` datetime NOT NULL COMMENT '投稿日時',
  `updated_at` datetime NOT NULL COMMENT '編集日時',
  PRIMARY KEY (`id`),
  KEY `novel_chapters_FK` (`novel_id`),
  CONSTRAINT `novel_chapters_FK` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE db_local.chapter_comments (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `chapter_id` int(11) NOT NULL,
  `comment_name` varchar(100) DEFAULT '通りすがりの佐々木さん' COMMENT 'コメント名',
  `comment` varchar(1000) NOT NULL COMMENT 'コメント本文',
  `comment_datetime` datetime NOT NULL COMMENT 'コメントした日時',
  PRIMARY KEY (`id`),
  KEY `chapter_comments_FK` (`chapter_id`),
  CONSTRAINT `chapter_comments_FK` FOREIGN KEY (`chapter_id`) REFERENCES `novel_chapters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE db_local.offered_chapters (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `novel_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `offered_chapters_FK` (`novel_id`),
  KEY `offered_chapters_FK_1` (`user_id`),
  CONSTRAINT `offered_chapters_FK` FOREIGN KEY (`novel_id`) REFERENCES `novels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `offered_chapters_FK_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE db_local.chapter_votes (
  `user_id` int(11) NOT NULL,
  `offered_chapter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `chapter_votes_FK_1` (`offered_chapter_id`),
  CONSTRAINT `chapter_votes_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chapter_votes_FK_1` FOREIGN KEY (`offered_chapter_id`) REFERENCES `offered_chapters` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- SEEDING
INSERT INTO db_local.users ( name, email, password, user_type, password_reset_token ) 
	VALUES ('HARUKI', 'haruki20211121@gmail.com', 'error', 2, 'error');

INSERT INTO db_local.novels ( user_id, novel_title, summery, category, favorite_count ) 
	VALUES (1, '春木太一の憂鬱', '完結していません。', '学園SF', 100);