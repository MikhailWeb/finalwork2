<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Base\Db;

try {
    $drop_table = "DROP TABLE IF EXISTS testdb.users;";
    Db::getInstance()->exec($drop_table);

    $create_table = "CREATE TABLE testdb.users (
                          id int(11) NOT NULL AUTO_INCREMENT,
                          username varchar(100) NOT NULL,
                          birthday date NOT NULL,
                          email varchar(50) NOT NULL,
                          password varchar(50) NOT NULL,
                          avatar int(11) NOT NULL DEFAULT 0,
                          updated_at datetime DEFAULT NULL,
                          created_at datetime DEFAULT NULL,
                          PRIMARY KEY (id),
                          UNIQUE INDEX users_email_uindex (email)
                        )
                        ENGINE = INNODB
                        AUTO_INCREMENT = 22
                        AVG_ROW_LENGTH = 1638
                        CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci
                        ROW_FORMAT = DYNAMIC;";
    $result = Db::getInstance()->exec($create_table);
    if ($result !== false) echo "Таблица users создана\n";

    $drop_table = "DROP TABLE IF EXISTS testdb.files;";
    Db::getInstance()->exec($drop_table);

    $create_table = "CREATE TABLE testdb.files (
                          id int(11) NOT NULL AUTO_INCREMENT,
                          user_id int(11) DEFAULT 0,
                          filename varchar(100) NOT NULL,
                          size int(11) DEFAULT 0,
                          created_at datetime DEFAULT NULL,
                          updated_at datetime DEFAULT NULL,
                          PRIMARY KEY (id)
                        )
                        ENGINE = INNODB
                        AUTO_INCREMENT = 9
                        AVG_ROW_LENGTH = 2730
                        CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci
                        ROW_FORMAT = DYNAMIC;";
    $result = Db::getInstance()->exec($create_table);
    if ($result !== false) echo "Таблица files создана\n";
    echo "Миграции прошли успешно\n";
} catch (\Exception $exception) {
    echo "Ошибка при миграции. {$exception->getMessage()}\n";
}
