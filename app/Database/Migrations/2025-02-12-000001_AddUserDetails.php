<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use PHPUnit\TextUI\Output\DefaultPrinter;

class AddUserDetails extends Migration
{
  public function up()
  {
    $this->forge->addColumn('users', [
      'asal_sekolah' => [
        'type'       => 'VARCHAR',
        'constraint' => 255,
        'null'       => true,
        'default'     => '-',
      ],
      'kelas' => [
        'type'       => 'VARCHAR',
        'constraint' => 50,
        'null'       => true,
        'default'     => '-',
      ],
      'alamat' => [
        'type' => 'TEXT',
        'null' => true,
        'default'     => '-',
      ],
      'nomor_telepon' => [
        'type'       => 'VARCHAR',
        'constraint' => 15,
        'null'       => true,
        'default'     => '-',
      ],
    ]);
  }
  public function down()
  {
    $this->forge->dropColumn('users', ['asal_sekolah', 'kelas', 'alamat', 'nomor_telepon', 'password']);
  }
}
