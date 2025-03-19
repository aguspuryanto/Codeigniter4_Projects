<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_posts (
        //     ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     post_author BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     post_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     post_date_gmt DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     post_content LONGTEXT NOT NULL,
        //     post_title TEXT NOT NULL,
        //     post_excerpt TEXT NOT NULL,
        //     post_status VARCHAR(20) NOT NULL DEFAULT 'publish',
        //     comment_status VARCHAR(20) NOT NULL DEFAULT 'open',
        //     ping_status VARCHAR(20) NOT NULL DEFAULT 'open',
        //     post_password VARCHAR(255) NOT NULL DEFAULT '',
        //     post_name VARCHAR(200) NOT NULL DEFAULT '',
        //     to_ping TEXT NOT NULL,
        //     pinged TEXT NOT NULL,
        //     post_modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     post_modified_gmt DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
        //     post_content_filtered LONGTEXT NOT NULL,
        //     post_parent BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     guid VARCHAR(255) NOT NULL DEFAULT '',
        //     menu_order INT(11) NOT NULL DEFAULT '0',
        //     post_type VARCHAR(20) NOT NULL DEFAULT 'post',
        //     post_mime_type VARCHAR(100) NOT NULL DEFAULT '',
        //     comment_count BIGINT(20) NOT NULL DEFAULT '0',
        //     PRIMARY KEY (ID)
        // );

        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'post_author' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'default' => 0,
            ],
            'post_date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'post_content' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'post_title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'post_status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'publish',
            ],
            'post_name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => false,
            ],
            'post_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'post',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('wp_posts', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('wp_posts');
    }
}
