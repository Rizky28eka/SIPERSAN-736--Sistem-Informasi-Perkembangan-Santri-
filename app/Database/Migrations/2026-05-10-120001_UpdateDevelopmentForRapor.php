<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Update tabel development agar sesuai format Rapor TKA/TPA:
 * - Ubah 'personality' menjadi field kepribadian per aspek (Baik/Cukup/Kurang)
 * - Tambah: disiplin, jujur, kerja_sama, rajin, kemampuan_berfikir
 * - Tambah: ekskul_1, ekskul_2, ekskul_3 (kegiatan ekstra kurikulum)
 * - Tambah: sakit, izin, tanpa_keterangan (Ketidakhadiran dalam hari)
 * - Pertahankan: teacher_notes (catatan wali kelas)
 */
class UpdateDevelopmentForRapor extends Migration
{
    public function up()
    {
        // Tambah kolom kepribadian (B=Baik, C=Cukup, K=Kurang)
        $kepribadianFields = [
            'disiplin' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'personality',
            ],
            'jujur' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'disiplin',
            ],
            'kerja_sama' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'jujur',
            ],
            'rajin' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'kerja_sama',
            ],
            'kemampuan_berfikir' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'rajin',
            ],
            // Kegiatan Ekstra Kurikulum (nama + nilai B/C/K)
            'ekskul_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'kemampuan_berfikir',
            ],
            'ekskul_1_nilai' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'ekskul_1',
            ],
            'ekskul_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'ekskul_1_nilai',
            ],
            'ekskul_2_nilai' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'ekskul_2',
            ],
            'ekskul_3' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'ekskul_2_nilai',
            ],
            'ekskul_3_nilai' => [
                'type'       => 'ENUM',
                'constraint' => ['B', 'C', 'K'],
                'null'       => true,
                'after'      => 'ekskul_3',
            ],
            // Ketidakhadiran (dalam hari)
            'sakit_hari' => [
                'type'      => 'TINYINT',
                'default'   => 0,
                'null'      => true,
                'after'     => 'ekskul_3_nilai',
            ],
            'izin_hari' => [
                'type'      => 'TINYINT',
                'default'   => 0,
                'null'      => true,
                'after'     => 'sakit_hari',
            ],
            'tanpa_keterangan_hari' => [
                'type'      => 'TINYINT',
                'default'   => 0,
                'null'      => true,
                'after'     => 'izin_hari',
            ],
        ];

        $this->forge->addColumn('development', $kepribadianFields);
    }

    public function down()
    {
        $this->forge->dropColumn('development', [
            'disiplin', 'jujur', 'kerja_sama', 'rajin', 'kemampuan_berfikir',
            'ekskul_1', 'ekskul_1_nilai', 'ekskul_2', 'ekskul_2_nilai',
            'ekskul_3', 'ekskul_3_nilai',
            'sakit_hari', 'izin_hari', 'tanpa_keterangan_hari',
        ]);
    }
}
