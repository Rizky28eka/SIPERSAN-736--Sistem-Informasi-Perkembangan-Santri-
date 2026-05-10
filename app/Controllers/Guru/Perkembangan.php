<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\DevelopmentModel;
use App\Models\ClassModel;
use App\Models\SantriModel;
use App\Models\AcademicYearModel;

/**
 * Controller Perkembangan Santri (Guru)
 * CRUD catatan perkembangan: kepribadian, ekstrakurikuler, catatan wali kelas.
 */
class Perkembangan extends BaseController
{
    protected $devModel;
    protected $classModel;
    protected $santriModel;
    protected $ayModel;

    public function __construct()
    {
        $this->devModel    = new DevelopmentModel();
        $this->classModel  = new ClassModel();
        $this->santriModel = new SantriModel();
        $this->ayModel     = new AcademicYearModel();
    }

    /**
     * Daftar santri di kelas guru untuk diisi catatannya
     */
    public function index()
    {
        $teacherId  = session()->get('user_id');
        $classes    = $this->classModel->where('teacher_id', $teacherId)->findAll();
        $activeYear = $this->ayModel->where('status', 'active')->first();

        // Ambil semua santri dari kelas milik guru ini
        $classIds = array_column($classes, 'id');
        $santris  = !empty($classIds)
            ? $this->santriModel->whereIn('class_id', $classIds)->findAll()
            : [];

        // Map catatan yang sudah ada
        $devMap = [];
        if ($activeYear && !empty($santris)) {
            $devRecords = $this->devModel
                ->whereIn('santri_id', array_column($santris, 'id'))
                ->where('academic_year_id', $activeYear['id'])
                ->findAll();
            foreach ($devRecords as $d) {
                $devMap[$d['santri_id']] = $d;
            }
        }

        // Tambahkan info kelas ke setiap santri
        $classMap = array_column($classes, null, 'id');
        foreach ($santris as &$s) {
            $s['class_name'] = $classMap[$s['class_id']]['name'] ?? '-';
            $s['development'] = $devMap[$s['id']] ?? null;
        }

        return view('guru/perkembangan/index', [
            'title'      => 'Catatan Perkembangan Santri',
            'santris'    => $santris,
            'activeYear' => $activeYear,
        ]);
    }

    /**
     * Form isi / edit catatan perkembangan santri
     */
    public function form(int $santriId)
    {
        $teacherId  = session()->get('user_id');
        $santri     = $this->santriModel->find($santriId);
        $activeYear = $this->ayModel->where('status', 'active')->first();

        if (!$santri || !$activeYear) {
            return redirect()->to('guru/perkembangan')->with('error', 'Data tidak ditemukan.');
        }

        // Pastikan santri di kelas milik guru ini
        $class = $this->classModel->where(['id' => $santri['class_id'], 'teacher_id' => $teacherId])->first();
        if (!$class) {
            return redirect()->to('guru/perkembangan')->with('error', 'Santri bukan anggota kelas Anda.');
        }

        $development = $this->devModel->where([
            'santri_id'        => $santriId,
            'academic_year_id' => $activeYear['id'],
        ])->first();

        return view('guru/perkembangan/form', [
            'title'       => 'Catatan Perkembangan - ' . $santri['name'],
            'santri'      => $santri,
            'class'       => $class,
            'development' => $development,
            'activeYear'  => $activeYear,
        ]);
    }

    /**
     * Simpan atau update catatan perkembangan
     */
    public function save()
    {
        $santriId      = (int) $this->request->getPost('santri_id');
        $ayId          = (int) $this->request->getPost('academic_year_id');
        $extracurricular = $this->request->getPost('extracurricular');
        $personality   = $this->request->getPost('personality');
        $teacherNotes  = $this->request->getPost('teacher_notes');

        $existing = $this->devModel->where([
            'santri_id'        => $santriId,
            'academic_year_id' => $ayId,
        ])->first();

        $payload = [
            'santri_id'        => $santriId,
            'academic_year_id' => $ayId,
            'extracurricular'  => $extracurricular,
            'personality'      => $personality,
            'teacher_notes'    => $teacherNotes,
        ];

        if ($existing) {
            $this->devModel->update($existing['id'], $payload);
        } else {
            $this->devModel->insert($payload);
        }

        return redirect()->to('guru/perkembangan')->with('success', 'Catatan perkembangan berhasil disimpan.');
    }

    /**
     * Hapus catatan perkembangan
     */
    public function delete(int $id)
    {
        $this->devModel->delete($id);
        return redirect()->to('guru/perkembangan')->with('success', 'Catatan berhasil dihapus.');
    }
}
