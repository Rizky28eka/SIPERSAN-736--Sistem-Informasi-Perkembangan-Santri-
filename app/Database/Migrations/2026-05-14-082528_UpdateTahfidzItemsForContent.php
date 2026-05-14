<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTahfidzItemsForContent extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tahfidz_items', [
            'content' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tahfidz_items', 'content');
    }
}
