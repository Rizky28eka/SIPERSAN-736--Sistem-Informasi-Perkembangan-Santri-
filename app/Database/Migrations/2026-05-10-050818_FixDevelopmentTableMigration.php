<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixDevelopmentTableMigration extends Migration
{
    public function up()
    {
        // Hapus kolom lama yang tidak sesuai jika ada
        $fields_to_drop = [];
        
        // Cek apakah kolom category dan description masih ada
        $existing = $this->db->getFieldNames('development');
        if (in_array('category', $existing)) {
            $fields_to_drop[] = 'category';
        }
        if (in_array('description', $existing)) {
            $fields_to_drop[] = 'description';
        }
        if (!empty($fields_to_drop)) {
            $this->forge->dropColumn('development', $fields_to_drop);
        }

        // Tambah kolom baru jika belum ada
        $addFields = [];
        if (!in_array('extracurricular', $existing)) {
            $addFields['extracurricular'] = ['type' => 'TEXT', 'null' => true, 'after' => 'academic_year_id'];
        }
        if (!in_array('personality', $existing)) {
            $addFields['personality'] = ['type' => 'TEXT', 'null' => true, 'after' => 'extracurricular'];
        }
        if (!in_array('teacher_notes', $existing)) {
            $addFields['teacher_notes'] = ['type' => 'TEXT', 'null' => true, 'after' => 'personality'];
        }

        if (!empty($addFields)) {
            $this->forge->addColumn('development', $addFields);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('development', ['extracurricular', 'personality', 'teacher_notes']);
        $this->forge->addColumn('development', [
            'category'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
        ]);
    }
}
