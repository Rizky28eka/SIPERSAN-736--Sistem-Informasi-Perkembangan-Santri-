<?php

namespace App\Models;

use CodeIgniter\Model;

class TahfidzItemModel extends Model
{
    protected $table            = 'tahfidz_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['type', 'name', 'sort_order'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'type' => 'required|in_list[surah,hadits,lainnya]',
    ];

    // Ambil semua item dikelompokkan per type
    public function getGroupedByType(): array
    {
        $items = $this->orderBy('type', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        $grouped = ['surah' => [], 'hadits' => [], 'lainnya' => []];
        foreach ($items as $item) {
            $grouped[$item['type']][] = $item;
        }
        return $grouped;
    }
}
