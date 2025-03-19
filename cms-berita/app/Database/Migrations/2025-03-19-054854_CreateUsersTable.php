<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_users (
        //     ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     user_login VARCHAR(60) NOT NULL DEFAULT '',
        //     user_pass VARCHAR(255) NOT NULL DEFAULT '',
        //     user_nicename VARCHAR(50) NOT NULL DEFAULT '',
        //     user_email VARCHAR(100) NOT NULL DEFAULT '',
        //     user_url VARCHAR(100) NOT NULL DEFAULT '',
        //     user_registered DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     user_activation_key VARCHAR(255) NOT NULL DEFAULT '',
        //     user_status INT(11) NOT NULL DEFAULT '0',
        //     display_name VARCHAR(250) NOT NULL DEFAULT '',
        //     PRIMARY KEY (ID),
        //     UNIQUE KEY user_login (user_login)
        // );

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_login' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'default' => '',
            ],
            'user_pass' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'user_nicename' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => '',
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => '',
            ],
            'user_url' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => '',
            ],
            'user_registered' => [
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00',
            ],
            'user_activation_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'user_status' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'display_name' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'default' => '',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('user_login');
        $this->forge->createTable('users', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }
    public function down()
    {
        $this->forge->dropTable('users');
    }
}
