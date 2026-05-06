<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\ClassModel;
use App\Models\SantriModel;
use App\Models\GradeModel;
use App\Models\AcademicYearModel;

class Nilai extends BaseController
{
    protected $classModel;
    protected $santriModel;
    protected $gradeModel;
    protected $academicYearModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->santriModel = new SantriModel();
        $this->gradeModel = new GradeModel();
        $this->academicYearModel = new AcademicYearModel();
    }

    public function index()
    {
        $teacherId = session()->get('user_id');
        $classes = $this->classModel->where('teacher_id', $teacherId)->findAll();

        $data = [
            'title'   => 'Input Nilai Santri',
            'classes' => $classes
        ];

        return view('guru/nilai/index', $data);
    }

    public function input($classId)
    {
        $teacherId = session()->get('user_id');
        $class = $this->classModel->where(['id' => $classId, 'teacher_id' => $teacherId])->first();

        if (!$class) {
            return redirect()->to('guru/nilai')->with('error', 'Kelas tidak ditemukan atau bukan kelas Anda.');
        }

        $category = $this->request->getGet('category') ?? 'Iqro/Tahsin';
        $activeYear = $this->academicYearModel->where('status', 'active')->first();

        if (!$activeYear) {
            return redirect()->to('guru/nilai')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $santris = $this->santriModel->where('class_id', $classId)->findAll();
        
        $existingGrades = $this->gradeModel->where([
            'academic_year_id' => $activeYear['id'],
            'category' => $category
        ])->findAll();

        $gradeMap = [];
        foreach ($existingGrades as $g) {
            $gradeMap[$g['santri_id']] = $g;
        }

        $categories = [
            'Iqro/Tahsin', 'Hafalan Surat', 'Doa Sehari-hari', 
            'Praktik Sholat', 'Hadist', 'Bahasa Arab', 'Bahasa Inggris'
        ];

        $data = [
            'title'          => 'Input Nilai - ' . $class['name'],
            'class'          => $class,
            'santris'        => $santris,
            'category'       => $category,
            'categories'     => $categories,
            'gradeMap'       => $gradeMap,
            'activeYear'     => $activeYear
        ];

        return view('guru/nilai/input', $data);
    }

    public function store()
    {
        $classId = $this->request->getPost('class_id');
        $category = $this->request->getPost('category');
        $academicYearId = $this->request->getPost('academic_year_id');
        $grades = $this->request->getPost('grades'); // santri_id => [score_numeric, score_letter, notes]

        if (!$grades) {
            return redirect()->back()->with('error', 'Data nilai tidak valid.');
        }

        foreach ($grades as $santriId => $values) {
            $existing = $this->gradeModel->where([
                'santri_id' => $santriId,
                'academic_year_id' => $academicYearId,
                'category' => $category
            ])->first();

            $scoreNumeric = $values['score_numeric'];
            
            // If the input is empty, delete the existing record or skip inserting
            if ($scoreNumeric === '' || $scoreNumeric === null) {
                if ($existing) {
                    $this->gradeModel->delete($existing['id']);
                }
                continue;
            }

            $data = [
                'santri_id' => $santriId,
                'academic_year_id' => $academicYearId,
                'category' => $category,
                'score_numeric' => (int) $scoreNumeric,
                'score_letter' => $values['score_letter'] ?? '-',
                'notes' => $values['notes'] ?? ''
            ];

            if ($existing) {
                $this->gradeModel->update($existing['id'], $data);
            } else {
                $this->gradeModel->insert($data);
            }
        }

        return redirect()->to('guru/nilai/input/' . $classId . '?category=' . urlencode($category))->with('success', 'Nilai berhasil disimpan.');
    }
}
