<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\AnnouncementModel;

class Announcements extends BaseController
{
    protected $announcementModel;
    protected $activityLog;

    public function __construct()
    {
        $this->announcementModel = new AnnouncementModel();
        $this->activityLog = new \App\Models\ActivityLogModel();
    }

    public function index()
    {
        $data = [
            'title'         => 'Manajemen Pengumuman',
            'announcements' => $this->announcementModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('kepala/announcements/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengumuman'
        ];
        return view('kepala/announcements/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required',
            'content'     => 'required',
            'target_role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->announcementModel->save([
            'title'       => $this->request->getPost('title'),
            'content'     => $this->request->getPost('content'),
            'target_role' => $this->request->getPost('target_role'),
            'created_by'  => session()->get('user_id'),
        ]);

        $this->activityLog->log('Tambah Pengumuman', "Menerbitkan pengumuman baru: " . $this->request->getPost('title'));

        return redirect()->to('/kepala/announcements')->with('success', 'Pengumuman berhasil diterbitkan.');
    }

    public function edit($id)
    {
        $data = [
            'title'        => 'Edit Pengumuman',
            'announcement' => $this->announcementModel->find($id)
        ];
        return view('kepala/announcements/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'title'       => 'required',
            'content'     => 'required',
            'target_role' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->announcementModel->save([
            'id'          => $id,
            'title'       => $this->request->getPost('title'),
            'content'     => $this->request->getPost('content'),
            'target_role' => $this->request->getPost('target_role'),
        ]);

        $this->activityLog->log('Update Pengumuman', "Memperbarui pengumuman: " . $this->request->getPost('title'));

        return redirect()->to('/kepala/announcements')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function delete($id)
    {
        $anc = $this->announcementModel->find($id);
        $this->announcementModel->delete($id);
        $this->activityLog->log('Hapus Pengumuman', "Menghapus pengumuman: " . ($anc['title'] ?? 'ID ' . $id));
        return redirect()->to('/kepala/announcements')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
