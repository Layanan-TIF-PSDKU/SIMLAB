<?php

namespace App\Controllers\Master;

use CodeIgniter\Controller;
use App\Models\Master\MitraModel;
use App\Models\Master\JenisMitraModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Ramsey\Uuid\Uuid;
use Myth\Auth\Password;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class MitraController extends Controller
{
    public function __construct()
    {
        $this->users = new UserModel();
        $this->mitra = new MitraModel();
        $this->jenis = new JenisMitraModel();
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mitra | Sistem Terintegrasi D3 TI',
            'mitra' => $this->mitra->findAll(),
        ];
        
        return view('master/mitra/index', $data);
    }

    public function create(){
        $data = [
            'title' => 'Tambah Data Mitra | Sistem Terintegrasi D3 TI',
            'users' => $this->users->findAll(),
            'validation' => $this->validation
        ];

        return view('master/mitra/tambah', $data);
    }
    
    public function store(){
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $uuid =  Uuid::uuid4();
        $id_mitra = $uuid->toString();
        $id_mitra_detail = Uuid::uuid4()->toString();
        $username = $this->request->getVar('username');
        $password_hash = Password::hash($this->request->getVar('password'));
        $email = $this->request->getVar('email');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $nama_pimpinan = $this->request->getVar('nama_pimpinan');
        $nama_mentor = $this->request->getVar('nama_mentor');
        $jenis = $this->request->getVar('jenis');
        $alamat = $this->request->getVar('alamat');
        $no_telp = $this->request->getVar('no_telp');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'username' => [
                'rules' => "required|is_unique[users.username]",
                'errors' => [
                    'required' => "Username harus diisi",
                    'is_unique' => "Username yang dimasukan Sudah ada"
                    ]
            ],
            'password' => [
                'label' => "Password",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi"
                ]
            ],
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                    'is_unique' => "Email yang dimasukan sudah ada"
                    ]
            ],
            'nama_instansi' => [
                'rules' => "required|is_unique[mitra.nama_instansi]",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                    'is_unique' => "Nama Instansi sudah terdaftar"
                ]
            ],
            'nama_pimpinan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Pimpinan harus diisi",
                    ]
            ],
            'nama_mentor' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Mentor harus diisi",
                ]
            ],
            'jenis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis Mitra harus diisi",
                ]
            ],
            'alamat' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Alamat harus diisi",
                ]
            ],
            'no_telp' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nomor Telepon harus diisi",
                    ]
                ],
            ];
            
        if($this->validate($rules)) {
            $data_user = [
                'username' => $username,
                'email' => $email,
                'password_hash' => $password_hash,
                'active' => 1,
            ];
            $this->users->insert($data_user);
            $this->group->addUserToGroup($this->users->getInsertID(), 3);
            $this->permission->addPermissionToUser(3, $this->users->getInsertID());
            $data_mitra = [
                'id_mitra' => $uuid,
                'id_user' => $this->users->getInsertID(),
                'nama_instansi' => $nama_instansi,
                'nama_mentor' => $nama_mentor,
                'nama_pimpinan' => $nama_pimpinan,
                'alamat' => $alamat,
                'no_telp' => $no_telp,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->mitra->insert($data_mitra);
            
            $data_arr = [];
            for($i = 0; $i < count($jenis); $i++){
                $data_jenis = array(
                    'id_mitra_detail' => $id_mitra_detail++,
                    'id_mitra' => $id_mitra,
                    'jenis' => $jenis[$i],
                );
                $data_arr[] = $data_jenis;
            }
            $this->jenis->insertBatch($data_arr);

            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            if((string) $uri == 'https://d3ti.myfin.id/mitra/user/tambah/store'){
                return redirect()->to('users');
            }
            elseif((string) $uri == 'https://d3ti.myfin.id/mitra/tambah/store'){
                return redirect()->to('mitra');
            }  
        } else {
            return view('master/mitra/tambah', [
                'title' => 'Tambah Data Mitra',
                'users' => $this->users->findAll(),
                'validation' => $this->validation
            ]);
        }
    }

    public function edit($id_mitra)
    {
        $data = [
            'title' => 'Edit Data Mitra | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'mitra' => $this->mitra->getMitra($id_mitra),
            'jenis' => array_column($this->mitra->getIdMitra($id_mitra), 'jenis'),
            'users' => $this->users->findAll(),
        ];

        return view('master/mitra/edit', $data);
    }

    public function update($id_mitra)
    {
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $id_user = $this->request->getVar('id_user');
        $id_mitra = $this->request->getVar('id_mitra');
        $id_mitra_detail = $this->request->getVar('id_mitra_detail');
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $nama_pimpinan = $this->request->getVar('nama_pimpinan');
        $nama_mentor = $this->request->getVar('nama_mentor');
        $jenis = $this->request->getVar('jenis');
        $alamat = $this->request->getVar('alamat');
        $no_telp = $this->request->getVar('no_telp');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'username' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Username harus diisi",
                ]
            ],
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                    'is_unique' => "Email yang dimasukan sudah ada"
                ]
            ],
            'nama_instansi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ]
            ],
            'nama_pimpinan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Pimpinan harus diisi",
                ]
            ],
            'nama_mentor' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Mentor harus diisi",
                ]
            ],
            'jenis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis Mitra harus diisi",
                ]
            ],
            'alamat' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Alamat harus diisi",
                ]
            ],
            'no_telp' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Nomor Telepon harus diisi",
                    ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data_user = [
                'id' => $id_user,
                'username' => $username,
                'email' => $email,
            ];
            $this->users->save($data_user);
            
            $data = [
                'id_mitra' => $id_mitra,
                'nama_instansi' => $nama_instansi,
                'nama_mentor' => $nama_mentor,
                'nama_pimpinan' => $nama_pimpinan,
                'alamat' => $alamat,
                'no_telp' => $no_telp,
                'updated_at' => $updated_at,
            ];
            $this->mitra->save($data);

            $this->jenis->where('id_mitra', $id_mitra)->delete();

            $data_arr = [];
            for($i = 0; $i < count($jenis); $i++){
                $data_jenis = array(
                    'id_mitra_detail' => Uuid::uuid4()->toString(),
                    'id_mitra' => $id_mitra,
                    'jenis' => $jenis[$i],
                );
                $data_arr[] = $data_jenis;
            }

            $this->jenis->insertBatch($data_arr);

            if((string) $uri == 'https://d3ti.myfin.id/mitra/user/update/'. $id_mitra){
                session()->setFlashdata('success', 'Data user berhasil diupdate');
                return redirect()->to('users');
            }
            elseif((string) $uri == 'https://d3ti.myfin.id/mitra/update/'. $id_mitra){
                session()->setFlashdata('success', 'Data mitra berhasil diupdate');
                return redirect()->to('mitra');
            }  
        } else {
            return view('master/mitra/edit', [
                'title' => 'Edit Data Mitra',
                'validation' => $this->validation,
                'mitra' => $this->mitra->getMitra($id_mitra),
                'users' => $this->users->findAll(),
            ]);
        }
    }

    public function delete($id_mitra)
    {
        $mitra = $this->mitra->find($id_mitra);
        // $this->mitra->delete($id_mitra);
        $this->users->delete($mitra->id_user);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('mitra');
    }

    public function ubah_password($id_mitra){
        $data = [
            'title' => 'Ubah Password | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'mitra' => $this->mitra->getMitra($id_mitra),
            // 'users' => $this->users->findAll(),
        ];

        return view('master/mitra/ubah-password', $data);
    }

    public function update_password($id_mitra){        
        $id_user = $this->request->getVar('id_user');
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
                       return redirect()->to('mitra/ubah-password/'. $id_mitra);
                    } else{
                        $data = [
                            'id' => $id_user,
                            'password_hash' => $password_hash,
                        ];
                        $this->users->save($data);
                        session()->setFlashdata('success', 'Password berhasil diupdate');
                        return redirect()->to('mitra');             
                    }
                } else {
                    session()->setFlashdata('error', 'Password gagal diubah');
                    return redirect()->to('mitra/ubah-password/'. $id_mitra);
                } 
        } else {
            return view('master/mitra/ubah-password', [
                'title' => 'Ubah Password',
                'validation' => $this->validation,
                'mitra' => $this->mitra->getMitra($id_mitra),
                // 'users' => $this->users->findAll(),
            ]);
        }
    }
}

?>