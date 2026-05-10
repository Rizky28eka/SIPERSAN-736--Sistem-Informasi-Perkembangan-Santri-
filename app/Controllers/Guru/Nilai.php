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

        $activeYear = $this->academicYearModel->where('status', 'active')->first();
        if (!$activeYear) {
            return redirect()->to('guru/nilai')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $santris = $this->santriModel->where('class_id', $classId)->findAll();
        
        // Cek status pengisian nilai per santri
        $devModel = new \App\Models\DevelopmentModel();
        foreach ($santris as &$s) {
            $dev = $devModel->where(['santri_id' => $s['id'], 'academic_year_id' => $activeYear['id']])->first();
            $s['is_filled'] = !empty($dev);
        }

        $data = [
            'title'      => 'Daftar Santri - ' . $class['name'],
            'class'      => $class,
            'santris'    => $santris,
            'activeYear' => $activeYear
        ];

        return view('guru/nilai/list_santri', $data);
    }

    public function evaluasi($santriId)
    {
        $teacherId = session()->get('user_id');
        $santri = $this->santriModel->find($santriId);
        
        if (!$santri) {
            return redirect()->to('guru/nilai')->with('error', 'Santri tidak ditemukan.');
        }

        $class = $this->classModel->where(['id' => $santri['class_id'], 'teacher_id' => $teacherId])->first();
        if (!$class) {
            return redirect()->to('guru/nilai')->with('error', 'Santri bukan anggota kelas Anda.');
        }

        $activeYear = $this->academicYearModel->where('status', 'active')->first();
        if (!$activeYear) {
            return redirect()->to('guru/nilai')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        // Ambil Nilai yang sudah ada
        $existingGrades = $this->gradeModel->where([
            'academic_year_id' => $activeYear['id'],
            'santri_id'        => $santriId
        ])->findAll();

        $gradeMap = [];
        foreach ($existingGrades as $g) {
            $gradeMap[$g['category']] = $g;
        }

        // Ambil Perkembangan yang sudah ada
        $devModel = new \App\Models\DevelopmentModel();
        $development = $devModel->where([
            'santri_id'        => $santriId,
            'academic_year_id' => $activeYear['id']
        ])->first();
        
        if (!$development) {
            $development = [];
        }

        $categories = [
            "Iqro'/Tartam Al-Qur'an",
            'Ilmu Tajwid',
            'Praktek Tajwid',
            'Bacaan Islam',
            'Hafalan Bacaan Sholat',
            'Hafalan Doa Sehari-hari',
            'Hafalan Surat-Surat Pendek',
            'Hafalan Ayat-Ayat Pilihan',
            'Menulis/Tahsinul Kitabah',
            'Praktek Sholat',
            'Hafalan Hadits/Mahfuzhat',
            'Bahasa Arab',
            'Bahasa Inggris',
        ];

        $data = [
            'title'       => 'Evaluasi Santri: ' . $santri['name'],
            'class'       => $class,
            'santri'      => $santri,
            'activeYear'  => $activeYear,
            'categories'  => $categories,
            'gradeMap'    => $gradeMap,
            'development' => $development
        ];

        return view('guru/nilai/evaluasi', $data);
    }

    public function storeEvaluasi()
    {
        $santriId       = $this->request->getPost('santri_id');
        $classId        = $this->request->getPost('class_id');
        $academicYearId = $this->request->getPost('academic_year_id');
        
        // 1. Simpan Nilai Akademik
        $grades = $this->request->getPost('grades'); // category => [score_numeric, score_letter]
        if ($grades) {
            foreach ($grades as $category => $values) {
                $scoreNumeric = $values['score_numeric'];
                $existing = $this->gradeModel->where([
                    'santri_id'        => $santriId,
                    'academic_year_id' => $academicYearId,
                    'category'         => $category
                ])->first();

                if ($scoreNumeric === '' || $scoreNumeric === null) {
                    if ($existing) $this->gradeModel->delete($existing['id']);
                    continue;
                }

                $dataGrade = [
                    'santri_id'        => $santriId,
                    'academic_year_id' => $academicYearId,
                    'category'         => $category,
                    'score_numeric'    => (int) $scoreNumeric,
                    'score_letter'     => $values['score_letter'] ?? '-',
                    'notes'            => '' // Tidak lagi dipakai per kategori, diganti catatan wali kelas
                ];

                if ($existing) {
                    $this->gradeModel->update($existing['id'], $dataGrade);
                } else {
                    $this->gradeModel->insert($dataGrade);
                }
            }
        }

        // 2. Simpan Catatan Perkembangan
        $devModel = new \App\Models\DevelopmentModel();
        $existingDev = $devModel->where([
            'santri_id'        => $santriId,
            'academic_year_id' => $academicYearId
        ])->first();

        $dataDev = [
            'santri_id'             => $santriId,
            'academic_year_id'      => $academicYearId,
            // Ekstrakurikuler
            'ekskul_1'              => $this->request->getPost('ekskul_1'),
            'ekskul_1_nilai'        => $this->request->getPost('ekskul_1_nilai'),
            'ekskul_2'              => $this->request->getPost('ekskul_2'),
            'ekskul_2_nilai'        => $this->request->getPost('ekskul_2_nilai'),
            'ekskul_3'              => $this->request->getPost('ekskul_3'),
            'ekskul_3_nilai'        => $this->request->getPost('ekskul_3_nilai'),
            // Kepribadian
            'disiplin'              => $this->request->getPost('disiplin'),
            'jujur'                 => $this->request->getPost('jujur'),
            'kerja_sama'            => $this->request->getPost('kerja_sama'),
            'rajin'                 => $this->request->getPost('rajin'),
            'kemampuan_berfikir'    => $this->request->getPost('kemampuan_berfikir'),
            // Ketidakhadiran
            'sakit_hari'            => (int) $this->request->getPost('sakit_hari'),
            'izin_hari'             => (int) $this->request->getPost('izin_hari'),
            'tanpa_keterangan_hari' => (int) $this->request->getPost('tanpa_keterangan_hari'),
            // Catatan
            'teacher_notes'         => $this->request->getPost('teacher_notes'),
        ];

        if ($existingDev) {
            $devModel->update($existingDev['id'], $dataDev);
        } else {
            $devModel->insert($dataDev);
        }

        return redirect()->to('guru/nilai/input/' . $classId)->with('success', 'Evaluasi santri berhasil disimpan!');
    }
}
