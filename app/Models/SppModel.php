<?php

namespace App\Models;

use CodeIgniter\Model;

class SppModel extends Model
{
    protected $table            = 'spp_payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['santri_id', 'month', 'year', 'due_date', 'amount', 'total_paid', 'status', 'payment_date'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getSppWithSantri($wali_id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('spp_payments.*, santri.name as santri_name, santri.nisn, classes.name as class_name');
        $builder->join('santri', 'santri.id = spp_payments.santri_id');
        $builder->join('classes', 'classes.id = santri.class_id');
        
        if ($wali_id) {
            $builder->where('santri.wali_id', $wali_id);
        }

        $builder->orderBy('year', 'DESC');
        $builder->orderBy('month', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function checkNunggak()
    {
        $today = date('Y-m-d');
        $this->where('status !=', 'lunas')
             ->where('due_date <', $today)
             ->set(['status' => 'nunggak'])
             ->update();
    }
}
