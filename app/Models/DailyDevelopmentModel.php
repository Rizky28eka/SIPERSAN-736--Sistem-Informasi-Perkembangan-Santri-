<?php

namespace App\Models;

use CodeIgniter\Model;

class DailyDevelopmentModel extends Model
{
    protected $table            = 'daily_developments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'santri_id', 
        'teacher_id', 
        'date', 
        'subject', 
        'note', 
        'status', // e.g., 'normal', 'need_attention'
        'created_at', 
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getBySantri($santriId, $limit = 30)
    {
        return $this->where('santri_id', $santriId)
                    ->orderBy('date', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getForWali($waliId)
    {
        return $this->select('daily_developments.*, santri.name as santri_name')
                    ->join('santri', 'santri.id = daily_developments.santri_id')
                    ->where('santri.wali_id', $waliId)
                    ->orderBy('date', 'DESC')
                    ->findAll();
    }
}
