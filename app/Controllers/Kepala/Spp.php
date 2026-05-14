<?php

namespace App\Controllers\Kepala;

use App\Controllers\BaseController;
use App\Models\SppModel;

class Spp extends BaseController
{
    public function index()
    {
        $sppModel = new SppModel();
        $keyword = $this->request->getGet('keyword');
        
        $data = [
            'title'    => 'Laporan Pembayaran SPP',
            'payments' => $sppModel->getSppWithSantri(null, $keyword),
            'keyword'  => $keyword
        ];

        return view('kepala/spp/index', $data);
    }

    /**
     * Proses pembayaran tunai oleh Admin
     */
    public function payCash()
    {
        $id          = $this->request->getPost('spp_id');
        $amount_paid = $this->request->getPost('amount_paid');
        
        $sppModel     = new SppModel();
        $historyModel = new \App\Models\SppHistoryModel();
        
        $spp = $sppModel->find($id);
        if (!$spp) {
            return redirect()->back()->with('error', 'Tagihan tidak ditemukan');
        }

        // Simpan riwayat pembayaran (Status langsung verified karena diproses admin)
        $historyModel->insert([
            'spp_payment_id'      => $id,
            'amount_paid'         => $amount_paid,
            'payment_method'      => 'cash',
            'proof_note'          => 'Dibayar tunai ke Admin',
            'verification_status' => 'verified',
            'payment_date'        => date('Y-m-d H:i:s'),
        ]);

        // Update total paid and status
        $new_total = $spp['total_paid'] + $amount_paid;
        $status = ($new_total >= $spp['amount']) ? 'lunas' : 'cicilan';

        $updateData = [
            'total_paid' => $new_total,
            'status'     => $status
        ];

        if ($status === 'lunas') {
            $updateData['payment_date'] = date('Y-m-d H:i:s');
        }

        $sppModel->update($id, $updateData);

        // Log activity
        $db = \Config\Database::connect();
        $santri = $db->table('santri')->where('id', $spp['santri_id'])->get()->getRowArray();
        $logModel = new \App\Models\ActivityLogModel();
        $logModel->log('Bayar Tunai SPP', "Admin menerima pembayaran tunai Rp " . number_format($amount_paid, 0, ',', '.') . " untuk " . $santri['name']);

        return redirect()->back()->with('success', 'Pembayaran tunai berhasil dicatat!');
    }
}
