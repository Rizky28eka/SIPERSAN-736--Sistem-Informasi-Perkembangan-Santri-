<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\ClassModel;

class MasterSpp extends BaseController
{
    protected $classModel;
    protected $activityLog;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->activityLog = new \App\Models\ActivityLogModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Pengaturan Biaya SPP',
            'classes' => $this->classModel->select('classes.*, users.name as teacher_name')
                                           ->join('users', 'users.id = classes.teacher_id', 'left')
                                           ->findAll()
        ];
        return view('kepala/master-spp/index', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('class_id');
        $price = $this->request->getPost('spp_price');

        if (!$id || !$price) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        $this->classModel->update($id, [
            'spp_price' => $price
        ]);

        // Synchronize with existing unpaid bills
        $db = \Config\Database::connect();
        
        // 1. Update amount for all bills that are NOT lunas for students in this class
        $db->table('spp_payments')
           ->where('status !=', 'lunas')
           ->whereIn('santri_id', function($builder) use ($id) {
               return $builder->select('id')->from('santri')->where('class_id', $id);
           })
           ->update(['amount' => $price]);

        // 2. Recalculate status for 'cicilan' or 'belum' in case the new price is lower than total_paid
        $db->query("UPDATE spp_payments SET status = 'lunas', payment_date = NOW() 
                    WHERE status IN ('belum', 'cicilan', 'nunggak') 
                    AND total_paid >= amount 
                    AND santri_id IN (SELECT id FROM santri WHERE class_id = $id)");

        $class = $this->classModel->find($id);
        $this->activityLog->log('Update SPP', "Memperbarui biaya SPP kelas " . $class['name'] . " menjadi Rp " . number_format($price, 0, ',', '.'));

        return redirect()->to('/kepala/master-spp')->with('success', 'Biaya SPP berhasil diperbarui dan disinkronkan dengan tagihan aktif.');
    }
}
