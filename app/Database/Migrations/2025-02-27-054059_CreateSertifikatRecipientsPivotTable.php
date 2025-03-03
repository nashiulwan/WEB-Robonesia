<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSertifikatRecipientsPivotTable extends Migration
{
    public function up()
    {
        // Tabel pivot untuk menentukan penerima sertifikat (bisa user atau kelas)
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'sertifikat_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
            ],
            // target_type akan menyimpan tipe penerima, misal 'user' atau 'kelas'
            'target_type'   => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'target_id'     => [
                'type'       => 'INT',
                'unsigned'   => true,
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
        $this->forge->createTable('sertifikat_recipients');
    }

    public function down()
    {
        $this->forge->dropTable('sertifikat_recipients');
    }
}
