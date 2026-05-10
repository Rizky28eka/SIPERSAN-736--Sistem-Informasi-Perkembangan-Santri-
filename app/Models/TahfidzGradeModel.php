<?php

namespace App\Models;

use CodeIgniter\Model;

class TahfidzGradeModel extends Model
{
    protected $table            = 'tahfidz_grades';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['santri_id', 'tahfidz_item_id', 'academic_year_id', 'status', 'notes'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Ambil status hafalan per santri dalam satu tahun ajaran
    public function getForSantri(int $santriId, int $academicYearId): array
    {
        $rows = $this->where(['santri_id' => $santriId, 'academic_year_id' => $academicYearId])->findAll();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['tahfidz_item_id']] = $r;
        }
        return $map;
    }

    // Simpan atau update status hafalan
    public function saveStatus(int $santriId, int $itemId, int $ayId, string $status, string $notes = ''): void
    {
        $existing = $this->where([
            'santri_id'        => $santriId,
            'tahfidz_item_id'  => $itemId,
            'academic_year_id' => $ayId,
        ])->first();

        $data = [
            'santri_id'        => $santriId,
            'tahfidz_item_id'  => $itemId,
            'academic_year_id' => $ayId,
            'status'           => $status,
            'notes'            => $notes,
        ];

        if ($existing) {
            $this->update($existing['id'], $data);
        } else {
            $this->insert($data);
        }
    }
}
