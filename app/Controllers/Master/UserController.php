<?php

namespace App\Controllers\Master;

use CodeIgniter\Controller;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MitraModel;
use App\Models\Master\StafModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Ramsey\Uuid\Uuid;
use Myth\Auth\Password;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new UserModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mitra = new MitraModel();
        $this->staf = new StafModel();
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data User | Sistem Terintegrasi D3 TI',
            'user' => $this->user->getUsers()
        ];
        return view('user/index', $data);
    }

    public function role()
    {
        $data = [
            'title' => 'Data User | Sistem Terintegrasi D3 TI',
            'user' => $this->user->findAll()
        ];
        return view('user/role', $data);
    }
    
    public function update($id)
    {
        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                ]
            ],
            'username' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Username harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'email' => $email,
                'username' => $username,
                'updated_at' => $updated_at
            ];
            $this->user->update($id, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('users');
        } else {
            return view('user/edit', [
                'title' => 'Edit Data Users',
                'validation' => $this->validation,
                'user' => $this->user->find($id)
            ]);
        }
    }

    public function ubah_password($id){
        $data = [
            'title' => 'Ubah Password',
            'validation' => $this->validation,
            'user' => $this->user->getUsers($id),
        ];

        return view('user/ubah-password', $data);
    }

    public function update_password($id){        
        $password = $this->request->getVar('password');
        $old_password = $this->request->getVar('old_password');
        $password_hash = Password::hash($this->request->getVar('new_password'));
        $konfirmasi_pencocokan_password = $this->request->getVar('new_password');
        
        $rules = [
            'old_password' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Password harus diisi",
                ]
            ],
            'new_password' => [
                'rules' => "required|strong_password",
                'errors' => [
                    'required' => "Password harus diisi",
                ]
            ],
            'confirm_new_password' => [
                'rules' => "required|matches[new_password]",
                'errors' => [
                    'required' => "Password harus diisi",
                    'matches' => "Password tidak cocok",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            if(Password::verify($old_password, $password)){
                if($old_password == $konfirmasi_pencocokan_password){
                    session()->setFlashdata('error', 'Password tidak boleh sama');
                    return redirect()->to('user/ubah-password/'. $id);
                } else{
                    $data = [
                        'id' => $id,
                        'password_hash' => $password_hash,
                    ];
                    $this->users->save($data);
                    session()->setFlashdata('success', 'Password berhasil diupdate');
                    return redirect()->to('users');             
                }
            } else {
                session()->setFlashdata('error', 'Password gagal diubah');
                return redirect()->to('user/ubah-password/'. $id);
            } 
        } else {
            return view('user/ubah-password', [
                'title' => 'Ubah Password',
                'validation' => $this->validation,
                'user' => $this->user->getUsers($id),
            ]);
        }
    }
    
    public function delete($id)
    {
        $this->users->delete($id);
        session()->setFlashdata('success', 'Data user berhasil dihapus');
        return redirect()->to('users');
    }
}

?>