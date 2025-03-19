<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTermTaxonomyTable extends Migration
{
    public function up()
    {
        //CREATE TABLE wp_term_taxonomy (
        //     term_taxonomy_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     term_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     taxonomy VARCHAR(32) NOT NULL DEFAULT '',
        //     description LONGTEXT NOT NULL,
        //     parent BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
        //     count BIGINT(20) NOT NULL DEFAULT '0',
        //     PRIMARY KEY (term_taxonomy_id),
        //     UNIQUE KEY term_id_taxonomy (term_id, taxonomy)
        // );

        $this->forge->addField([
            'term_taxonomy_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'term_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'taxonomy' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'default' => '',
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'default' => '',
            ],
            'parent' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
            'count' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addPrimaryKey('term_taxonomy_id');
        $this->forge->addUniqueKey('term_id_taxonomy');
        $this->forge->createTable('term_taxonomy', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('term_taxonomy');
    }
}
