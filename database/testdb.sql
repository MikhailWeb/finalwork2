--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.2.280.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 26.03.2020 5:06:02
-- Версия сервера: 5.5.5-10.3.13-MariaDB-log
-- Версия клиента: 4.1
--


--
-- Описание для базы данных testdb
--
DROP DATABASE IF EXISTS testdb;
CREATE DATABASE testdb
	CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE testdb;

--
-- Описание для таблицы files
--
CREATE TABLE files (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT 0,
  filename VARCHAR(100) NOT NULL,
  size INT(11) DEFAULT 0,
  created_at DATETIME DEFAULT 'NULL',
  updated_at DATETIME DEFAULT 'NULL',
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 14
AVG_ROW_LENGTH = 2340
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ROW_FORMAT = DYNAMIC;

--
-- Описание для таблицы users
--
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  birthday DATE NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) DEFAULT '''NULL''',
  avatar INT(11) NOT NULL DEFAULT 0,
  updated_at DATETIME DEFAULT 'NULL',
  created_at DATETIME DEFAULT 'NULL',
  PRIMARY KEY (id),
  UNIQUE INDEX users_email_uindex (email)
)
ENGINE = INNODB
AUTO_INCREMENT = 26
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ROW_FORMAT = DYNAMIC;

-- 
-- Вывод данных для таблицы files
--
INSERT INTO files VALUES
(1, 1, '0.PNG', 14799, '2020-03-14 03:30:15', NULL),
(2, 1, '1.PNG', 13478, '2020-03-14 03:30:24', NULL),
(3, 1, '2.PNG', 14980, '2020-03-14 03:30:34', NULL),
(4, 2, '3.PNG', 15479, '2020-03-14 03:32:55', NULL),
(5, 2, '4.PNG', 13896, '2020-03-14 03:33:04', NULL),
(8, 3, '2.PNG', 14980, '2020-03-24 00:24:10', NULL),
(13, 1, '3.PNG', 15479, '2020-03-25 15:58:49', '2020-03-25 15:58:49');

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(1, 'Ivanov Ivan', '2000-03-02', 'ivanov@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, '2020-03-25 23:59:37', NULL),
(2, 'Petrova Anna', '1997-11-10', 'petrova@mail.ru', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 4, '2020-03-26 01:04:56', NULL),
(3, 'Sidorov Sergey', '2005-05-20', 'sidorov@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 8, '2020-03-25 03:41:51', NULL),
(4, 'Pushkin Alexandr', '2000-02-10', 'pushkin@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, '2020-03-25 03:41:51', NULL);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;