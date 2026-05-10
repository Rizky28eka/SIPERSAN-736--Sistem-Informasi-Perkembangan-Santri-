<?php

namespace App\Models;

use CodeIgniter\Model;

class SppHistoryModel extends Model
{
    protected $table      = 'spp_history';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['spp_payment_id', 'amount_paid', 'payment_method', 'proof_note', 'payment_date'];

    protected $useTimestamps = false;
}
