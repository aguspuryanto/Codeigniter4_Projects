<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_comments (
        //     comment_ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     comment_post_ID BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     comment_author TINYTEXT NOT NULL,
        //     comment_author_email VARCHAR(100) NOT NULL DEFAULT '',
        //     comment_author_url VARCHAR(200) NOT NULL DEFAULT '',
        //     comment_author_IP VARCHAR(100) NOT NULL DEFAULT '',
        //     comment_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     comment_date_gmt DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     comment_content TEXT NOT NULL,
        //     comment_karma INT(11) NOT NULL DEFAULT '0',
        //     comment_approved VARCHAR(20) NOT NULL DEFAULT '1',
        //     comment_agent VARCHAR(255) NOT NULL DEFAULT '',
        //     comment_type VARCHAR(20) NOT NULL DEFAULT '',
        //     comment_parent BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     user_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     PRIMARY KEY (comment_ID)
        // );

        $this->forge->addField([
            'comment_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'comment_post_ID' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'comment_author' => [
                'type' => 'TINYTEXT',
                'default' => '',
            ],
            'comment_author_email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => '',
            ],
            'comment_author_url' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'default' => '',
            ],
            'comment_author_IP' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => '',
            ],
            'comment_date' => [
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00',
            ],
            'comment_date_gmt' => [
                'type' => 'DATETIME',
                'default' => '0000-00-00 00:00:00',
            ],
            'comment_content' => [
                'type' => 'TEXT',
                'default' => '',
            ],
            'comment_karma' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'comment_approved' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => '1',
            ],
            'comment_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => '',
            ],
            'comment_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => '',
            ],
            'comment_parent' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('comment_ID');
        $this->forge->createTable('comments', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('comments');
    }
}
