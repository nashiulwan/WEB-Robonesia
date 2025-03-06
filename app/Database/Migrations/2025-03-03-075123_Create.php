<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddManageKelasDetails extends Migration
{
    public function up()
    {
        $this->forge->addColumn('shop', [
            'harga' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('shop', ['harga', 'kategori']);
    }
}
