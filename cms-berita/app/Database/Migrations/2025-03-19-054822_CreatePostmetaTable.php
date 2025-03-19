<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostmetaTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_postmeta (
        //     meta_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     post_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     meta_key VARCHAR(255) DEFAULT NULL,
        //     meta_value LONGTEXT DEFAULT NULL,
        //     PRIMARY KEY (meta_id),
        //     KEY post_id (post_id),
        //     KEY meta_key (meta_key)
        // );

        $this->forge->addField([
            'meta_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'post_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'meta_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => null,
            ],
            'meta_value' => [
                'type' => 'LONGTEXT',
                'default' => null,
            ],
        ]);
        $this->forge->addPrimaryKey('meta_id');
        $this->forge->addKey('post_id');
        $this->forge->addKey('meta_key');
        $this->forge->createTable('wp_postmeta', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('wp_postmeta');
    }
}
