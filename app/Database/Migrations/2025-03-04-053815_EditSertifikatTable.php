<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EditSertifikatTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('sertifikat', [
            'nama_file' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('sertifikat', [
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true
            ]
        ]);
    }
}