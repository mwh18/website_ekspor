<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'page_title' => 'Kelola Pengguna',
            'users'      => $this->userModel->findAll(),
        ];
        return view('users/index', $data);
    }

 
    public function create()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $data = [
            'page_title' => 'Tambah Pengguna Baru',
            'validation' => \Config\Services::validation()
        ];
        return view('users/create', $data);
    }

    public function store()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'username' => 'required|is_unique[users.username]',
            'password' => 'required|min_length[5]',
            'role'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/users/new')->withInput();
        }

        // --- PERUBAHAN DI SINI ---
        // Hapus password_hash(). Biarkan UserModel yang mengenkripsi secara otomatis.
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), // <- HASH DIHAPUS
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('success', 'Pengguna baru berhasil ditambahkan.');
        return redirect()->to('/users');
    }

    // Menghapus pengguna
    public function delete($id)
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard');
        }

        // Mencegah admin menghapus akunnya sendiri
        if ($id == session()->get('user_id')) {
            session()->setFlashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return redirect()->to('/users');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Pengguna berhasil dihapus.');
        return redirect()->to('/users');
    }
}
