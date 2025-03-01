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
            'sub_level' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('manage_kelas', ['level', 'sub_level']);
    }
}
