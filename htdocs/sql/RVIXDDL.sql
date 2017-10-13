-- CREATE DATABASE RVIProject CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use RVIProject;

DROP TABLE IF EXISTS RVIXanswer;
-- DROP TABLE IF EXISTS RVIXarticle;

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
     likes VARCHAR(1000) DEFAULT '',
	 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
     updated TIMESTAMP NULL,
     deleted TIMESTAMP NULL,
     
     PRIMARY KEY  (id),
     FOREIGN KEY (answerto) REFERENCES RVIXarticle (id),
     FOREIGN KEY (user) REFERENCES RVIXaccount (id)
  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;