<?php

namespace App\Models;

use CodeIgniter\Model;

class DevelopmentModel extends Model
{
    protected $table            = 'development';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'santri_id', 'academic_year_id',
        // Kepribadian (B=Baik, C=Cukup, K=Kurang) - sesuai rapor TKA/TPA
        'disiplin', 'jujur', 'kerja_sama', 'rajin', 'kemampuan_berfikir',
        // Kegiatan Ekstra Kurikulum
        'ekskul_1', 'ekskul_1_nilai', 'ekskul_2', 'ekskul_2_nilai', 'ekskul_3', 'ekskul_3_nilai',
        // Ketidakhadiran (dalam hari)
        'sakit_hari', 'izin_hari', 'tanpa_keterangan_hari',
        // Catatan teks (kolom lama dipertahankan)
        'extracurricular', 'personality', 'teacher_notes',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
