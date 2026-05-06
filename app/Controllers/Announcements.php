<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Announcements extends BaseController
{
    public function index()
    {
        $model = new \App\Models\AnnouncementModel();
        $role = session()->get('role');

        // Fetch announcements targetted to this role or 'all'
        $announcements = $model->whereIn('target_role', [$role, 'all'])
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        $data = [
            'title'         => 'Pengumuman Resmi',
            'announcements' => $announcements
        ];

        return view('announcements/index', $data);
    }
}
