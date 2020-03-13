--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.2.280.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 14.03.2020 3:50:42
-- Версия сервера: 5.5.5-10.3.13-MariaDB-log
-- Версия клиента: 4.1
--



-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


CREATE DATABASE testdb
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

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
DROP TABLE IF EXISTS files;
CREATE TABLE files (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) DEFAULT 0,
  filename VARCHAR(100) NOT NULL,
  size INT(11) DEFAULT 0,
  dt_create DATETIME DEFAULT current_timestamp(),
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 6
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ROW_FORMAT = DYNAMIC;

--
-- Описание для таблицы users
--
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  birthday DATE NOT NULL,
  email VARCHAR(50) NOT NULL,
  pass VARCHAR(50) DEFAULT 'NULL',
  avatar INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE INDEX users_email_uindex (email)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci
ROW_FORMAT = DYNAMIC;

-- 
-- Вывод данных для таблицы files
--
INSERT INTO files VALUES
(1, 1, '0.PNG', 14799, '2020-03-14 03:30:15'),
(2, 1, '1.PNG', 13478, '2020-03-14 03:30:24'),
(3, 1, '2.PNG', 14980, '2020-03-14 03:30:34'),
(4, 2, '3.PNG', 15479, '2020-03-14 03:32:55'),
(5, 2, '4.PNG', 13896, '2020-03-14 03:33:04');

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(1, 'Ivanov Ivan', '2000-03-02', 'ivanov@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3),
(2, 'Petrova Anna', '1995-11-10', 'petrova@mail.ru', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2', 4),
(3, 'Sidorov Sergey', '2005-05-20', 'sidorov@mail.ru', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;