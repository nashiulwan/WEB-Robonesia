<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPrestasiPivotTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'     => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'prestasi_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            'created_at'  => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'    => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('user_prestasi');
    }
}
