<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGradeImages extends Migration
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
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'image_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
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

        // Primary Key
        $this->forge->addKey('id', true);
        // Index untuk foreign key
        $this->forge->addKey('kelas_id');
        // (Opsional) Jika ingin menambahkan foreign key constraint:
        $this->forge->addForeignKey('kelas_id', 'manage_kelas', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('grade_images');
    }

    public function down()
    {
        $this->forge->dropTable('grade_images');
    }
}
