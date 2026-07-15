<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookCopiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_eksemplar' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_buku'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kode_eksemplar' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'kondisi'      => ['type' => 'ENUM', 'constraint' => ['bagus', 'rusak'], 'default' => 'bagus'],
            'lokasi_rak'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'status_tersedia' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'dipinjam'], 'default' => 'tersedia'],
        ]);
        $this->forge->addKey('id_eksemplar', true);
        $this->forge->addForeignKey('id_buku', 'books', 'id_buku', 'CASCADE', 'CASCADE');
        $this->forge->createTable('book_copies');
    }

    public function down() { $this->forge->dropTable('book_copies'); }
}