<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\AttendanceModel;
use App\Models\GradeModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel = new SantriModel();
        $attendanceModel = new AttendanceModel();
        $gradeModel = new GradeModel();

        $waliId = session()->get('user_id');
        
        // Get all children for this guardian
        $children = $santriModel->select('santri.*, classes.name as class_name')
                                ->join('classes', 'classes.id = santri.class_id', 'left')
                                ->where('wali_id', $waliId)
                                ->findAll();

        foreach ($children as &$child) {
            // Get attendance stats for this child
            $child['total_present'] = $attendanceModel->where(['santri_id' => $child['id'], 'status' => 'Hadir'])->countAllResults();
            $child['total_absent'] = $attendanceModel->where(['santri_id' => $child['id'], 'status' => 'Alpa'])->countAllResults();
            
            // Get latest grades
            $child['latest_grades'] = $gradeModel->where('santri_id', $child['id'])
                                                 ->orderBy('created_at', 'DESC')
                                                 ->limit(5)
                                                 ->findAll();
        }

        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel->whereIn('target_role', ['all', 'wali'])
                                           ->orderBy('created_at', 'DESC')
                                           ->limit(3)
                                           ->findAll();

        $data = [
            'title'         => 'Dashboard Wali Santri',
            'children'      => $children,
            'announcements' => $announcements
        ];

        return view('wali/dashboard', $data);
    }
}
