<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\AlumniBerprestasiModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class AlumniBerprestasiController extends BaseController
{   
    public function __construct()
    {
        $this->alumni_berprestasi = new AlumniBerprestasiModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Alumni Berprestasi',
            'alumni_berprestasi' => $this->alumni_berprestasi->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'alumni_berprestasi'
        ];
        return view('tracer/alumni_berprestasi/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Alumni Berprestasi',
            'activePage' => 'alumni_berprestasi',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/alumni_berprestasi/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_alumni_berprestasi = $uuid->toString();
        $nama_mahasiswa = $this->request->getVar('nama_mahasiswa');
        $program_study = $this->request->getVar('program_study');
        $prestasi = $this->request->getVar('prestasi');
        $foto = $this->request->getFile('foto');
        $foto_upload = $foto->getRandomName();
        
        $rules = [
            'nama_mahasiswa' => [
                'label' => "Nama Mahasiswa",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'program_study' => [
                'label' => "Program Study",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'prestasi' => [
                'label' => "Prestasi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'foto' => [
                'label' => "Gambar alat laboratorium",
                'rules' => 'uploaded[foto]|max_size[foto,2048]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa png,jpg,jpeg',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_alumni_berprestasi' => $uuid,
                'nama_mahasiswa' => $nama_mahasiswa,
                'program_study' => $program_study,
                'prestasi' => $prestasi,
                'foto' => $foto_upload,
            ];
            $this->alumni_berprestasi->insert($data);
            $foto->move('tracer_assets/prestasi/', $foto_upload);
            session()->setFlashdata('success', 'Data Alumni Berprestasi berhasil ditambahkan');
            return redirect()->to(base_url('tracer/alumni_berprestasi'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/alumni_berprestasi/tambah', [
                'title' => 'Tambah Data Alumni Berprestasi',
                'cms' => $this->cms->getWarna(),
                'activePage' => 'alumni_berprestasi',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Alumni Berprestasi',
            'alumni_berprestasi' => $this->alumni_berprestasi->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'alumni_berprestasi'
        ];
        return view('tracer/alumni_berprestasi/edit', $data);
    }

    public function update($id = null)
    {
        $nama_mahasiswa = $this->request->getVar('nama_mahasiswa');
        $program_study = $this->request->getVar('program_study');
        $prestasi = $this->request->getVar('prestasi');

        $foto = $this->request->getFile('foto');
        $foto_upload = $foto->getRandomName();

        $rules = [
            'nama_mahasiswa' => [
                'label' => "Nama Mahasiswa",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'program_study' => [
                'label' => "Program Study",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'prestasi' => [
                'label' => "Prestasi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'foto' => [
                'label' => "Foto",
                'rules' => 'uploaded[foto]|max_size[foto,2048]|ext_in[foto,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa png,jpg,jpeg',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'nama_mahasiswa' => $nama_mahasiswa,
                'program_study' => $program_study,
                'prestasi' => $prestasi,
                'foto' => $foto_upload,
            ];
            $this->alumni_berprestasi->update($id, $data);
            $foto->move('tracer_assets/prestasi/', $foto_upload);
            session()->setFlashdata('success', 'Data Alumni Berprestasi berhasil diupdate');
            return redirect()->to('tracer/alumni_berprestasi')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/alumni_berprestasi/edit', [
                'title' => 'Edit Alumni Berprestasi',
                'alumni_berprestasi' => $this->alumni_berprestasi->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'alumni_berprestasi',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->alumni_berprestasi->find($id);
        $this->alumni_berprestasi->delete($id);
        session()->setFlashdata('success', 'Data Alumni Berprestasi berhasil dihapus');
        return redirect()->to(base_url('tracer/alumni_berprestasi'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}