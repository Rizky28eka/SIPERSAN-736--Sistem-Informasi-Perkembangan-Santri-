<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AcademicYear extends BaseController
{
    protected $academicYearModel;

    public function __construct()
    {
        $this->academicYearModel = new \App\Models\AcademicYearModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Tahun Ajaran',
            'years' => $this->academicYearModel->orderBy('year', 'DESC')->findAll()
        ];
        return view('kepala/academic_year/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Tahun Ajaran'];
        return view('kepala/academic_year/create', $data);
    }

    public function store()
    {
        $rules = [
            'year'     => 'required',
            'semester' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->academicYearModel->save([
            'year'     => $this->request->getPost('year'),
            'semester' => $this->request->getPost('semester'),
            'status'   => 'inactive'
        ]);

        return redirect()->to('/kepala/academic-year')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function activate($id)
    {
        // Deactivate all first
        $this->academicYearModel->where('status', 'active')->set(['status' => 'inactive'])->update();
        
        // Activate selected
        $this->academicYearModel->update($id, ['status' => 'active']);

        return redirect()->to('/kepala/academic-year')->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }

    public function delete($id)
    {
        $this->academicYearModel->delete($id);
        return redirect()->to('/kepala/academic-year')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}
