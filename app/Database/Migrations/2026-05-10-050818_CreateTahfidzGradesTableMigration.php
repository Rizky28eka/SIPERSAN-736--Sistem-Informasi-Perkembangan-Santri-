<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahfidzGradesTableMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'santri_id'        => ['type' => 'INT', 'unsigned' => true],
            'tahfidz_item_id'  => ['type' => 'INT', 'unsigned' => true],
            'academic_year_id' => ['type' => 'INT', 'unsigned' => true],
            'status'           => ['type' => 'ENUM', 'constraint' => ['hafal', 'tidak_hafal'], 'default' => 'tidak_hafal'],
            'notes'            => ['type' => 'TEXT', 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['santri_id', 'tahfidz_item_id', 'academic_year_id']);
        $this->forge->createTable('tahfidz_grades');
    }

    public function down()
    {
        $this->forge->dropTable('tahfidz_grades', true);
    }
}
