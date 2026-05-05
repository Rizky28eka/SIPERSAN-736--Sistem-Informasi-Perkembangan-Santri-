<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Wali extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Data Wali Santri',
            'walis' => $this->userModel->where('role', 'wali')->findAll()
        ];
        return view('kepala/wali/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Wali Santri'
        ];
        return view('kepala/wali/create', $data);
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
            'role'     => 'wali'
        ]);

        return redirect()->to('/kepala/wali')->with('success', 'Data wali berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Wali Santri',
            'wali'  => $this->userModel->find($id)
        ];
        return view('kepala/wali/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'username' => "required|is_unique[users.username,id,{$id}]",
            'name'     => 'required'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'       => $id,
            'username' => $this->request->getPost('username'),
            'name'     => $this->request->getPost('name')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->save($data);

        return redirect()->to('/kepala/wali')->with('success', 'Data wali berhasil diupdate.');
    }

    public function show($id)
    {
        $wali = $this->userModel->where(['id' => $id, 'role' => 'wali'])->first();
        
        if (!$wali) {
            return redirect()->to('/kepala/wali')->with('error', 'Data wali tidak ditemukan.');
        }

        $santriModel = new \App\Models\SantriModel();
        $children = $santriModel->select('santri.*, classes.name as class_name')
                               ->join('classes', 'classes.id = santri.class_id', 'left')
                               ->where('wali_id', $id)
                               ->findAll();

        $data = [
            'title'    => 'Detail Wali Santri',
            'wali'     => $wali,
            'children' => $children
        ];

        return view('kepala/wali/show', $data);
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/kepala/wali')->with('success', 'Data wali berhasil dihapus.');
    }
}
