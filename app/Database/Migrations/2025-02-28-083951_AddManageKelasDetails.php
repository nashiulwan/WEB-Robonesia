<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddManageKelasDetails extends Migration
{
    public function up()
    {
        $this->forge->addColumn('manage_kelas', [
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'gambar_proyek' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('manage_kelas', ['level', 'gambar_proyek']);
    }
}
