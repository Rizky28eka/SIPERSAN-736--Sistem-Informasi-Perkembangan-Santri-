<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Guru extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Data Guru',
            'gurus' => $this->userModel->where('role', 'guru')->findAll()
        ];
        return view('kepala/guru/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Data Guru'];
        return view('kepala/guru/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[6]',
            'name'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'name'     => $this->request->getPost('name'),
            'role'     => 'guru'
        ]);

        return redirect()->to('/kepala/guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Guru',
            'guru'  => $this->userModel->find($id)
        ];
        return view('kepala/guru/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'username' => "required|is_unique[users.username,id,{$id}]",
            'name'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'       => $id,
            'username' => $this->request->getPost('username'),
            'name'     => $this->request->getPost('name'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->save($data);

        return redirect()->to('/kepala/guru')->with('success', 'Data guru berhasil diupdate.');
    }

    public function show($id)
    {
        $guru = $this->userModel->where(['id' => $id, 'role' => 'guru'])->first();
        
        if (!$guru) {
            return redirect()->to('/kepala/guru')->with('error', 'Data guru tidak ditemukan.');
        }

        $classModel = new \App\Models\ClassModel();
        $classes = $classModel->where('teacher_id', $id)->findAll();

        $santriModel = new \App\Models\SantriModel();
        foreach ($classes as &$c) {
            $c['total_santri'] = $santriModel->where('class_id', $c['id'])->countAllResults();
        }

        $data = [
            'title'   => 'Detail Pengajar',
            'guru'    => $guru,
            'classes' => $classes
        ];

        return view('kepala/guru/show', $data);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/kepala/guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
