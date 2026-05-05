<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttendanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'santri_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'academic_year_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                'default'    => 'Hadir',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('attendance');
    }

    public function down()
    {
        $this->forge->dropTable('attendance');
    }
}
