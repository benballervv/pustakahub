<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_buku'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'isbn'         => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'penulis'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'penerbit'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'tahun_terbit' => ['type' => 'YEAR', 'null' => true],
            'cover_url'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('id_buku', true);
        $this->forge->createTable('books');
    }

    public function down() { $this->forge->dropTable('books'); }
}