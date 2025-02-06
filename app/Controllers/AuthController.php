<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->user = new UserModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Halaman Login | SIPEMA',
            // 'mahasiswa' => $this->MahasiswaModel->findAll()
        ];
        return view('login', $data);
    }

    public function auth()
    {

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->user->where('username', $username)->first();

        if (!$user) {
            session()->setFlashdata('message', 'Email atau password salah!');
            return redirect()->to(base_url('/'));
        }
        
        if (!password_verify($password, $user->password)) {
            session()->setFlashdata('message', 'Email atau password salah!');
            return redirect()->to(base_url('/'));
        }
        session()->set('user_logged_in', [
            'id_user' => $user->id_user,
            'username' => $user->username,
            'email' =>$user->email,
            'role' => $user->role,
        ]);
        // check role user
        switch ($user->role) {
        case 'admin':
            return redirect()->to(base_url('dashboard'));
            break;
        case 'dosen':
            return "Hai";
            break;
        case 'pimpinan':
            return "Yay";
            break;
        default:
        break;
        }
    }

}