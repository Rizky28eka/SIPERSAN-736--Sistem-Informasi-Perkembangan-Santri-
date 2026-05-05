<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(session()->get('role') . '/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('username', $login)
                ->orWhere('email', $login)
                ->first();

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'name'      => $user['name'],
                'role'      => $user['role'],
                'logged_in' => true,
            ];
            session()->set($sessionData);

            return redirect()->to($user['role'] . '/dashboard');
        }

        return redirect()->back()->with('error', 'Username or Password incorrect');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
