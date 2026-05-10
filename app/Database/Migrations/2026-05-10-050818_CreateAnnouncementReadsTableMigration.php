<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnnouncementReadsTableMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'         => ['type' => 'INT', 'unsigned' => true],
            'announcement_id' => ['type' => 'INT', 'unsigned' => true],
            'read_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['user_id', 'announcement_id']);
        $this->forge->createTable('announcement_reads');
    }

    public function down()
    {
        $this->forge->dropTable('announcement_reads', true);
    }
}
