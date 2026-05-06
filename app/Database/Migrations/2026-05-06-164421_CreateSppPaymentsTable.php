<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSppPaymentsTable extends Migration
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
            'month' => [
                'type'       => 'INT',
                'constraint' => 2,
            ],
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 200000,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'lunas'],
                'default'    => 'pending',
            ],
            'payment_date' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('santri_id', 'santri', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spp_payments');
    }

    public function down()
    {
        $this->forge->dropTable('spp_payments');
    }
}
