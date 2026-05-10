<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Tambahkan field-field dari Form Data Santri TKA/TPA yang sebenarnya:
 * - nickname (nama panggilan)
 * - birth_place, birth_date (tempat/tanggal lahir)
 * - child_order (anak ke-)
 * - child_status (Anak Kandung/Tiri/Asuh/Keponakan/Cucu)
 * - enter_tka_a, enter_tka_b (masuk paket A/B)
 * - exit_tka_a, exit_tka_b (keluar/pindah paket A/B)
 * - agama
 * - parent_education (pendidikan tertinggi orang tua)
 * - parent_occupation (pekerjaan)
 */
class AddSantriDetailFields extends Migration
{
    public function up()
    {
        $fields = [
            'nickname' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'name',
            ],
            'birth_place' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'gender',
            ],
            'birth_date' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'birth_place',
            ],
            'child_order' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'birth_date',
            ],
            'child_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Anak Kandung', 'Anak Tiri', 'Anak Asuh', 'Keponakan', 'Cucu'],
                'default'    => 'Anak Kandung',
                'null'       => true,
                'after'      => 'child_order',
            ],
            'enter_tka_a' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'child_status',
            ],
            'enter_tka_b' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'enter_tka_a',
            ],
            'exit_tka_a' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'enter_tka_b',
            ],
            'exit_tka_b' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'exit_tka_a',
            ],
            'agama' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Islam',
                'null'       => true,
                'after'      => 'exit_tka_b',
            ],
            'parent_education' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'agama',
            ],
            'parent_occupation' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'parent_education',
            ],
        ];

        $this->forge->addColumn('santri', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('santri', [
            'nickname', 'birth_place', 'birth_date', 'child_order', 'child_status',
            'enter_tka_a', 'enter_tka_b', 'exit_tka_a', 'exit_tka_b',
            'agama', 'parent_education', 'parent_occupation',
        ]);
    }
}
