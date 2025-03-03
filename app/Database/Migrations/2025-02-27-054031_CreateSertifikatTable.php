<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSertifikatTable extends Migration
{
    public function up()
    {
        // Tabel utama untuk data sertifikat
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_file'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi'  => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'kategori'   => [
                'type'       => 'ENUM',
                'constraint' => ['individual', 'kelompok', 'kelas'],
                'default'    => 'individual',
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
        $this->forge->createTable('sertifikat');
    }

    public function down()
    {
        $this->forge->dropTable('sertifikat');
    }
}
