<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrestasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kegiatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'jenis'         => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tingkat'       => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'tahun'         => [
                'type'       => 'YEAR',
            ],
            'pencapaian'    => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('prestasi');
    }
}
