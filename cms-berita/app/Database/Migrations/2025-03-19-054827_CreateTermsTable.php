<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTermsTable extends Migration
{
    public function up()
    {
        // CREATE TABLE wp_terms (
        //     term_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        //     name VARCHAR(200) NOT NULL DEFAULT '',
        //     slug VARCHAR(200) NOT NULL DEFAULT '',
        //     term_group BIGINT(10) NOT NULL DEFAULT '0',
        //     PRIMARY KEY (term_id),
        //     UNIQUE KEY slug (slug)
        // );

        $this->forge->addField([
            'term_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'default' => '',
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 200,
                'default' => '',
            ],
            'term_group' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'default' => 0,
            ]
        ]);
        $this->forge->addPrimaryKey('term_id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('terms', true, [
            'charset' => 'utf8mb4',
            'collate' => 'utf8mb4_general_ci'
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('terms');
    }
}
