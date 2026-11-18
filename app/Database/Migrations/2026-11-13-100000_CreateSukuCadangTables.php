<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSukuCadangTables extends Migration
{
    public function up()
    {
        // 1. Tabel kategori_part
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori_part');

        // 2. Tabel suku_cadang
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kategori_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kode_part' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'nama_part' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'harga' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'stok' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('kategori_id', 'kategori_part', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('suku_cadang');
    }

    public function down()
    {
        $this->forge->dropTable('suku_cadang', true);
        $this->forge->dropTable('kategori_part', true);
    }
}
