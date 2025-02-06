<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\LowonganKerjaModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class LowonganKerjaController extends BaseController
{   
    public function __construct()
    {
        $this->lowongan_kerja = new LowonganKerjaModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Lowongan Kerja',
            'lowongan_kerja' => $this->lowongan_kerja->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'lowongan_kerja'
        ];
        return view('tracer/lowongan_kerja/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Lowongan Kerja',
            'activePage' => 'lowongan_kerja',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/lowongan_kerja/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_lowongan_kerja = $uuid->toString();
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $link_pt = $this->request->getVar('link_pt');
        $posisi_lowongan = $this->request->getVar('posisi_lowongan');
        $persyaratan = $this->request->getVar('persyaratan');
        $batas_akhir = $this->request->getVar('batas_akhir');
        // $poster = $this->request->getFile('poster');
        // $poster_upload = $poster->getRandomName();
        
        $rules = [
            'nama_perusahaan' => [
                'label' => "Nama Perusahaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'link_pt' => [
                'label' => "Link Perusahaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'posisi_lowongan' => [
                'label' => "Posisi Lowongan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'persyaratan' => [
                'label' => "Persyaratan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'batas_akhir' => [
                'label' => "Batas waktu Lowongan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            // 'poster' => [
            //     'label' => "Poster",
            //     'rules' => 'uploaded[poster]|max_size[poster,2048]|mime_in[poster,image/jpg,image/jpeg,image/png]',
            //     'errors' => [
            //         'uploaded' => 'File harus diupload',
            //         'ext_in' => 'File berupa png,jpg,jpeg',
            //         'max_size' => 'Size maks 5 MB',
            //     ],
            // ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_lowongan_kerja' => $uuid,
                'nama_perusahaan' => $nama_perusahaan,
                'link_pt' => $link_pt,
                'posisi_lowongan' => $posisi_lowongan,
                'persyaratan' => $persyaratan,
                'batas_akhir' => $batas_akhir,
                // 'poster' => $poster_upload,
            ];
            $this->lowongan_kerja->insert($data);
            // $poster->move('tracer_assets/kerja/', $poster_upload);
            session()->setFlashdata('success', 'Data Lowongan Kerja berhasil ditambahkan');
            return redirect()->to(base_url('tracer/lowongan_kerja'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/lowongan_kerja/tambah', [
                'title' => 'Tambah Data Lowongan Kerja',
                'activePage' => 'lowongan_kerja',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Lowongan Kerja',
            'lowongan_kerja' => $this->lowongan_kerja->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'lowongan_kerja'
        ];
        return view('tracer/lowongan_kerja/edit', $data);
    }

    public function update($id = null)
    {
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $link_pt = $this->request->getVar('link_pt');
        $posisi_lowongan = $this->request->getVar('posisi_lowongan');
        $persyaratan = $this->request->getVar('persyaratan');
        $batas_akhir = $this->request->getVar('batas_akhir');

        // $poster = $this->request->getFile('poster');
        // $poster_upload = $poster->getRandomName();

        $rules = [
            'nama_perusahaan' => [
                'label' => "Nama Perusahaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'link_pt' => [
                'label' => "Link Perusahaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'posisi_lowongan' => [
                'label' => "Posisi Lowongan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'batas_akhir' => [
                'label' => "Batas Waktu Lowongan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            // 'poster' => [
            //     'label' => "Poster",
            //     'rules' => 'uploaded[poster]|max_size[poster,2048]|ext_in[poster,jpg,jpeg,png]',
            //     'errors' => [
            //         'uploaded' => 'File harus diupload',
            //         'ext_in' => 'File berupa png,jpg,jpeg',
            //         'max_size' => 'Size maks 5 MB',
            //     ],
            // ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'nama_perusahaan' => $nama_perusahaan,
                'link_pt' => $link_pt,
                'posisi_lowongan' => $posisi_lowongan,
                'persyaratan' => $persyaratan,
                'batas_akhir' => $batas_akhir,
                // 'poster' => $poster_upload,
            ];
            $this->lowongan_kerja->update($id, $data);
            // $poster->move('tracer_assets/kerja/', $poster_upload);
            session()->setFlashdata('success', 'Data Lowongan Kerja berhasil diupdate');
            return redirect()->to('tracer/lowongan_kerja')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/lowongan_kerja/edit', [
                'title' => 'Edit Lowongan Kerja',
                'lowongan_kerja' => $this->lowongan_kerja->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'lowongan_kerja',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->lowongan_kerja->find($id);
        $this->lowongan_kerja->delete($id);
        session()->setFlashdata('success', 'Data Lowongan Kerja berhasil dihapus');
        return redirect()->to(base_url('tracer/lowongan_kerja'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}