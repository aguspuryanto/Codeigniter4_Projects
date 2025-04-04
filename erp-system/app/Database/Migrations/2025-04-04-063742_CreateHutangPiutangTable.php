<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHutangPiutangTable extends Migration
{
    public function up()
    {   
        $this->forge->dropTable('hutang_piutang');
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['hutang', 'piutang'],
                'null' => false,
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum bayar', 'sudah bayar'],
                'default' => 'belum bayar',
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
        $this->forge->createTable('hutang_piutang');
    }

    public function down()
    {
        $this->forge->dropTable('hutang_piutang');
    }
} 