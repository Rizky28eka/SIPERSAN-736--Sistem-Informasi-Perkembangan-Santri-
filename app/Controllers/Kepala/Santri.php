<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Santri extends BaseController
{
    protected $santriModel;
    protected $classModel;
    protected $userModel;
    protected $activityLog;

    public function __construct()
    {
        $this->santriModel = new \App\Models\SantriModel();
        $this->classModel = new \App\Models\ClassModel();
        $this->userModel = new \App\Models\UserModel();
        $this->activityLog = new \App\Models\ActivityLogModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->santriModel->select('santri.*, classes.name as class_name, users.name as wali_name')
                                      ->join('classes', 'classes.id = santri.class_id', 'left')
                                      ->join('users', 'users.id = santri.wali_id', 'left');

        if ($keyword) {
            $builder->groupStart()
                    ->like('santri.name', $keyword)
                    ->orLike('santri.nisn', $keyword)
                    ->orLike('classes.name', $keyword)
                    ->orLike('users.name', $keyword)
                    ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Data Santri',
            'santris' => $builder->findAll(),
            'keyword' => $keyword
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
            'class_id' => 'required',
            'gender'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $santriId = $this->santriModel->insert([
            'name'               => $this->request->getPost('name'),
            'nickname'           => $this->request->getPost('nickname'),
            'nisn'               => $this->request->getPost('nisn'),
            'gender'             => $this->request->getPost('gender'),
            'birth_place'        => $this->request->getPost('birth_place'),
            'birth_date'         => $this->request->getPost('birth_date') ?: null,
            'child_order'        => $this->request->getPost('child_order') ?: null,
            'child_status'       => $this->request->getPost('child_status'),
            'enter_tka_a'        => $this->request->getPost('enter_tka_a') ?: null,
            'enter_tka_b'        => $this->request->getPost('enter_tka_b') ?: null,
            'exit_tka_a'         => $this->request->getPost('exit_tka_a') ?: null,
            'exit_tka_b'         => $this->request->getPost('exit_tka_b') ?: null,
            'agama'              => $this->request->getPost('agama') ?: 'Islam',
            'parent_education'   => $this->request->getPost('parent_education'),
            'parent_occupation'  => $this->request->getPost('parent_occupation'),
            'class_id'           => $this->request->getPost('class_id'),
            'wali_id'            => $this->request->getPost('wali_id') ?: null,
            'address'            => $this->request->getPost('address'),
        ]);

        if ($santriId) {
            $this->syncSpp($santriId);
            $this->activityLog->log('Tambah Santri', "Menambahkan santri baru: " . $this->request->getPost('name'));
        }

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
        $rules = ['name' => 'required', 'class_id' => 'required', 'gender' => 'required'];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->santriModel->save([
            'id'                 => $id,
            'name'               => $this->request->getPost('name'),
            'nickname'           => $this->request->getPost('nickname'),
            'nisn'               => $this->request->getPost('nisn'),
            'gender'             => $this->request->getPost('gender'),
            'birth_place'        => $this->request->getPost('birth_place'),
            'birth_date'         => $this->request->getPost('birth_date') ?: null,
            'child_order'        => $this->request->getPost('child_order') ?: null,
            'child_status'       => $this->request->getPost('child_status'),
            'enter_tka_a'        => $this->request->getPost('enter_tka_a') ?: null,
            'enter_tka_b'        => $this->request->getPost('enter_tka_b') ?: null,
            'exit_tka_a'         => $this->request->getPost('exit_tka_a') ?: null,
            'exit_tka_b'         => $this->request->getPost('exit_tka_b') ?: null,
            'agama'              => $this->request->getPost('agama') ?: 'Islam',
            'parent_education'   => $this->request->getPost('parent_education'),
            'parent_occupation'  => $this->request->getPost('parent_occupation'),
            'class_id'           => $this->request->getPost('class_id'),
            'wali_id'            => $this->request->getPost('wali_id') ?: null,
            'address'            => $this->request->getPost('address'),
        ]);

        $this->syncSpp($id);
        $this->activityLog->log('Update Santri', "Memperbarui data santri: " . $this->request->getPost('name'));

        return redirect()->to('/kepala/santri')->with('success', 'Data santri berhasil diupdate.');
    }

    /**
     * Export data santri ke CSV sesuai format Kartu Data Santri TKA/TPA
     */
    public function export()
    {
        $santris = $this->santriModel
            ->select('santri.*, classes.name as class_name, users.name as wali_name')
            ->join('classes', 'classes.id = santri.class_id', 'left')
            ->join('users', 'users.id = santri.wali_id', 'left')
            ->orderBy('santri.name', 'ASC')
            ->findAll();

        $filename = 'DataSantri_' . date('Ymd_His') . '.csv';

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // BOM untuk Excel agar UTF-8 terbaca dengan benar
        echo "\xEF\xBB\xBF";

        $out = fopen('php://output', 'w');

        // Header CSV sesuai kolom Kartu Data Santri TKA/TPA
        fputcsv($out, [
            'No', 'Nama Lengkap', 'Nama Panggilan', 'NIS', 'Jenis Kelamin',
            'Tempat Lahir', 'Tanggal Lahir', 'Anak Ke-', 'Status Anak',
            'Masuk Paket A', 'Masuk Paket B', 'Keluar Paket A', 'Keluar Paket B',
            'Agama', 'Alamat', 'Nama Wali', 'Pendidikan Ortu', 'Pekerjaan Ortu',
            'Kelas'
        ]);

        foreach ($santris as $i => $s) {
            fputcsv($out, [
                $i + 1,
                $s['name'],
                $s['nickname'] ?? '-',
                $s['nisn'] ?? '-',
                $s['gender'] === 'L' ? 'Laki-laki' : 'Perempuan',
                $s['birth_place'] ?? '-',
                !empty($s['birth_date']) ? date('d/m/Y', strtotime($s['birth_date'])) : '-',
                $s['child_order'] ?? '-',
                $s['child_status'] ?? '-',
                !empty($s['enter_tka_a']) ? date('d/m/Y', strtotime($s['enter_tka_a'])) : '-',
                !empty($s['enter_tka_b']) ? date('d/m/Y', strtotime($s['enter_tka_b'])) : '-',
                !empty($s['exit_tka_a'])  ? date('d/m/Y', strtotime($s['exit_tka_a']))  : '-',
                !empty($s['exit_tka_b'])  ? date('d/m/Y', strtotime($s['exit_tka_b']))  : '-',
                $s['agama'] ?? 'Islam',
                $s['address'] ?? '-',
                $s['wali_name'] ?? '-',
                $s['parent_education'] ?? '-',
                $s['parent_occupation'] ?? '-',
                $s['class_name'] ?? '-',
            ]);
        }

        fclose($out);
        exit;
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
        $santri = $this->santriModel->find($id);
        $this->santriModel->delete($id);
        $this->activityLog->log('Hapus Santri', "Menghapus data santri: " . ($santri['name'] ?? 'ID ' . $id));
        return redirect()->to('/kepala/santri')->with('success', 'Data santri berhasil dihapus.');
    }

    private function syncSpp($santriId)
    {
        $db = \Config\Database::connect();
        $sppModel = new \App\Models\SppModel();
        
        $santri = $this->santriModel->find($santriId);
        $class = $this->classModel->find($santri['class_id']);
        
        if (!$class) return;

        $month = date('n');
        $year = date('Y');
        
        $exists = $sppModel->where([
            'santri_id' => $santriId,
            'month' => $month,
            'year' => $year
        ])->first();

        if ($exists) {
            // Update existing bill if not lunas
            if ($exists['status'] !== 'lunas') {
                $sppModel->update($exists['id'], ['amount' => $class['spp_price']]);
            }
        } else {
            // Create new bill
            $sppModel->insert([
                'santri_id' => $santriId,
                'month' => $month,
                'year' => $year,
                'due_date' => date('Y-m-10'),
                'amount' => $class['spp_price'],
                'total_paid' => 0,
                'status' => 'belum'
            ]);
        }
    }
}
