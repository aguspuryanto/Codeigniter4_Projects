<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsermetaTable extends Migration
{
    public function up()
    {
        //CREATE TABLE wp_usermeta (
        //     umeta_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     user_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     meta_key VARCHAR(255) DEFAULT NULL,
        //     meta_value LONGTEXT DEFAULT NULL,
        //     PRIMARY KEY (umeta_id),
        //     KEY user_id (user_id),
        //     KEY meta_key (meta_key)
        // );

        $this->forge->addField([
            'umeta_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
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
        $this->forge->addPrimaryKey('umeta_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('meta_key');
        $this->forge->createTable('usermeta', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('usermeta');
    }
}
