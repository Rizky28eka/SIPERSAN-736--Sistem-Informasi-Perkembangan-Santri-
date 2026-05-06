<?php

namespace App\Models;

use CodeIgniter\Model;

class SppHistoryModel extends Model
{
    protected $table            = 'spp_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['spp_payment_id', 'amount_paid', 'payment_date'];

    protected $useTimestamps = true;
}
