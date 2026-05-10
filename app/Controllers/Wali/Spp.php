<?php

namespace App\Controllers\Wali;

use App\Controllers\BaseController;
use App\Models\SppModel;
use App\Models\SppHistoryModel;
use App\Models\SantriModel;

class Spp extends BaseController
{
    public function index()
    {
        $sppModel = new SppModel();
        $historyModel = new SppHistoryModel();
        
        $wali_id = session()->get('user_id');
        
        // Sync overdue status
        $sppModel->checkNunggak();
        
        // Get all SPP for children of this wali
        $payments = $sppModel->getSppWithSantri($wali_id);

        foreach ($payments as &$p) {
            $p['history'] = $historyModel->where('spp_payment_id', $p['id'])
                                       ->orderBy('payment_date', 'DESC')
                                       ->findAll();
        }

        $data = [
            'title' => 'Pembayaran SPP',
            'payments' => $payments
        ];

        return view('wali/spp/index', $data);
    }

    public function history()
    {
        $db = \Config\Database::connect();
        $wali_id = session()->get('user_id');

        $history = $db->table('spp_history')
                      ->select('spp_history.*, santri.name as santri_name, spp_payments.month, spp_payments.year')
                      ->join('spp_payments', 'spp_payments.id = spp_history.spp_payment_id')
                      ->join('santri', 'santri.id = spp_payments.santri_id')
                      ->where('santri.wali_id', $wali_id)
                      ->orderBy('spp_history.payment_date', 'DESC')
                      ->get()
                      ->getResultArray();

        $data = [
            'title'   => 'Riwayat Pembayaran SPP',
            'history' => $history
        ];

        return view('wali/spp/history', $data);
    }

    public function pay()
    {
        $id            = $this->request->getPost('spp_id');
        $amount_paid   = $this->request->getPost('amount_paid');
        $paymentMethod = $this->request->getPost('payment_method') ?? 'cash';
        $proofNote     = $this->request->getPost('proof_note') ?? '';
        
        $sppModel = new SppModel();
        $historyModel = new SppHistoryModel();
        
        $spp = $sppModel->find($id);
        if (!$spp) {
            return redirect()->back()->with('error', 'Tagihan tidak ditemukan');
        }

        // Simpan riwayat pembayaran beserta metode
        $historyModel->insert([
            'spp_payment_id' => $id,
            'amount_paid'    => $amount_paid,
            'payment_method' => in_array($paymentMethod, ['cash', 'transfer', 'qris']) ? $paymentMethod : 'cash',
            'proof_note'     => $proofNote,
            'payment_date'   => date('Y-m-d H:i:s'),
        ]);

        // Update total paid and status
        $new_total = $spp['total_paid'] + $amount_paid;
        $status = ($new_total >= $spp['amount']) ? 'lunas' : 'cicilan';

        $updateData = [
            'total_paid' => $new_total,
            'status' => $status
        ];

        if ($status === 'lunas') {
            $updateData['payment_date'] = date('Y-m-d H:i:s');
        }

        $sppModel->update($id, $updateData);

        // Log activity
        $db = \Config\Database::connect();
        $santri = $db->table('santri')->where('id', $spp['santri_id'])->get()->getRowArray();
        $logModel = new \App\Models\ActivityLogModel();
        $logModel->log('Pembayaran SPP', "Wali santri membayar Rp " . number_format($amount_paid, 0, ',', '.') . " untuk " . $santri['name']);

        return redirect()->to('wali/spp')->with('success', 'Pembayaran berhasil dicatat!');
    }
}
