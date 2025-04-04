<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKodeToProduk extends Migration
{
    public function up()
    {
        $this->forge->addColumn('produk', [
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'after'      => 'id',
                'unique'     => true,
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produk', 'kode');
    }
} 