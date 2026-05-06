<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeEmailNullableInUsers extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('users', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
                'unique'     => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('users', [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => false,
                'unique'     => true,
            ],
        ]);
    }
}
