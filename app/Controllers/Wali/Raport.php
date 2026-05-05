<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SantriModel;
use App\Models\GradeModel;
use App\Models\AttendanceModel;
use App\Models\AcademicYearModel;

class Raport extends BaseController
{
    public function index()
    {
        $santriModel = new SantriModel();
        $userId = session()->get('user_id');
        
        $children = $santriModel->where('wali_id', $userId)->findAll();

        $data = [
            'title' => 'Raport Santri',
            'children' => $children
        ];

        return view('wali/raport/index', $data);
    }

    public function detail($santriId)
    {
        $santriModel = new SantriModel();
        $gradeModel = new GradeModel();
        $attendanceModel = new AttendanceModel();
        $ayModel = new AcademicYearModel();

        $userId = session()->get('user_id');
        
        // Ensure this child belongs to the logged-in wali
        $child = $santriModel->where(['id' => $santriId, 'wali_id' => $userId])->first();

        if (!$child) {
            return redirect()->to('wali/dashboard')->with('error', 'Data santri tidak ditemukan.');
        }

        $activeAY = $ayModel->where('status', 'active')->first();
        $ayId = $activeAY['id'] ?? null;

        $grades = [];
        $attendance = ['Hadir' => 0, 'Sakit' => 0, 'Izin' => 0, 'Alpa' => 0];
        $development = null;

        if ($ayId) {
            $grades = $gradeModel->where(['santri_id' => $santriId, 'academic_year_id' => $ayId])->findAll();
            $development = (new \App\Models\DevelopmentModel())->where(['santri_id' => $santriId, 'academic_year_id' => $ayId])->first();
            
            $rawAttendance = $attendanceModel->where(['santri_id' => $santriId, 'academic_year_id' => $ayId])->findAll();
            foreach ($rawAttendance as $att) {
                if (isset($attendance[$att['status']])) {
                    $attendance[$att['status']]++;
                }
            }
        }

        $data = [
            'title' => 'Detail Raport - ' . $child['name'],
            'child' => $child,
            'grades' => $grades,
            'attendance' => $attendance,
            'development' => $development,
            'academic_year' => $activeAY
        ];

        return view('wali/raport/detail', $data);
    }
}
