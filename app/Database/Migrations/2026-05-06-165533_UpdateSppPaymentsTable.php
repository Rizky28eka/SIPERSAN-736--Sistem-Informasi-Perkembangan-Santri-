<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSppPaymentsTable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('spp_payments', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['belum', 'lunas', 'nunggak', 'cicilan'],
                'default'    => 'belum',
            ],
        ]);

        $this->forge->addColumn('spp_payments', [
            'due_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'year'
            ],
            'total_paid' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'amount'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spp_payments', ['due_date', 'total_paid']);
        $this->forge->modifyColumn('spp_payments', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'lunas'],
                'default'    => 'pending',
            ],
        ]);
    }
}
