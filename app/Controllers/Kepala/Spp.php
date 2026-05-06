<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\SppModel;

class Spp extends BaseController
{
    public function index()
    {
        $sppModel = new SppModel();
        
        $data = [
            'title' => 'Laporan Pembayaran SPP',
            'payments' => $sppModel->getSppWithSantri()
        ];

        return view('kepala/spp/index', $data);
    }
}
