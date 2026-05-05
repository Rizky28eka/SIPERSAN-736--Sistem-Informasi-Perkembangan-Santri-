<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel = new \App\Models\SantriModel();
        $userModel = new \App\Models\UserModel();
        $classModel = new \App\Models\ClassModel();
        $attendanceModel = new \App\Models\AttendanceModel();

        $today = date('Y-m-d');
        $totalSantri = $santriModel->countAllResults();
        $attendanceToday = $attendanceModel->where('date', $today)->where('status', 'Hadir')->countAllResults();
        
        $attendancePercentage = $totalSantri > 0 ? round(($attendanceToday / $totalSantri) * 100, 1) : 0;

        $data = [
            'title' => 'Dashboard Kepala Yayasan',
            'stats' => [
                'total_santri' => $totalSantri,
                'total_guru'   => $userModel->where('role', 'guru')->countAllResults(),
                'total_class'  => $classModel->countAllResults(),
                'avg_attendance' => $attendancePercentage,
            ],
            'announcements' => (new \App\Models\AnnouncementModel())->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ];
        return view('kepala/dashboard', $data);
    }
}
