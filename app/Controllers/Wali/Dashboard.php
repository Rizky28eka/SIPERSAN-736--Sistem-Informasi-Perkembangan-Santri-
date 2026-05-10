<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\AttendanceModel;
use App\Models\GradeModel;
use App\Models\SppModel;
use App\Models\AcademicYearModel;
use App\Models\ClassModel;

/**
 * Dashboard Wali Santri
 * Menampilkan data lengkap anak (santri), ringkasan absensi, nilai, dan SPP.
 */
class Dashboard extends BaseController
{
    public function index()
    {
        $santriModel     = new SantriModel();
        $attendanceModel = new AttendanceModel();
        $gradeModel      = new GradeModel();
        $sppModel        = new SppModel();
        $ayModel         = new AcademicYearModel();
        $classModel      = new ClassModel();

        $waliId     = session()->get('user_id');
        $activeYear = $ayModel->where('status', 'active')->first();
        $ayId       = $activeYear['id'] ?? null;

        // Ambil semua anak beserta nama kelas
        $children = $santriModel
            ->select('santri.*, classes.name as class_name')
            ->join('classes', 'classes.id = santri.class_id', 'left')
            ->where('wali_id', $waliId)
            ->findAll();

        foreach ($children as &$child) {
            // Rekap absensi dari data real
            $allAtt = $attendanceModel->where([
                'santri_id'        => $child['id'],
                'academic_year_id' => $ayId,
            ])->findAll();

            $child['attendance'] = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpa' => 0, 'total' => 0];
            foreach ($allAtt as $att) {
                $status = $att['status'];
                if (isset($child['attendance'][$status])) {
                    $child['attendance'][$status]++;
                }
                $child['attendance']['total']++;
            }

            // Nilai terbaru (5 terakhir)
            $child['latest_grades'] = $gradeModel
                ->where(['santri_id' => $child['id'], 'academic_year_id' => $ayId])
                ->orderBy('created_at', 'DESC')
                ->limit(5)
                ->findAll();

            // Status SPP
            $child['spp_status'] = $sppModel->where('santri_id', $child['id'])
                ->orderBy('year DESC, month DESC')
                ->limit(1)
                ->first();
        }

        $announcementModel = new \App\Models\AnnouncementModel();
        $announcements = $announcementModel
            ->whereIn('target_role', ['all', 'wali'])
            ->orderBy('created_at', 'DESC')
            ->limit(3)
            ->findAll();

        $data = [
            'title'         => 'Dashboard Wali Santri',
            'children'      => $children,
            'announcements' => $announcements,
            'activeYear'    => $activeYear,
        ];

        return view('wali/dashboard', $data);
    }
}
