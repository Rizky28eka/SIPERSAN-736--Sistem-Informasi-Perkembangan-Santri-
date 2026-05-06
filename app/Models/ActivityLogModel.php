<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'activity', 'description', 'created_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    public function log($activity, $description = null)
    {
        $this->save([
            'user_id'     => session()->get('user_id'),
            'activity'    => $activity,
            'description' => $description
        ]);
    }

    public function getRecent($limit = 10)
    {
        return $this->select('activity_logs.*, users.name as user_name, users.role as user_role')
                    ->join('users', 'users.id = activity_logs.user_id')
                    ->orderBy('activity_logs.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
