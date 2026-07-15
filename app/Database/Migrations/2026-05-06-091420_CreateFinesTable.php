<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFinesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bayar'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pinjam'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah_bayar'    => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'snap_token'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status_pembayaran' => ['type' => 'ENUM', 'constraint' => ['pending', 'success', 'failed'], 'default' => 'pending'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_bayar', true);
        $this->forge->addForeignKey('id_pinjam', 'loans', 'id_pinjam', 'CASCADE', 'CASCADE');
        $this->forge->createTable('fines');
    }

    public function down() { $this->forge->dropTable('fines'); }
}