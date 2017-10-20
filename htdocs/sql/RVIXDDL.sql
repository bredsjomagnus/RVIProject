-- CREATE DATABASE RVIProject CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- use RVIProject;
use maaa16;

SET NAMES utf8mb4;

DROP VIEW IF EXISTS RVIXarticleView;
DROP VIEW IF EXISTS RVIXanswerSumView;
DROP VIEW IF EXISTS RVIXanswerView;

-- DROP TABLE IF EXISTS RVIXarticlecommentvotes;
-- DROP TABLE IF EXISTS RVIXarticlevotes;
-- DROP TABLE IF EXISTS RVIXanswercommentvotes;
-- DROP TABLE IF EXISTS RVIXanswervotes;
-- DROP TABLE IF EXISTS RVIXarticlecomment;
-- DROP TABLE IF EXISTS RVIXanswercomment;
-- DROP TABLE IF EXISTS RVIXanswer;
-- DROP TABLE IF EXISTS RVIXarticle;
-- DROP TABLE IF EXISTS RVIXtags;

-- DROP TABLE IF EXISTS RVIXaccount;

CREATE TABLE IF NOT EXISTS RVIXaccount 
(
	id int(5) auto_increment primary key,
	active char(5) default 'yes',
	role char(20) not null,
	rank VARCHAR(100) DEFAULT 'novice',
	username varchar(20) not null unique,
	pass char(100) not null,
	firstname char(20) not null,
	surname char(20) not null,
	address varchar(100),
	email varchar(50) default null unique,
	postnumber varchar(50),
	phone varchar(50),
	mobile varchar(50),
	city varchar(100),
	inlogged TIMESTAMP NULL,
	notes varchar(10000),
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated TIMESTAMP NULL,
	deleted TIMESTAMP NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS RVIXarticle
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  user INT,
  path VARCHAR(120) UNIQUE,
  slug VARCHAR(120) NOT NULL UNIQUE,
  tags VARCHAR(100),
  tagpaths VARCHAR(100),
  title VARCHAR(120),
  `data` TEXT,
  `type` VARCHAR(20),
  filter VARCHAR(80) DEFAULT NULL,
  `status` CHAR(20) DEFAULT 'published',
  published DATETIME DEFAULT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated TIMESTAMP NULL, --  ON UPDATE CURRENT_TIMESTAMP,
  deleted TIMESTAMP NULL,

  FOREIGN KEY (user) REFERENCES RVIXaccount (id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

CREATE TABLE IF NOT EXISTS RVIXanswer (
     id INT AUTO_INCREMENT NOT NULL,
     answerto INT,
     user INT,
     `data` TEXT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (answerto) REFERENCES RVIXarticle (id),
     FOREIGN KEY (user) REFERENCES RVIXaccount (id)
  ) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
  
  CREATE TABLE IF NOT EXISTS RVIXarticlecomment (
     id INT AUTO_INCREMENT NOT NULL,
     commentto INT,
     user INT,
     `data` TEXT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (commentto) REFERENCES RVIXarticle (id),
     FOREIGN KEY (user) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
  CREATE TABLE IF NOT EXISTS RVIXanswercomment (
     id INT AUTO_INCREMENT NOT NULL,
     articleid INT,
     commentto INT,
     user INT,
     `data` TEXT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (articleid) REFERENCES RVIXarticle (id),
     FOREIGN KEY (commentto) REFERENCES RVIXanswer (id),
     FOREIGN KEY (user) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
  
    CREATE TABLE IF NOT EXISTS RVIXarticlevotes (
     id INT AUTO_INCREMENT NOT NULL,
     articleid INT,
     authorid INT,
     voterid INT,
     vote INT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (articleid) REFERENCES RVIXarticle (id),
     FOREIGN KEY (authorid) REFERENCES RVIXaccount (id),
     FOREIGN KEY (voterid) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
	CREATE TABLE IF NOT EXISTS RVIXarticlecommentvotes (
     id INT AUTO_INCREMENT NOT NULL,
     articleid INT,
     articlecommentid INT,
     authorid INT,
     voterid INT,
     vote INT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (articleid) REFERENCES RVIXarticle (id),
     FOREIGN KEY (articlecommentid) REFERENCES RVIXarticlecomment (id),
     FOREIGN KEY (authorid) REFERENCES RVIXaccount (id),
     FOREIGN KEY (voterid) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
	CREATE TABLE IF NOT EXISTS RVIXanswervotes (
     id INT AUTO_INCREMENT NOT NULL,
     articleid INT,
     answerid INT,
     authorid INT,
     voterid INT,
     vote INT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (articleid) REFERENCES RVIXarticle (id),
     FOREIGN KEY (answerid) REFERENCES RVIXanswer (id),
     FOREIGN KEY (authorid) REFERENCES RVIXaccount (id),
     FOREIGN KEY (voterid) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
  
	CREATE TABLE IF NOT EXISTS RVIXanswercommentvotes (
     id INT AUTO_INCREMENT NOT NULL,
     articleid INT,
     answerid INT,
     answercommentid INT,
     authorid INT,
     voterid INT,
     vote INT,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (articleid) REFERENCES RVIXarticle (id),
     FOREIGN KEY (answerid) REFERENCES RVIXanswer (id),
     FOREIGN KEY (authorid) REFERENCES RVIXaccount (id),
     FOREIGN KEY (voterid) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
    CREATE TABLE IF NOT EXISTS RVIXtags (
     id INT AUTO_INCREMENT NOT NULL,
     tag VARCHAR(100),
     tagpath VARCHAR(100),
     tagcount INT DEFAULT 1,
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
  
CREATE VIEW RVIXarticleView AS
SELECT
	U.id as userid,
    U.username,
	U.firstname,
    U.surname,
    A.id as articleid,
    A.title,
    A.tags,
    A.tagpaths,
    A.created
FROM RVIXarticle AS A
	INNER JOIN RVIXaccount AS U
		ON A.user = U.id;
        
CREATE VIEW RVIXanswerSumView AS
SELECT
	U.id as userid,
	U.firstname,
    U.surname,
    A.id as articleid,
    A.title,
    COUNT(ANSW.id) as numbanswers
FROM RVIXarticle AS A
	INNER JOIN RVIXaccount AS U
		ON A.user = U.id
	INNER JOIN RVIXanswer AS ANSW
        ON A.id = ANSW.answerto
GROUP BY A.title;

CREATE VIEW RVIXanswerView AS
SELECT
	ANS.id AS answerid,
	ANS.user AS userid,
	U.id as articleuserid,
    U.username,
	U.firstname,
    U.surname,
    AR.id as articleid,
    AR.title,
	ANS.`data`,
    AR.tags,
    AR.tagpaths,
    AR.created
FROM RVIXanswer AS ANS
	INNER JOIN RVIXarticle AS AR
		ON ANS.answerto = AR.id
	INNER JOIN RVIXaccount AS U
        ON AR.user = U.id;
        
-- CREATE VIEW RVIXanswercommentSumView AS
-- SELECT
-- 	U.id as userid,
-- 	U.firstname,
--     U.surname,
--     A.id as articleid,
--     A.title,
--     COUNT(ANSW.id) as numbanswers
-- FROM RVIXanswer AS A
-- 	INNER JOIN RVIXaccount AS U
-- 		ON A.user = U.id
-- 	INNER JOIN RVIXanswercomment AS ANSW
--         ON A.id = ANSW.answerto
-- GROUP BY A.title;