<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\SantriModel;
use App\Models\AttendanceModel;
use App\Models\AcademicYearModel;

class Absensi extends BaseController
{
    protected $classModel;
    protected $santriModel;
    protected $attendanceModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->santriModel = new SantriModel();
        $this->attendanceModel = new AttendanceModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $teacherId = session()->get('user_id');
        $classes = $this->classModel->where('teacher_id', $teacherId)->findAll();

        $data = [
            'title'   => 'Absensi Santri',
            'classes' => $classes
        ];

        return view('guru/absensi/index', $data);
    }

    public function input($classId)
    {
        $teacherId = session()->get('user_id');
        $class = $this->classModel->where(['id' => $classId, 'teacher_id' => $teacherId])->first();

        if (!$class) {
            return redirect()->to('guru/absensi')->with('error', 'Kelas tidak ditemukan atau bukan kelas Anda.');
        }

        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $activeYear = $this->academicYearModel->where('status', 'active')->first();

        if (!$activeYear) {
            return redirect()->to('guru/absensi')->with('error', 'Tahun ajaran aktif tidak ditemukan. Hubungi Admin.');
        }

        // Get students in this class
        $santris = $this->santriModel->where('class_id', $classId)->findAll();

        // Get existing attendance for this date
        $existingAttendance = $this->attendanceModel->where([
            'date' => $date,
            'academic_year_id' => $activeYear['id']
        ])->findAll();

        $attendanceMap = [];
        foreach ($existingAttendance as $att) {
            $attendanceMap[$att['santri_id']] = $att;
        }

        $data = [
            'title'         => 'Input Absensi - ' . $class['name'],
            'class'         => $class,
            'santris'       => $santris,
            'date'          => $date,
            'attendanceMap' => $attendanceMap,
            'activeYear'    => $activeYear
        ];

        return view('guru/absensi/input', $data);
    }

    public function store()
    {
        $classId = $this->request->getPost('class_id');
        $date = $this->request->getPost('date');
        $academicYearId = $this->request->getPost('academic_year_id');
        $attendances = $this->request->getPost('attendance'); // santri_id => status

        if (!$attendances) {
            return redirect()->back()->with('error', 'Data absensi tidak valid.');
        }

        foreach ($attendances as $santriId => $status) {
            // Check if already exists
            $existing = $this->attendanceModel->where([
                'santri_id' => $santriId,
                'date' => $date,
                'academic_year_id' => $academicYearId
            ])->first();

            $data = [
                'santri_id' => $santriId,
                'academic_year_id' => $academicYearId,
                'date' => $date,
                'status' => $status,
                'notes' => $this->request->getPost('notes')[$santriId] ?? ''
            ];

            if ($existing) {
                $this->attendanceModel->update($existing['id'], $data);
            } else {
                $this->attendanceModel->insert($data);
            }
        }

        return redirect()->to('guru/absensi/input/' . $classId . '?date=' . $date)->with('success', 'Absensi berhasil disimpan.');
    }
}
