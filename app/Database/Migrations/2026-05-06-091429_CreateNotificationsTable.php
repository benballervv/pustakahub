<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_notif'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_user'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'isi_pesan'    => ['type' => 'TEXT'],
            'tanggal_kirim' => ['type' => 'DATETIME'],
            'jenis'        => ['type' => 'ENUM', 'constraint' => ['wa', 'email']],
        ]);
        $this->forge->addKey('id_notif', true);
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notifications');
    }

    public function down() { $this->forge->dropTable('notifications'); }
}