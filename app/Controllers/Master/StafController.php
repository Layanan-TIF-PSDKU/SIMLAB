<?php

namespace App\Controllers\Master;

use CodeIgniter\Controller;
use App\Models\Master\StafModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Ramsey\Uuid\Uuid;
use Myth\Auth\Password;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class StafController extends Controller
{
    public function __construct()
    {
        $this->users = new UserModel();
        $this->staf = new StafModel();
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    /* Fungsi untuk menampilkan data staf pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data Staf | Sistem Terintegrasi D3 TI',
            'staf' => $this->staf->findAll(),
        ];

        return view('master/staf/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Staf | Sistem Terintegrasi D3 TI',
            'users' => $this->users->findAll(),
            'validation' => $this->validation,
        ];
        
        return view('master/staf/tambah', $data);
    }

    public function store()
    {
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $uuid = Uuid::uuid4();
        $id_staf = $uuid->toString();
        $nama = $this->request->getVar('nama');
        $username = $this->request->getVar('username');
        $password_hash = Password::hash($this->request->getVar('password'));
        $email = $this->request->getVar('email');
        $nip = $this->request->getVar('nip');
        $no_telp = $this->request->getVar('no_telp');
        $alamat = $this->request->getVar('alamat');
        $jenis = $this->request->getVar('jenis');
        $status = $this->request->getVar('status');

        $rules = [
            'username' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Username harus diisi",
                    'is_unique' => "Username yang dimasukan Sudah ada",
                ],
            ],
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                    'is_unique' => "Email yang dimasukan sudah ada",
                ],
            ],
            'nama' => [
                'rules' => "required|is_unique[staf.nama]",
                'errors' => [
                    'required' => "Nama  harus diisi",
                    'is_unique' => "Nama  sudah terdaftar",
                ],
            ],
            'password' => [
                'label' => "Password",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi"
                ]
            ],
            'nip' => [
                'rules' => "required",
                'errors' => [
                    'required' => "NIP harus diisi",
                ],
            ],
            'no_telp' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nomor Telepon harus diisi",
                ],
            ],
            'alamat' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Alamat harus diisi",
                ],
            ],
            'jenis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis harus diisi",
                ],
            ],
            'status' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data_user = [
                'username' => $username,
                'email' => $email,
                'password_hash' => $password_hash,
                'active' => 1,
            ];
            $this->users->insert($data_user);

            if($jenis == "Pimpinan"){
               $this->group->addUserToGroup($this->users->getInsertID(), 5);
               $this->permission->addPermissionToUser(5, $this->users->getInsertID());

                $data_staf = [
                    'id_staf' => $uuid,
                    'id_user' => $this->users->getInsertID(),
                    'nama' => $nama,
                    'nip' => $nip,
                    'no_telp' => $no_telp,
                    'alamat' => $alamat,
                    'jenis' => $jenis,
                    'status' => $status
                ];

                $this->staf->insert($data_staf);
                session()->setFlashdata('success', 'Data Staf berhasil ditambahkan');
                if((string) $uri == 'https://d3ti.myfin.id/staf/user/tambah/store'){
                    return redirect()->to('users');
                }
                elseif((string) $uri == 'https://d3ti.myfin.id/staf/tambah/store'){
                    return redirect()->to('staf');
                }  
            }elseif($jenis == "Dosen"){
                $this->group->addUserToGroup($this->users->getInsertID(), 4);
                $this->permission->addPermissionToUser(4, $this->users->getInsertID());
    
                $data_staf = [
                    'id_staf' => $uuid,
                    'id_user' => $this->users->getInsertID(),
                    'nama' => $nama,
                    'nip' => $nip,
                    'no_telp' => $no_telp,
                    'alamat' => $alamat,
                    'jenis' => $jenis,
                    'status' => $status
                ];

                $this->staf->insert($data_staf);
                session()->setFlashdata('success', 'Data Staf berhasil ditambahkan');
                session()->setFlashdata('success', 'Data Staf berhasil ditambahkan');
                if((string) $uri == 'https://d3ti.myfin.id/staf/user/tambah/store'){
                    return redirect()->to('users');
                }
                elseif((string) $uri == 'https://d3ti.myfin.id/staf/tambah/store'){
                    return redirect()->to('staf');
                }  
            }elseif($jenis == "Laboran"){
                $this->group->addUserToGroup($this->users->getInsertID(), 6);
                $this->permission->addPermissionToUser(6, $this->users->getInsertID());

                $data_staf = [
                    'id_staf' => $uuid,
                    'id_user' => $this->users->getInsertID(),
                    'nama' => $nama,
                    'nip' => $nip,
                    'no_telp' => $no_telp,
                    'alamat' => $alamat,
                    'jenis' => $jenis,
                    'status' => $status
                ];

                $this->staf->insert($data_staf);
                if((string) $uri == 'https://d3ti.myfin.id/staf/user/tambah/store'){
                    session()->setFlashdata('success', 'Data user berhasil ditambahkan');
                    return redirect()->to('users');
                }
                elseif((string) $uri == 'https://d3ti.myfin.id/staf/tambah/store'){
                    session()->setFlashdata('success', 'Data staf berhasil ditambahkan');
                    return redirect()->to('staf');
                }  
            }
        } else {
            return view('master/staf/tambah', [
                'title' => 'Tambah Data Staf',
                'users' => $this->users->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_staf)
    {
        $data = [
            'title' => 'Edit Data Staf | Sistem Terintegrasi D3 TI',
            'staf' => $this->staf->select('users.*, staf.*, staf.status as status_staf')
                                 ->join('users', 'users.id = staf.id_user')
                                 ->where('id_staf', $id_staf)
                                 ->get()
                                 ->getRow(),
            // 'staf' => $this->staf->getStaf($id_staf),
            // 'staf' => $this->staf->findAll(),
            'users' => $this->users->findAll(),
            'activePage' => 'staf',
            'validation' => $this->validation,
        ];

        return view('master/staf/edit', $data);
    }

    public function update($id_staf)
    {
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $id_user = $this->request->getVar('id_user');
        $nama = $this->request->getVar('nama');
        $nip = $this->request->getVar('nip');
        $no_telp = $this->request->getVar('no_telp');
        $alamat = $this->request->getVar('alamat');
        $jenis = $this->request->getVar('jenis');
        $status = $this->request->getVar('status');
        $username = $this->request->getVar('username');
        $email = $this->request->getVar('email');

        $rules = [
            'username' => [
                'rules' => 'required|is_unique[users.username,id,'.$id_user.']',
                'errors' => [
                    'required' => "Username harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'email' => [
                'rules' => 'required|is_unique[users.email,id,'.$id_user.']',
                'errors' => [
                    'required' => "Email harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nama' => [
                'label' => "Nama Staf",
                'rules' => 'required|is_unique[staf.nama,id_staf,'.$id_staf.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nip' => [
                'label' => "NIP",
                'rules' => 'required|is_unique[staf.nip,id_staf,'.$id_staf.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon|is_unique[staf.no_telp,id_staf,'.$id_staf.']',
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'alamat' => [
                'label' => "Alamat",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'jenis' => [
                'label' => "Jenis",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'status' => [
                'label' => "Status",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                   
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
                'id_user' => $id_user,
                'nama' => $nama,
                'nip' => $nip,
                'no_telp' => $no_telp,
                'alamat' => $alamat,
                'jenis' => $jenis,
                'status' => $status,
            ];
            $this->staf->save($data);

            if((string) $uri == 'https://d3ti.myfin.id/staf/user/update/'. $id_staf){
                session()->setFlashdata('success', 'Data user berhasil diupdate');
                return redirect()->to('users');
            }
            elseif((string) $uri == 'https://d3ti.myfin.id/staf/update/'. $id_staf){
                session()->setFlashdata('success', 'Data staf berhasil diupdate');
                return redirect()->to('staf');
            } 
        } else {
            return view('master/staf/edit', [
                'title' => 'Edit Data staf',
                'staf' => $this->staf->select('users.*, staf.*, staf.status as status_staf')
                                     ->join('users', 'users.id = staf.id_user')
                                     ->where('id_staf', $id_staf)
                                     ->get()
                                     ->getRow(),
                'users' => $this->users->findAll(),                
                'activePage' => 'staf',
                'validation' => $this->validation,
            ]);
        }
    }

    public function delete($id_staf)
    {
        $data = $this->staf->find($id_staf);
        $this->staf->delete($id_staf);
        $this->users->delete($data->id_user);
        return redirect()->to('staf')->with('status_icon', 'success')->with('status_text', 'Data staf Berhasil dihapus');;
    }

    public function ubah_password($id_staf){
        $data = [
            'title' => 'Ubah Password | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'staf' => $this->staf->getStaf($id_staf),
        ];

        return view('master/staf/ubah-password', $data);
    }

    public function update_password($id_staf){        
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
                    return redirect()->to('staf/ubah-password/'. $id_staf);
                } else{
                    $data = [
                        'id' => $id_user,
                        'password_hash' => $password_hash,
                    ];
                    $this->users->save($data);
                    session()->setFlashdata('success', 'Password berhasil diupdate');
                    return redirect()->to('staf');             
                }
            } else {
                session()->setFlashdata('error', 'Password gagal diubah');
                return redirect()->to('staf/ubah-password/'. $id_staf);
            } 
        } else {
            return view('master/staf/ubah-password', [
                'title' => 'Ubah Password',
                'validation' => $this->validation,
                'staf' => $this->staf->getStaf($id_staf),
            ]);
        }
    }
}