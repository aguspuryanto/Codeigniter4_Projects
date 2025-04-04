<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanPajakTable extends Migration
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
            'periode' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'total_pajak' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'jenis_pajak' => [
                'type' => 'ENUM("PPN", "PPh", "lainnya")',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('laporan_pajak');
    }

    public function down()
    {
        $this->forge->dropTable('laporan_pajak');
    }
}
