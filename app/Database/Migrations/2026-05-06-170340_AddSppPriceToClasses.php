<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSppPriceToClasses extends Migration
{
    public function up()
    {
        $this->forge->addColumn('classes', [
            'spp_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 200000,
                'after'      => 'teacher_id'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('classes', 'spp_price');
    }
}
