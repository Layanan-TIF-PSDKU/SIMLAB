<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\BerkasTAModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BerkasController extends BaseController
{
    public function __construct()
    {
        $this->berkas = new BerkasTAModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
{
    // Get the selected 'kategori' value from the POST request
    $kategori = $this->request->getPost('kategori');

    $data = [
        'title' => 'Berkas Tugas Akhir',
        'berkas' => $this->berkas->findAll(),
        'kategori' => $kategori, // Pass the 'kategori' value to the view
        'activePage' => 'berkas',
    ];
    
    return view('simta/berkas/index', $data);
}


    public function tambah()
    {
        $data = [
            'title' => 'Tambah Berkas Tugas Akhir',
            'berkas' => $this->berkas->findAll(),
            'activePage' => 'berkas',
            'validation' => $this->validation,
            
        ];

        return view('simta/berkas/tambah', $data);
    }

    public function simpan()
    {
        $validation = \Config\Services::validation();
        $uuid = Uuid::uuid4();
        $id_berkas = $uuid->toString();
        $nama_berkas = $this->request->getVar('nama_berkas');
        $kategori = $this->request->getVar('kategori');
        $keterangan = $this->request->getVar('keterangan');
        $file_berkas = $this->request->getFile('file_berkas');
        $file_berkasName = $file_berkas->getRandomName();
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'nama_berkas' => [
                'label' => "nama_berkas",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'kategori' => [
                'label' => "kategori",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'keterangan' => [
                'label' => "keterangan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'file_berkas' => [
                'rules' => "ext_in[file_berkas,pdf]|max_size[file_berkas,2048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_berkas' => $uuid,
                'nama_berkas' => $nama_berkas,
                'kategori' => $kategori,
                'keterangan' => $keterangan,
                'file_berkas' => $file_berkasName,
            ];
            //dd($data);
            $this->berkas->insert($data);
            $file_berkas->move('simta_assets/berkas/', $file_berkasName);
            session()->setFlashdata('success', 'Data Berkas Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/berkas');
        } else {
            return view('simta/berkas/tambah', [
                'title' => 'Tambah Berkas',
                'activePage' => 'berkas',
                'validation' => $this->validation,
            ]);
        }
    }
    public function edit($id_berkas)
    {
        $data = [
            'title' => 'Edit Data Berkas Tugas Akhir',
            'berkas' => $this->berkas->find($id_berkas),
            'activePage' => 'berkas',
            'validation' => $this->validation,
        ];
        return view('simta/berkas/edit', $data);
    }
    public function update($id_berkas)
    {
        $nama_berkas = $this->request->getVar('nama_berkas');
        $kategori = $this->request->getVar('kategori'); 
        $keterangan = $this->request->getVar('keterangan');         
        $file_berkas = $this->request->getFile('file_berkas');
        $file_berkasName = $file_berkas->getRandomName();  
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'nama_berkas' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ],
            ],
            'kategori' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ],
            ],
            'keterangan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ],
            ],
            'file_berkas' => [
                'rules' => "ext_in[file_berkas,pdf]|max_size[file_berkas,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        
        $bks = $this->berkas->find($id_berkas);
        if ($this->validate($rules)) {
            if($file_berkas->isValid() && !$file_berkas->hasMoved())
            {
                $old_berkas = $bks->file_berkas;
                if(file_exists('simta_assets/berkas/' . $old_berkas)){
                    unlink('simta_assets/berkas/' . $old_berkas);
                }
                $file_berkasName = $file_berkas->getRandomName();
                $data = [
                    'nama_berkas' => $nama_berkas,
                    'kategori' => $kategori,
                    'keterangan' => $keterangan,
                    'file_berkas' => $file_berkasName,
                    'updated_at' => $updated_at,
                ];
                //dd($data);
                $this->berkas->update($id_berkas, $data);
                $file_berkas->move('simta_assets/berkas/', $file_berkasName);
                session()->setFlashdata('success', 'Data Berkas Tugas Akhir Berhasil Diubah');
                return redirect()->to('simta/berkas');
            } else {
                $data = [
                    'nama_berkas' => $nama_berkas,
                    'kategori' => $kategori,
                    'keterangan' => $keterangan,
                    'updated_at' => $updated_at,
                ];
    
                $this->berkas->update($id_berkas, $data);
                session()->setFlashdata('success', 'Data Berkas Tugas Akhir Berhasil Diubah');
                return redirect()->to('simta/berkas');
            }
        } else {
            return view('simta/berkas/edit', [
                'title' => 'Edit Data Berkas',
                'validation' => $this->validation,
                'berkas' => $this->berkas->find($id_berkas),
                
            ]);
        }
    }
    
    public function hapus($id_berkas)
    {
        $file = $this->berkas->find($id_berkas);
        $dokumen = $file->file_berkas;

        if (file_exists('simta_assets/berkas/' . $dokumen)) {
            unlink('simta_assets/berkas/' . $dokumen);
        }

        $this->berkas->delete($id_berkas);
        session()->setFlashdata('success', 'Data Berkas Tugas Akhir Berhasil Dihapus');
        return redirect()->to('simta/berkas');
    }
    public function download_berkas($id_berkas)
    {
        $berkas = $this->berkas->find($id_berkas);       
        return $this->response->download('simta_assets/berkas/' . $berkas->file_berkas, null);
    }
}