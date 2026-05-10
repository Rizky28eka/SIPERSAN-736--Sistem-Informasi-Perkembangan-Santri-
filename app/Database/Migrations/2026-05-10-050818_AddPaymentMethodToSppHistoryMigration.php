<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentMethodToSppHistoryMigration extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spp_history', [
            'payment_method' => [
                'type'       => 'ENUM',
                'constraint' => ['cash', 'transfer', 'qris'],
                'default'    => 'cash',
                'after'      => 'amount_paid',
            ],
            'proof_note' => [
                'type'  => 'VARCHAR',
                'constraint' => 255,
                'null'  => true,
                'after' => 'payment_method',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spp_history', ['payment_method', 'proof_note']);
    }
}
