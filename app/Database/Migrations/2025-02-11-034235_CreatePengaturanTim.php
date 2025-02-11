<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengaturanTim extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'peran' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'maps' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'facebook' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'whatsapp' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'twitter' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'instagram' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengaturan_tim');
    }

    public function down()
    {
        $this->forge->dropTable('pengaturan_tim');
    }
}
