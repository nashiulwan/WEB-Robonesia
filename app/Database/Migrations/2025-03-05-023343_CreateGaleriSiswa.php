<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleriSiswa extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'sub_level' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'gambar' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('galeri_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('galeri_siswa');
    }
}
