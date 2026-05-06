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
        
        // Count unique students who are present today
        $attendanceToday = $attendanceModel->where('date', $today)
                                          ->where('status', 'Hadir')
                                          ->select('santri_id')
                                          ->distinct()
                                          ->countAllResults();
        
        $attendancePercentage = $totalSantri > 0 ? ($attendanceToday / $totalSantri) * 100 : 0;
        $attendancePercentage = min(100, round($attendancePercentage, 1));

        $data = [
            'title' => 'Dashboard Kepala Yayasan',
            'stats' => [
                'total_santri' => $totalSantri,
                'total_guru'   => $userModel->where('role', 'guru')->countAllResults(),
                'total_class'  => $classModel->countAllResults(),
                'avg_attendance' => $attendancePercentage,
            ],
            'announcements' => (new \App\Models\AnnouncementModel())
                                ->whereIn('target_role', ['all', 'kepala'])
                                ->orderBy('created_at', 'DESC')
                                ->limit(5)
                                ->findAll(),
            'recent_activities' => (new \App\Models\ActivityLogModel())->getRecent(8)
        ];
        return view('kepala/dashboard', $data);
    }
}
