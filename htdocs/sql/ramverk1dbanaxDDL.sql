-- show databases;
-- CREATE DATABASE ramverk1dbanax CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use ramverk1dbanax;


-- DROP TABLE IF EXISTS RVDBaccounts;
CREATE TABLE IF NOT EXISTS RVDBaccounts 
(
id int(5) auto_increment primary key,
active char(5) default 'yes',
role char(20) default 'user',
username varchar(20) not null unique,
pass char(100) not null,
firstname char(20) default 'anon',
surname char(20) default 'anon',
email varchar(50) default 'anon',
created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated TIMESTAMP NULL,
deleted TIMESTAMP NULL
) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;



DROP TABLE IF EXISTS RVDBbook;
CREATE TABLE IF NOT EXISTS RVDBbook (
    id INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    title VARCHAR(256) NOT NULL,
    author VARCHAR(256) NOT NULL,
    publisher VARCHAR(256),
    categories VARCHAR(256)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
