<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSppHistoryForProof extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spp_history', [
            'proof_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'proof_note',
            ],
            'verification_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'verified', 'rejected'],
                'default'    => 'verified', // Default verified for admin/cash, wali payments will be pending
                'after'      => 'proof_image',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spp_history', ['proof_image', 'verification_status']);
    }
}
