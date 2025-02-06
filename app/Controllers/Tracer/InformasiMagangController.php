<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\InformasiMagangModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class InformasiMagangController extends BaseController
{   
    public function __construct()
    {
        $this->informasi_magang = new InformasiMagangModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Informasi Magang',
            'informasi_magang' => $this->informasi_magang->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'informasi_magang'
        ];
        return view('tracer/informasi_magang/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Informasi Magang',
            'activePage' => 'informasi_magang',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/informasi_magang/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_informasi_magang = $uuid->toString();
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $link_pt = $this->request->getVar('link_pt');
        $posisi_magang = $this->request->getVar('posisi_magang');
        $persyaratan_magang = $this->request->getVar('persyaratan_magang');
        $batas_akhir = $this->request->getVar('batas_akhir');
        // $poster_magang = $this->request->getFile('poster_magang');
        // $poster_upload = $poster_magang->getRandomName();
        
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
            'posisi_magang' => [
                'label' => "Posisi Magang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'persyaratan_magang' => [
                'label' => "Persyaratan Magang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'batas_akhir' => [
                'label' => "Batas Informasi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            // 'poster_magang' => [
            //     'label' => "Poster Magang",
            //     'rules' => 'uploaded[poster_magang]|max_size[poster_magang,2048]|mime_in[poster_magang,image/jpg,image/jpeg,image/png]',
            //     'errors' => [
            //         'uploaded' => 'File harus diupload',
            //         'ext_in' => 'File berupa png,jpg,jpeg',
            //         'max_size' => 'Size maks 5 MB',
            //     ],
            // ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_informasi_magang' => $uuid,
                'nama_perusahaan' => $nama_perusahaan,
                'link_pt' => $link_pt,
                'posisi_magang' => $posisi_magang,
                'persyaratan_magang' => $persyaratan_magang,
                'batas_akhir' => $batas_akhir,
                // 'poster_magang' => $poster_upload,
            ];
            $this->informasi_magang->insert($data);
            // $poster_magang->move('tracer_assets/magang/', $poster_upload);
            session()->setFlashdata('success', 'Data Informasi Magang berhasil ditambahkan');
            return redirect()->to(base_url('tracer/informasi_magang'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/informasi_magang/tambah', [
                'title' => 'Tambah Data Informasi Magang',
                'cms' => $this->cms->getWarna(),
                'activePage' => 'informasi_magang',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Informasi Magang',
            'informasi_magang' => $this->informasi_magang->find($id),
            'validation' => $this->validation,
            'cms' => $this->cms->getWarna(),
            'activePage' => 'informasi_magang'
        ];
        return view('tracer/informasi_magang/edit', $data);
    }

    public function update($id = null)
    {
        $nama_perusahaan = $this->request->getVar('nama_perusahaan');
        $link_pt = $this->request->getVar('link_pt');
        $posisi_magang = $this->request->getVar('posisi_magang');
        $persyaratan_magang = $this->request->getVar('persyaratan_magang');
        $batas_akhir = $this->request->getVar('batas_akhir');
        // $poster_magang = $this->request->getFile('poster_magang');
        // $poster_upload = $poster_magang->getRandomName();

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
            'posisi_magang' => [
                'label' => "Posisi Magang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'persyaratan_magang' => [
                'label' => "Persyaratan Magang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'batas_akhir' => [
                'label' => "Batas Akhir",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            // 'poster_magang' => [
            //     'label' => "Poster",
            //     'rules' => 'uploaded[poster_magang]|max_size[poster_magang,2048]|ext_in[poster_magang,jpg,jpeg,png]',
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
                'posisi_magang' => $posisi_magang,
                'persyaratan_magang' => $persyaratan_magang,
                'batas_akhir' => $batas_akhir,
                // 'poster_magang' => $poster_upload,
            ];
            $this->informasi_magang->update($id, $data);
            // $poster_magang->move('tracer_assets/magang/', $poster_upload);
            session()->setFlashdata('success', 'Data Informasi Magang berhasil diupdate');
            return redirect()->to('tracer/informasi_magang')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/informasi_magang/edit', [
                'title' => 'Edit Informasi Magang',
                'informasi_magang' => $this->informasi_magang->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'informasi_magang',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->informasi_magang->find($id);
        $this->informasi_magang->delete($id);
        session()->setFlashdata('success', 'Data Informasi Magang berhasil dihapus');
        return redirect()->to(base_url('tracer/informasi_magang'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}