<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSppHistoryTable extends Migration
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
            'spp_payment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'amount_paid' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'payment_date' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('spp_payment_id', 'spp_payments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spp_history');
    }

    public function down()
    {
        $this->forge->dropTable('spp_history');
    }
}
