<?php

use app\core\Application;

/**
 * Class m0001_users
 */
class m0001_users
{
    public function up()
    {
        Application::$app->db->query("CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(16) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL
            )  ENGINE=INNODB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        Application::$app->db->query("DROP TABLE users;");
    }
}