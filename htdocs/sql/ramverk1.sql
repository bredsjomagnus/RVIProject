-- CREATE DATABASE ramverk1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- show databases;
use ramverk1;
-- show tables;

DROP TABLE IF EXISTS ramverk1comments;
-- DROP TABLE IF EXISTS ramverk1accounts;

CREATE TABLE IF NOT EXISTS ramverk1comments (
     id INT AUTO_INCREMENT NOT NULL,
     comment_on INT,
     created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     edited TIMESTAMP NULL,
     username varchar(100) NOT NULL default 'NA',
     email VARCHAR(200) NOT NULL DEFAULT 'na@email.com',
     comm VARCHAR(100000),
     likes VARCHAR(1000) DEFAULT '',
      PRIMARY KEY  (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  
-- ALTER TABLE ramverk1comments
-- ADD COLUMN comment_on INT AFTER id;
  
CREATE TABLE IF NOT EXISTS ramverk1accounts 
(
id int(5) auto_increment primary key,
active char(5) default 'yes',
role char(20) not null,
username varchar(20) not null unique,
pass char(100) not null,
forname char(20) not null,
surname char(20) not null,
email varchar(50) not null,
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


--
-- Create table for Content
--
-- DROP TABLE IF EXISTS RV1content;
CREATE TABLE IF NOT EXISTS RV1content
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  path CHAR(120) UNIQUE,
  slug CHAR(120) NOT NULL UNIQUE,
  title VARCHAR(120),
  `data` TEXT,
  `type` CHAR(20),
  filter VARCHAR(80) DEFAULT NULL,
  `status` CHAR(20) DEFAULT 'notPublished',

  -- MySQL version 5.6 and higher
  -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 
  -- MySQL version 5.5 and lower
  published DATETIME DEFAULT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated TIMESTAMP NULL, --  ON UPDATE CURRENT_TIMESTAMP,
  deleted TIMESTAMP NULL

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

CREATE TABLE IF NOT EXISTS RV1article
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  path CHAR(120) UNIQUE,
  slug CHAR(120) NOT NULL UNIQUE,
  title VARCHAR(120),
  `data` TEXT,
  `type` CHAR(20),
  filter VARCHAR(80) DEFAULT NULL,
  `status` CHAR(20) DEFAULT 'notPublished',

  -- MySQL version 5.6 and higher
  -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
  -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
 
  -- MySQL version 5.5 and lower
  published DATETIME DEFAULT NULL,
  created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated TIMESTAMP NULL, --  ON UPDATE CURRENT_TIMESTAMP,
  deleted TIMESTAMP NULL

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

-- DROP TABLE IF EXISTS RVDBbook;
CREATE TABLE IF NOT EXISTS RVDBbook (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    title VARCHAR(256) NOT NULL,
    author VARCHAR(256) NOT NULL,
    publisher VARCHAR(256),
    categories VARCHAR(256)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


-- INSERT INTO ramverkcomments (user, comm) VALUES ('Janne Banan', 'åäö rules');

SELECT * FROM ramverk1accounts;
SELECT * FROM RVDBbook;
SELECT * FROM RV1content;

DELETE FROM ramverk1comments WHERE username = 'user';
SELECT * FROM ramverk1comments;

SELECT * FROM ramverk1comments WHERE comment_on = 2 ORDER BY created DESC;
  -- UPDATE ramverk1accounts SET active = 'yes' WHERE id = 1;
-- UPDATE ramverk1accounts SET role = 'admin' WHERE id = 1;

-- ALTER TABLE ramverk1accounts
-- ADD COLUMN address varchar(100) AFTER surname,
-- ADD COLUMN postnumber varchar(50) AFTER email,
-- ADD COLUMN phone varchar(50) AFTER postnumber,
-- ADD COLUMN mobile varchar(50) AFTER phone,
-- ADD COLUMN city varchar(100) AFTER mobile,
-- ADD COLUMN inlogged TIMESTAMP NULL AFTER city,
-- ADD COLUMN notes varchar(10000) AFTER inlogged;

-- CREATE TABLE IF NOT EXISTS smarisaccounts 
-- (
-- id int(5) auto_increment primary key,
-- active char(5) default 'yes',
-- role char(20) not null,
-- username varchar(20) not null unique,
-- pass char(100) not null,
-- firstname char(20) not null,
-- surname char(20) not null,
-- address varchar(100),
-- email varchar(50) not null unique,
-- postnumber varchar(50),
-- phone varchar(50),
-- mobile varchar(50),
-- city varchar(100),
-- inlogged TIMESTAMP NULL,
-- notes varchar(10000),
-- created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
-- ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;