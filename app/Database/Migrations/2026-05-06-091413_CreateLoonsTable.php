<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoansTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pinjam'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_eksemplar'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tgl_pinjam'      => ['type' => 'DATE'],
            'tgl_jatuh_tempo' => ['type' => 'DATE'],
            'tgl_kembali'     => ['type' => 'DATE', 'null' => true],
            'status_pinjam'   => ['type' => 'ENUM', 'constraint' => ['diajukan', 'dipinjam', 'kembali', 'terlambat'], 'default' => 'diajukan'],
        ]);
        $this->forge->addKey('id_pinjam', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_eksemplar', 'book_copies', 'id_eksemplar', 'CASCADE', 'CASCADE');
        $this->forge->createTable('loans');
    }

    public function down() { $this->forge->dropTable('loans'); }
}