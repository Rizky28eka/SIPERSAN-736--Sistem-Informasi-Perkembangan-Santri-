<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Announcements extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengumuman',
            // Fetch from model later
            'announcements' => []
        ];

        return view('announcements/index', $data);
    }
}
