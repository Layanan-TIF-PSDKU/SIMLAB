<?php

namespace App\Controllers;


use App\Models\Master\UsersModel;
use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AuthController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Halaman Login | SIPEMA',
        ];
        return view('login', $data);
    }

    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->user
            ->select('users.*, auth_groups_users.group_id, auth_groups.name as role_name')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
            ->where('users.username', $username)
            ->first();

        if (!$user || !password_verify($password, $user->password_hash)) {
            session()->setFlashdata('message', 'Username atau password salah!');
            return redirect()->to(base_url('/'))->withInput();
        }

        session()->set('user_logged_in', [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'role_id'  => $user->group_id,
            'role'     => $user->name,
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function register()
    {
        $data = [
            'title' => 'Halaman Registrasi | SIPEMA',
        ];
        return view('register', $data);
    }

    public function store()
    {
        // Validasi input
        $validationRules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'group_id' => 'required|in_list[1,2,3,4,5,6]', // Validasi untuk role yang tersedia
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    
        $data = [
            'username'      => $this->request->getPost('username'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'        => 1,
        ];
    
        try {
            $this->user->insert($data);
            $user_id = $this->user->getInsertID(); // Ambil ID yang baru saja dimasukkan
            
            if (!$user_id) {
                dd("Gagal mendapatkan ID user setelah insert");
            }
            
            $group_id = $this->request->getPost('group_id');
            
            if (!$group_id) {
                dd("Group ID tidak ditemukan");
            }
            
            // Masukkan ke tabel auth_groups_users
            $db = \Config\Database::connect();
            $insertGroup = $db->table('auth_groups_users')->insert([
                'group_id' => $group_id,
                'user_id'  => $user_id,
            ]);
            
            if (!$insertGroup) {
                dd("Gagal insert ke auth_groups_users", $db->error());
            }
            
            session()->setFlashdata('message', 'Registrasi berhasil! Silakan login.');
            return redirect()->to(base_url('/'));
        } catch (DatabaseException $e) {
            return redirect()->back()->withInput()->with('errors', ['database' => $e->getMessage()]);
        }
    }
}