<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMasterShiftSettingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_pegawai' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_shift' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tgl_shift' => [
                'type' => 'DATE',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pegawai', 'pegawai', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('id_shift', 'master_shift', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('master_shift_setting');
    }

    public function down()
    {
        $this->forge->dropTable('master_shift_setting');
    }
} 