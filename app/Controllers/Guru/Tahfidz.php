<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\TahfidzItemModel;
use App\Models\TahfidzGradeModel;
use App\Models\ClassModel;
use App\Models\SantriModel;
use App\Models\AcademicYearModel;

/**
 * Controller Tahfidz
 * Mengelola master data hafalan (Surah, Hadits, dll) dan 
 * checklist hafalan per santri oleh guru.
 */
class Tahfidz extends BaseController
{
    protected $tahfidzItemModel;
    protected $tahfidzGradeModel;
    protected $classModel;
    protected $santriModel;
    protected $ayModel;

    public function __construct()
    {
        $this->tahfidzItemModel  = new TahfidzItemModel();
        $this->tahfidzGradeModel = new TahfidzGradeModel();
        $this->classModel        = new ClassModel();
        $this->santriModel       = new SantriModel();
        $this->ayModel           = new AcademicYearModel();
    }

    // ─── MASTER DATA TAHFIDZ ──────────────────────────────────────────────────

    /**
     * Halaman daftar semua item tahfidz (master data)
     */
    public function index()
    {
        $data = [
            'title'   => 'Master Data Tahfidz',
            'grouped' => $this->tahfidzItemModel->getGroupedByType(),
            'items'   => $this->tahfidzItemModel->orderBy('type', 'ASC')->orderBy('sort_order', 'ASC')->findAll(),
        ];
        return view('guru/tahfidz/index', $data);
    }

    /**
     * Form tambah item tahfidz baru
     */
    public function create()
    {
        return view('guru/tahfidz/form', ['title' => 'Tambah Item Tahfidz', 'item' => null]);
    }

    /**
     * Simpan item tahfidz baru
     */
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'type' => 'required|in_list[surah,hadits,lainnya]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tahfidzItemModel->insert([
            'type'       => $this->request->getPost('type'),
            'name'       => $this->request->getPost('name'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
        ]);

        return redirect()->to('guru/tahfidz')->with('success', 'Item tahfidz berhasil ditambahkan.');
    }

    /**
     * Form edit item tahfidz
     */
    public function edit(int $id)
    {
        $item = $this->tahfidzItemModel->find($id);
        if (!$item) {
            return redirect()->to('guru/tahfidz')->with('error', 'Item tidak ditemukan.');
        }
        return view('guru/tahfidz/form', ['title' => 'Edit Item Tahfidz', 'item' => $item]);
    }

    /**
     * Update item tahfidz
     */
    public function update(int $id)
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[255]',
            'type' => 'required|in_list[surah,hadits,lainnya]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tahfidzItemModel->update($id, [
            'type'       => $this->request->getPost('type'),
            'name'       => $this->request->getPost('name'),
            'sort_order' => (int) ($this->request->getPost('sort_order') ?? 0),
        ]);

        return redirect()->to('guru/tahfidz')->with('success', 'Item tahfidz berhasil diperbarui.');
    }

    /**
     * Hapus item tahfidz
     */
    public function delete(int $id)
    {
        $this->tahfidzItemModel->delete($id);
        return redirect()->to('guru/tahfidz')->with('success', 'Item tahfidz berhasil dihapus.');
    }

    // ─── CHECKLIST HAFALAN PER KELAS ─────────────────────────────────────────

    /**
     * Pilih kelas untuk input hafalan
     */
    public function inputIndex()
    {
        $teacherId = session()->get('user_id');
        $classes   = $this->classModel->where('teacher_id', $teacherId)->findAll();

        return view('guru/tahfidz/input_index', [
            'title'   => 'Input Hafalan Santri',
            'classes' => $classes,
        ]);
    }

    /**
     * Form checklist hafalan santri per kelas
     */
    public function input(int $classId)
    {
        $teacherId = session()->get('user_id');
        $class     = $this->classModel->where(['id' => $classId, 'teacher_id' => $teacherId])->first();

        if (!$class) {
            return redirect()->to('guru/tahfidz/input')->with('error', 'Kelas tidak ditemukan atau bukan kelas Anda.');
        }

        $activeYear = $this->ayModel->where('status', 'active')->first();
        if (!$activeYear) {
            return redirect()->to('guru/tahfidz/input')->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $santris = $this->santriModel->where('class_id', $classId)->findAll();
        $grouped = $this->tahfidzItemModel->getGroupedByType();
        $allItems = $this->tahfidzItemModel->orderBy('type', 'ASC')->orderBy('sort_order', 'ASC')->findAll();

        // Buat map gradeMap[santri_id][item_id] = status
        $gradeMap = [];
        foreach ($santris as $s) {
            $gradeMap[$s['id']] = $this->tahfidzGradeModel->getForSantri($s['id'], $activeYear['id']);
        }

        return view('guru/tahfidz/input', [
            'title'      => 'Input Hafalan - ' . $class['name'],
            'class'      => $class,
            'santris'    => $santris,
            'grouped'    => $grouped,
            'allItems'   => $allItems,
            'gradeMap'   => $gradeMap,
            'activeYear' => $activeYear,
        ]);
    }

    /**
     * Simpan checklist hafalan
     */
    public function storeInput()
    {
        $classId    = $this->request->getPost('class_id');
        $ayId       = (int) $this->request->getPost('academic_year_id');
        $hafalanData = $this->request->getPost('hafalan'); // [santri_id][item_id] = 'hafal'/'tidak_hafal'

        if ($hafalanData) {
            foreach ($hafalanData as $santriId => $items) {
                foreach ($items as $itemId => $status) {
                    $this->tahfidzGradeModel->saveStatus(
                        (int) $santriId,
                        (int) $itemId,
                        $ayId,
                        in_array($status, ['hafal', 'tidak_hafal']) ? $status : 'tidak_hafal'
                    );
                }
            }
        }

        return redirect()->to('guru/tahfidz/input/' . $classId)->with('success', 'Data hafalan berhasil disimpan.');
    }
}
