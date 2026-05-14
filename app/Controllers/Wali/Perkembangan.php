<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\DailyDevelopmentModel;
use App\Models\SantriModel;

class Perkembangan extends BaseController
{
    public function index()
    {
        $dailyModel = new DailyDevelopmentModel();
        $santriModel = new SantriModel();
        
        $userId = session()->get('user_id');
        $children = $santriModel->where('wali_id', $userId)->findAll();

        $data = [
            'title'    => 'Perkembangan Harian Santri',
            'children' => $children,
            'history'  => $dailyModel->getForWali($userId)
        ];

        return view('wali/perkembangan/index', $data);
    }
}
