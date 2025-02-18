<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelasAnggota extends Migration
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
            'id_kelas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Primary Key
        $this->forge->addKey('id', true);

        // Foreign Key (Relasi dengan manage_kelas dan users)
        $this->forge->addForeignKey('id_kelas', 'manage_kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');

        // Buat tabel kelas_anggota
        $this->forge->createTable('kelas_anggota');
    }

    public function down()
    {
        $this->forge->dropTable('kelas_anggota');
    }
}
