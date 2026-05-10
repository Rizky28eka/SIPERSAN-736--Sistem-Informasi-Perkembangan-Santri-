<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahfidzItemsTableMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'type'       => ['type' => 'ENUM', 'constraint' => ['surah', 'hadits', 'lainnya'], 'default' => 'surah'],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tahfidz_items');
    }

    public function down()
    {
        $this->forge->dropTable('tahfidz_items', true);
    }
}
