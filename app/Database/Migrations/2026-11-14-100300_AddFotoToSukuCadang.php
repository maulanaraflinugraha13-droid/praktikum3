<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToSukuCadang extends Migration
{
    public function up()
    {
        $this->forge->addColumn('suku_cadang', [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after'=> 'stok',
            ],  
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('suku_cadang', 'foto');
    }
}