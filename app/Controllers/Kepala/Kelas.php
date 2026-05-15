<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kelas extends BaseController
{
    protected $classModel;
    protected $userModel;
    protected $activityLog;

    public function __construct()
    {
        $this->classModel = new \App\Models\ClassModel();
        $this->userModel = new \App\Models\UserModel();
        $this->activityLog = new \App\Models\ActivityLogModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->classModel->select('classes.*, users.name as teacher_name')
                                      ->join('users', 'users.id = classes.teacher_id', 'left');

        if ($keyword) {
            $builder->groupStart()
                    ->like('classes.name', $keyword)
                    ->orLike('users.name', $keyword)
                    ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Data Kelas',
            'classes' => $builder->findAll(),
            'keyword' => $keyword
        ];
        return view('kepala/kelas/index', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Tambah Data Kelas',
            'teachers' => $this->userModel->where('role', 'guru')->findAll()
        ];
        return view('kepala/kelas/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'       => 'required',
            'teacher_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->classModel->save([
            'name'       => $this->request->getPost('name'),
            'teacher_id' => $this->request->getPost('teacher_id')
        ]);

        return redirect()->to('/kepala/kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Data Kelas',
            'class'    => $this->classModel->find($id),
            'teachers' => $this->userModel->where('role', 'guru')->findAll()
        ];
        return view('kepala/kelas/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name'       => 'required',
            'teacher_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->classModel->save([
            'id'         => $id,
            'name'       => $this->request->getPost('name'),
            'teacher_id' => $this->request->getPost('teacher_id')
        ]);

        $this->activityLog->log('Update Kelas', "Memperbarui data kelas: " . $this->request->getPost('name'));

        return redirect()->to('/kepala/kelas')->with('success', 'Data kelas berhasil diupdate.');
    }

    public function show($id)
    {
        $class = $this->classModel->select('classes.*, users.name as teacher_name, users.username as teacher_username, users.email as teacher_email')
                                  ->join('users', 'users.id = classes.teacher_id', 'left')
                                  ->find($id);
        
        if (!$class) {
            return redirect()->to('/kepala/kelas')->with('error', 'Data kelas tidak ditemukan.');
        }

        $santriModel = new \App\Models\SantriModel();
        $santris = $santriModel->where('class_id', $id)->findAll();

        $data = [
            'title'   => 'Detail Kelas',
            'class'   => $class,
            'santris' => $santris
        ];

        return view('kepala/kelas/show', $data);
    }

    public function delete($id)
    {
        $class = $this->classModel->find($id);
        $this->classModel->delete($id);
        $this->activityLog->log('Hapus Kelas', "Menghapus data kelas: " . ($class['name'] ?? 'ID ' . $id));
        return redirect()->to('/kepala/kelas')->with('success', 'Data kelas berhasil dihapus.');
    }
}
