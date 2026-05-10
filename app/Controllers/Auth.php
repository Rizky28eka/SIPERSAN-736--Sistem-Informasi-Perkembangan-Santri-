<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Controller Autentikasi
 * Menangani: login, logout, lupa password, reset password.
 * Registrasi user dilakukan oleh Kepala (admin) via manajemen guru/wali.
 */
class Auth extends BaseController
{
    // ─── LOGIN ───────────────────────────────────────────────────────────────

    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(session()->get('role') . '/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->where('username', $login)->orWhere('email', $login)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'name'      => $user['name'],
                'email'     => $user['email'],
                'role'      => $user['role'],
                'logged_in' => true,
            ]);
            return redirect()->to($user['role'] . '/dashboard');
        }

        return redirect()->back()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }

    // ─── LUPA PASSWORD ───────────────────────────────────────────────────────

    /**
     * Tampilkan form lupa password
     */
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    /**
     * Proses pengiriman link reset password via email SMTP
     */
    public function sendResetLink()
    {
        $email = $this->request->getPost('email');

        $userModel = new UserModel();
        $user      = $userModel->where('email', $email)->first();

        // Selalu tampilkan pesan sukses (security best practice: jangan bocorkan info email terdaftar)
        $successMsg = 'Jika email Anda terdaftar, link reset password sudah dikirim. Cek inbox/spam Anda.';

        if (!$user) {
            return redirect()->back()->with('success', $successMsg);
        }

        // Buat token unik
        $token     = bin2hex(random_bytes(32));
        $db        = \Config\Database::connect();

        // Hapus token lama milik user ini
        $db->table('password_resets')->where('email', $email)->delete();

        // Simpan token baru
        $db->table('password_resets')->insert([
            'email'      => $email,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Kirim email via SMTP
        $resetUrl = base_url('auth/reset-password/' . $token);
        $emailLib = \Config\Services::email();
        $emailLib->setFrom(getenv('email.SMTPUser') ?: 'noreply@sipersan.com', 'SIPERSAN');
        $emailLib->setTo($email);
        $emailLib->setSubject('Reset Password - SIPERSAN');
        $emailLib->setMessage("
            <h2>Reset Password SIPERSAN</h2>
            <p>Halo <strong>{$user['name']}</strong>,</p>
            <p>Kami menerima permintaan untuk mereset password akun SIPERSAN Anda.</p>
            <p>Klik tombol berikut untuk mereset password (berlaku 1 jam):</p>
            <a href='{$resetUrl}' style='display:inline-block;padding:12px 24px;background:#2563eb;color:white;text-decoration:none;border-radius:8px;font-weight:600;'>Reset Password</a>
            <p>Atau copy link berikut ke browser Anda:<br><small>{$resetUrl}</small></p>
            <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
            <hr>
            <small>SIPERSAN - Sistem Informasi Perkembangan Santri</small>
        ");
        $emailLib->setMailType('html');
        $emailLib->send();

        return redirect()->back()->with('success', $successMsg);
    }

    /**
     * Tampilkan form reset password (setelah klik link di email)
     */
    public function resetPassword(string $token)
    {
        $db     = \Config\Database::connect();
        $record = $db->table('password_resets')->where('token', $token)->get()->getRowArray();

        // Token tidak valid atau expired (1 jam)
        if (!$record || strtotime($record['created_at']) < (time() - 3600)) {
            return redirect()->to('/auth')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }

        return view('auth/reset_password', ['token' => $token, 'email' => $record['email']]);
    }

    /**
     * Proses update password baru
     */
    public function processReset()
    {
        $token           = $this->request->getPost('token');
        $password        = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        // Validasi dasar
        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 8 karakter.');
        }
        if ($password !== $passwordConfirm) {
            return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $db     = \Config\Database::connect();
        $record = $db->table('password_resets')->where('token', $token)->get()->getRowArray();

        if (!$record || strtotime($record['created_at']) < (time() - 3600)) {
            return redirect()->to('/auth')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        // Update password
        $userModel = new UserModel();
        $userModel->where('email', $record['email'])->set([
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ])->update();

        // Hapus token
        $db->table('password_resets')->where('token', $token)->delete();

        return redirect()->to('/auth')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
