<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterShift extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_shift' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false
            ],
            'jam_mulai' => [
                'type' => 'TIME',
                'null' => false
            ],
            'jam_selesai' => [
                'type' => 'TIME',
                'null' => false
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            ]
        ]);
        
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('master_shift');
    }

    public function down()
    {
        $this->forge->dropTable('master_shift');
    }
}