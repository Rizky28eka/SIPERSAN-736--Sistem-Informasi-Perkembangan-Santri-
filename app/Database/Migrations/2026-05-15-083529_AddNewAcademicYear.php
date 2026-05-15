<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewAcademicYear extends Migration
{
    public function up()
    {
        $this->db->table('academic_years')->update(['status' => 'inactive'], ['status' => 'active']);
        $this->db->table('academic_years')->insert([
            'year'       => '2025/2026',
            'semester'   => '2',
            'status'     => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $this->db->table('academic_years')->where('year', '2025/2026')->where('semester', '2')->delete();
    }
}
