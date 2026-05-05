<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $classModel = new \App\Models\ClassModel();
        $santriModel = new \App\Models\SantriModel();
        $attendanceModel = new \App\Models\AttendanceModel();

        $userId = session()->get('user_id');
        
        // Get classes managed by this teacher
        $classes = $classModel->where('teacher_id', $userId)->findAll();
        $classIds = array_column($classes, 'id');

        $totalSantri = 0;
        $attendancePercentage = 0;

        if (!empty($classIds)) {
            $totalSantri = $santriModel->whereIn('class_id', $classIds)->countAllResults();
            
            $today = date('Y-m-d');
            $attendanceToday = $attendanceModel->whereIn('santri_id', function($db) use ($classIds) {
                return $db->table('santri')->select('id')->whereIn('class_id', $classIds);
            })->where('date', $today)->where('status', 'Hadir')->countAllResults();

            $attendancePercentage = $totalSantri > 0 ? round(($attendanceToday / $totalSantri) * 100, 1) : 0;
        }

        $santriList = [];
        if (!empty($classIds)) {
            $santriList = $santriModel->whereIn('class_id', $classIds)->findAll();
        }

        $data = [
            'title' => 'Dashboard Guru',
            'stats' => [
                'total_santri' => $totalSantri,
                'avg_attendance' => $attendancePercentage,
            ],
            'santri' => $santriList,
            'announcements' => (new \App\Models\AnnouncementModel())->orderBy('created_at', 'DESC')->limit(5)->findAll()
        ];
        return view('guru/dashboard', $data);
    }
}
