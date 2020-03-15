<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Base\Db;

try {
    $create_table = "CREATE TABLE IF NOT EXISTS users (
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
                        ROW_FORMAT = DYNAMIC;";
    $result = Db::getInstance()->exec($create_table);
    if ($result !== false) echo "Таблица users создана\n";

    $create_table = "CREATE TABLE IF NOT EXISTS files (
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
                        ROW_FORMAT = DYNAMIC;";
    $result = Db::getInstance()->exec($create_table);
    if ($result !== false) echo "Таблица files создана\n";
    echo "Миграции прошли успешно\n";
} catch (\Exception $exception) {
    echo "Ошибка при миграции. {$exception->getMessage()}\n";
}
