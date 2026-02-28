<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        // Menampilkan halaman login
        return view('auth/login_view');
    }

    public function processLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil, set session
            session()->set([
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ]);
            return redirect()->to('/dashboard');
        }

        // Jika login gagal
        session()->setFlashdata('error', 'Username atau Password salah.');
        return redirect()->back();
    }

    public function register()
    {
        // Menampilkan halaman register
        return view('auth/register_view');
    }

    public function processRegister()
    {
        $userModel = new UserModel();
        
        // Aturan validasi
        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[5]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        // Simpan data pengguna baru (tanpa hash, karena Model yang akan melakukannya)
        $userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role'     => 'user', // Default role
        ]);

        session()->setFlashdata('success', 'Registrasi berhasil! Silakan login.');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
