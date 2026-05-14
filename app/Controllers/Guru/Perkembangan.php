<?php

namespace App\Controllers\Guru;

use App\Controllers\BaseController;
use App\Models\DailyDevelopmentModel;
use App\Models\ClassModel;
use App\Models\SantriModel;

class Perkembangan extends BaseController
{
    protected $dailyModel;
    protected $classModel;
    protected $santriModel;

    public function __construct()
    {
        $this->dailyModel = new DailyDevelopmentModel();
        $this->classModel = new ClassModel();
        $this->santriModel = new SantriModel();
    }

    public function index()
    {
        $teacherId = session()->get('user_id');
        $classes = $this->classModel->where('teacher_id', $teacherId)->findAll();

        $data = [
            'title'   => 'Perkembangan Harian Santri',
            'classes' => $classes
        ];

        return view('guru/perkembangan/index', $data);
    }

    public function list($classId)
    {
        $teacherId = session()->get('user_id');
        $class = $this->classModel->where(['id' => $classId, 'teacher_id' => $teacherId])->first();

        if (!$class) {
            return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
        }

        $santris = $this->santriModel->where('class_id', $classId)->findAll();
        
        $data = [
            'title'   => 'Daftar Santri - ' . $class['name'],
            'class'   => $class,
            'santris' => $santris
        ];

        return view('guru/perkembangan/list_santri', $data);
    }

    public function detail($santriId)
    {
        $santri = $this->santriModel->find($santriId);
        if (!$santri) return redirect()->back()->with('error', 'Santri tidak ditemukan.');

        $history = $this->dailyModel->getBySantri($santriId);

        $data = [
            'title'   => 'Catatan Harian: ' . $santri['name'],
            'santri'  => $santri,
            'history' => $history
        ];

        return view('guru/perkembangan/detail', $data);
    }

    public function store()
    {
        $santriId = $this->request->getPost('santri_id');
        $date     = $this->request->getPost('date') ?: date('Y-m-d');
        
        $this->dailyModel->insert([
            'santri_id'  => $santriId,
            'teacher_id' => session()->get('user_id'),
            'date'       => $date,
            'subject'    => $this->request->getPost('subject'),
            'note'       => $this->request->getPost('note'),
            'status'     => $this->request->getPost('status') ?: 'normal',
        ]);

        return redirect()->back()->with('success', 'Catatan perkembangan berhasil disimpan.');
    }

    public function delete($id)
    {
        $this->dailyModel->delete($id);
        return redirect()->back()->with('success', 'Catatan berhasil dihapus.');
    }
}
