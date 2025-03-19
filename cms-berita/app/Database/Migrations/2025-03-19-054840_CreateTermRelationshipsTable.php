<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTermRelationshipsTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_term_relationships (
        //     object_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     term_taxonomy_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     term_order INT(11) NOT NULL DEFAULT '0',
        //     PRIMARY KEY (object_id, term_taxonomy_id)
        // );

        $this->forge->addField([
            'object_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'term_taxonomy_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'term_order' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
        ]);

        $this->forge->addPrimaryKey('object_id', 'term_taxonomy_id');
        $this->forge->createTable('term_relationships', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('term_relationships');
    }
}
