<?php

namespace App\Controllers\Master;

use CodeIgniter\Controller;
use App\Models\Master\MahasiswaModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\PermissionModel;
use Ramsey\Uuid\Uuid;
use Myth\Auth\Password;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->mahasiswa = new MahasiswaModel();
        $this->user = new UserModel();
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->validation = \Config\Services::validation();
    }
    
    /* Fungsi untuk menampilkan data mahasiswa pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data Mahasiswa | Sistem Terintegrasi D3 TI',
            'mahasiswa' => $this->mahasiswa->orderBy('nim', 'ASC')->findAll()
        ];
        return view('master/mahasiswa/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Mahasiswa | Sistem Terintegrasi D3 TI',
            'user' => $this->user->findAll(),
            'validation' => $this->validation,
        ];
        
        return view('master/mahasiswa/tambah', $data);
    }

    public function simpan()
    {
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $uuid =  Uuid::uuid4();
        $id_mhs = $uuid->toString();
        $nama_mahasiswa = $this->request->getVar('nama_mahasiswa');
        $username = $this->request->getVar('username');
        $password_hash = Password::hash($this->request->getVar('password'));
        $email = $this->request->getVar('email');
        $nim = $this->request->getVar('nim');
        $prodi = $this->request->getVar('prodi');
        $nomor_telepon = $this->request->getVar('nomor_telepon');
        $tahun_masuk = $this->request->getVar('tahun_masuk');
        $tahun_lulus = $this->request->getVar('tahun_lulus');
        $kelas = $this->request->getVar('kelas');
        $status = $this->request->getVar('status');
        
        $rules = [
            'username' => [
                'label' => "Username",
                'rules' => 'required|is_unique[users.username,id,'.$id_mhs.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'email' => [
                'label' => "Email",
                'rules' => 'required|is_unique[users.email,id,'.$id_mhs.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nama_mahasiswa' => [
                'label' => "Nama Mahasiswa",
                'rules' => 'required|is_unique[mahasiswa.nama,id_mhs,'.$id_mhs.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nim' => [
                'label' => "Bidang",
                'rules' => 'required|is_unique[mahasiswa.nim,id_mhs,'.$id_mhs.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'prodi' => [
                'label' => "Prodi",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'nomor_telepon' => [
                'label' => "Nomor Telepon",
                'rules' => 'required|is_unique[mahasiswa.no_telp,id_mhs,'.$id_mhs.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'tahun_masuk' => [
                'label' => "Tahun Masuk",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'tahun_lulus' => [
                'label' => "Tahun Lulus",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'kelas' => [
                'label' => "Kelas",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'status' => [
                'label' => "Status",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'username' => $username,
                'email' => $email,
                'password_hash' => $password_hash,
                'active' => 1,
            ];
            $this->user->insert($data);
            $this->group->addUserToGroup($this->user->getInsertID(), 2); // id group 2 merupakan id group mahasiswa
            $this->permission->addPermissionToUser(2,$this->user->getInsertID()); // id group 2 merupakan id group mahasiswa

            $data2 = [
                'id_mhs' => $uuid,
                'id_user' => $this->user->getInsertID(),
                'nama' => $nama_mahasiswa,
                'nim' => $nim,
                'prodi' => $prodi,
                'no_telp' => $nomor_telepon,
                'th_masuk' => $tahun_masuk,
                'th_lulus' => $tahun_lulus,
                'kelas' => $kelas,
                'status' => $status,
            ];

            $this->mahasiswa->insert($data2);
            if((string) $uri == 'https://d3ti.myfin.id/mahasiswa/user/simpan'){
                return redirect()->to('users')->with('status_icon', 'success')->with('status_text', 'Data user berhasil ditambah');
            }
            elseif((string) $uri == 'https://d3ti.myfin.id/mahasiswa/simpan'){
                
                return redirect()->to('mahasiswa')->with('status_icon', 'success')->with('status_text', 'Data mahasiswa berhasil ditambah');
            } 
            
        } else {
            return view('master/mahasiswa/tambah', [
                'title' => 'Tambah Data Mahasiswa',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'activePage' => 'mahasiswa',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Mahasiswa | Sistem Terintegrasi D3 TI',
            'mahasiswa' => $this->mahasiswa
                                 ->select('mahasiswa.*, users.*, mahasiswa.status as status_mahasiswa')
                                 ->join('users', 'users.id = mahasiswa.id_user')
                                 ->where('id_mhs', $id)
                                 ->get()
                                 ->getRow(),
            'user' => $this->user->findAll(),
            'activePage' => 'mahasiswa',
            'validation' => $this->validation,
        ];
        return view('master/mahasiswa/edit', $data);
    }
    
    public function update($id = null)
    {
        $uri = new \CodeIgniter\HTTP\URI(); $uri = service('uri'); $uri = current_url(true);
        $id_user = $this->request->getVar('id_user');
        $nama = $this->request->getVar('nama');
        $nim = $this->request->getVar('nim');
        $prodi = $this->request->getVar('prodi');
        $no_telp = $this->request->getVar('no_telp');
        $th_masuk = $this->request->getVar('th_masuk');
        $th_lulus = $this->request->getVar('th_lulus');
        $kelas = $this->request->getVar('kelas');
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
                'rules' => 'required|is_unique[mahasiswa.nama,id_mhs,'.$id.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nim' => [
                'label' => "NIM",
                'rules' => 'required|is_unique[mahasiswa.nim,id_mhs,'.$id.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'prodi' => [
                'label' => "Prodi",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'kelas' => [
                'label' => "Kelas",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'th_masuk' => [
                'label' => "Tahun masuk",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'th_lulus' => [
                'label' => "Tahun masuk",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'no_telp' => [
                'label' => 'Nomor Telepon',
                'rules' => 'required|is_unique[mahasiswa.no_telp,id_mhs,'.$id.']',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
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
            $this->user->save($data_user);

            $data = [
                'id_user' => $id_user,
                'nama' => $nama,
                'nim' => $nim,
                'prodi' => $prodi,
                'no_telp' => $no_telp,
                'th_masuk' => $th_masuk,
                'th_lulus' => $th_lulus,
                'kelas' => $kelas,
                'status' => $status,
            ];
            $this->mahasiswa->save($data);
            
            if((string) $uri == 'https://d3ti.myfin.id/mahasiswa/user/update/'. $id){
                return redirect()->to('users')->with('status_icon', 'success')->with('status_text', 'Data user berhasil diupdate');
            }
            elseif((string) $uri == 'https://d3ti.myfin.id/mahasiswa/update/'. $id){
                return redirect()->to('mahasiswa')->with('status_icon', 'success')->with('status_text', 'Data mahasiswa berhasil diupdate');
            } 
        } else {
            return view('master/mahasiswa/edit', [
                'title' => 'Edit Data Mahasiswa',
                'mahasiswa' => $this->mahasiswa
                                 ->select('mahasiswa.*, users.*, mahasiswa.status as status_mahasiswa')
                                 ->join('users', 'users.id = mahasiswa.id_user')
                                 ->where('id_mhs', $id)
                                 ->get()
                                 ->getRow(),
                'activePage' => 'mahasiswa',
                'validation' => $this->validation,
            ]);
        }
    }

    public function import_data_mahasiswa()
    {
        $validation =  \Config\Services::validation();

        if ($this->request->getMethod() == 'post') {
            $file = $this->request->getFile('file');
            // Validate file uploaded
            $validation->setRules([
                'file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]|max_size[file,1024]'
                ],
            ]);
            if (! $validation->run($this->request->getPost(), '', true)) {
                return redirect()->back()->withInput()->with('validation', $validation);
            }
            try {
                $spreadsheet = IOFactory::load($file->getTempName());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                $header = array_shift($rows);
                foreach ($rows as $row) {
                    $data = [
                        'fakultas' => $row[0],
                        'program_studi' => $row[1],
                        'tahun_akademik' => $row[2],
                        'kode_mata_kuliah' => $row[3],
                        'kelas' => $row[4],
                        'dosen' => $row[5],
                        'nim' => $row[6],
                        'nama_mahasiswa' => $row[7],
                        'nilai_uts' => $row[8],
                        'nilai_uas' => $row[9]
                    ];

                    $this->mahasiswa->insert($data);
                }
                return redirect()->to('mahasiswa')->with('status_icon', 'success')->with('status_text', 'Data mahasiswa berhasil diimport');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
        }
        return view('master/mahasiswa/upload');
    }

    public function hapus($id)
    {
        $data = $this->mahasiswa->find($id);
        $this->mahasiswa->delete($id);
        $this->user->delete($data->id_user);
        return redirect()->to(base_url('mahasiswa'))->with('status_icon', 'success')->with('status_text', 'Data Mahasiswa Berhasil dihapus');
    }

    public function getDataMataKuliah($id_bidang, $id_mhs, $id_sub_bidang = null){
        $data = $this->mahasiswa->getDataMataKuliah($id_bidang, $id_mhs, $id_sub_bidang);
        return json_encode($data);
    }

    public function ubah_password($id_mhs){
        $data = [
            'title' => 'Ubah Password | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'mahasiswa' => $this->mahasiswa->getMahasiswa($id_mhs),
        ];

        return view('master/mahasiswa/ubah-password', $data);
    }

    public function update_password($id_mhs){        
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
                    return redirect()->to('mahasiswa/ubah-password/'. $id_mhs)->with('status_icon', 'error')->with('status_text', 'Password tidak boleh sama');
                } else{
                    $data = [
                        'id' => $id_user,
                        'password_hash' => $password_hash,
                    ];
                    $this->user->save($data);
                    return redirect()->to('mahasiswa')->with('status_icon', 'success')->with('status_text', 'Password berhasil diupdate');           
                    }
                } else {
                    return redirect()->to('mahasiswa/ubah-password/'. $id_mhs)->with('status_icon', 'error')->with('status_text', 'Password gagal diubah');
                } 
        } else {
            return view('master/mahasiswa/ubah-password', [
                'title' => 'Ubah Password',
                'validation' => $this->validation,
                'mahasiswa' => $this->mahasiswa->getMahasiswa($id_mhs),
            ]);
        }
    }
}