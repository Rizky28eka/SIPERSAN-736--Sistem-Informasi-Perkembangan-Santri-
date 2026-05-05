<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Santri extends BaseController
{
    protected $santriModel;
    protected $classModel;
    protected $userModel;

    public function __construct()
    {
        $this->santriModel = new \App\Models\SantriModel();
        $this->classModel = new \App\Models\ClassModel();
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Manajemen Data Santri',
            'santris' => $this->santriModel->select('santri.*, classes.name as class_name, users.name as wali_name')
                                          ->join('classes', 'classes.id = santri.class_id', 'left')
                                          ->join('users', 'users.id = santri.wali_id', 'left')
                                          ->findAll()
        ];
        return view('kepala/santri/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Data Santri',
            'classes'  => $this->classModel->findAll(),
            'walis'    => $this->userModel->where('role', 'wali')->findAll()
        ];
        return view('kepala/santri/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required',
            'nisn'     => 'required|is_unique[santri.nisn]',
            'class_id' => 'required',
            'wali_id'  => 'required',
            'gender'   => 'required',
            'address'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->santriModel->save([
            'name'     => $this->request->getPost('name'),
            'nisn'     => $this->request->getPost('nisn'),
            'class_id' => $this->request->getPost('class_id'),
            'wali_id'  => $this->request->getPost('wali_id'),
            'gender'   => $this->request->getPost('gender'),
            'address'  => $this->request->getPost('address')
        ]);

        return redirect()->to('/kepala/santri')->with('success', 'Data santri berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Santri',
            'santri'   => $this->santriModel->find($id),
            'classes'  => $this->classModel->findAll(),
            'walis'    => $this->userModel->where('role', 'wali')->findAll()
        ];
        return view('kepala/santri/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'     => 'required',
            'nisn'     => "required|is_unique[santri.nisn,id,{$id}]",
            'class_id' => 'required',
            'wali_id'  => 'required',
            'gender'   => 'required',
            'address'  => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->santriModel->save([
            'id'       => $id,
            'name'     => $this->request->getPost('name'),
            'nisn'     => $this->request->getPost('nisn'),
            'class_id' => $this->request->getPost('class_id'),
            'wali_id'  => $this->request->getPost('wali_id'),
            'gender'   => $this->request->getPost('gender'),
            'address'  => $this->request->getPost('address')
        ]);

        return redirect()->to('/kepala/santri')->with('success', 'Data santri berhasil diupdate.');
    }

    public function show($id)
    {
        $santri = $this->santriModel->select('santri.*, classes.name as class_name, users.name as wali_name, users.email as wali_email')
                                   ->join('classes', 'classes.id = santri.class_id', 'left')
                                   ->join('users', 'users.id = santri.wali_id', 'left')
                                   ->find($id);

        if (!$santri) {
            return redirect()->to('/kepala/santri')->with('error', 'Data santri tidak ditemukan.');
        }

        $ayModel = new \App\Models\AcademicYearModel();
        $activeAY = $ayModel->where('status', 'active')->first();
        $ayId = $activeAY ? $activeAY['id'] : null;

        $attendanceModel = new \App\Models\AttendanceModel();
        $attendance = $attendanceModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->findAll();

        $gradeModel = new \App\Models\GradeModel();
        $grades = $gradeModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->findAll();

        $devModel = new \App\Models\DevelopmentModel();
        $development = $devModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->first();

        $data = [
            'title'       => 'Detail Perkembangan Santri',
            'santri'      => $santri,
            'attendance'  => $attendance,
            'grades'      => $grades,
            'development' => $development,
            'activeAY'    => $activeAY
        ];

        return view('kepala/santri/show', $data);
    }

    public function print($id)
    {
        $santri = $this->santriModel->select('santri.*, classes.name as class_name, users.name as wali_name, users.email as wali_email')
                                   ->join('classes', 'classes.id = santri.class_id', 'left')
                                   ->join('users', 'users.id = santri.wali_id', 'left')
                                   ->find($id);

        if (!$santri) {
            return redirect()->to('/kepala/santri')->with('error', 'Data santri tidak ditemukan.');
        }

        $ayModel = new \App\Models\AcademicYearModel();
        $activeAY = $ayModel->where('status', 'active')->first();
        $ayId = $activeAY ? $activeAY['id'] : null;

        $attendanceModel = new \App\Models\AttendanceModel();
        $attendance = $attendanceModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->findAll();

        $gradeModel = new \App\Models\GradeModel();
        $grades = $gradeModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->findAll();

        $devModel = new \App\Models\DevelopmentModel();
        $development = $devModel->where(['santri_id' => $id, 'academic_year_id' => $ayId])->first();

        // Get Teacher Name for current class
        $class = $this->classModel->select('classes.*, users.name as teacher_name')
                                  ->join('users', 'users.id = classes.teacher_id', 'left')
                                  ->find($santri['class_id']);

        $data = [
            'title'       => 'Raport Santri - ' . $santri['name'],
            'santri'      => $santri,
            'attendance'  => $attendance,
            'grades'      => $grades,
            'development' => $development,
            'activeAY'    => $activeAY,
            'teacher'     => $class['teacher_name'] ?? 'Wali Kelas'
        ];

        return view('kepala/santri/print', $data);
    }

    public function delete($id)
    {
        $this->santriModel->delete($id);
        return redirect()->to('/kepala/santri')->with('success', 'Data santri berhasil dihapus.');
    }
}
