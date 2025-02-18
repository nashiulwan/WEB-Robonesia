<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ManageKelas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kode_kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true,
            ],
            'status' => [
                'type'       => 'int',
                'constraint' => '1',
                'default'    => 1,
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

        // Primary Key
        $this->forge->addKey('id', true);

        // Buat tabel manage_kelas
        $this->forge->createTable('manage_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('manage_kelas');
    }
}
