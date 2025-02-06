<?php

namespace App\Controllers\Simlab;

use App\Models\Simlab\KategoriModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class KategoriController extends BaseController
{
    public function __construct()
    {
        $this->kategori = new KategoriModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
            'kategori' => $this->kategori->findAll(),
            'activePage' => 'kategori'
        ];

        return view('simlab/kategori/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Kategori',
            'validation' => $this->validation,
            'activePage' => 'kategori'
        ];
        return view('simlab/kategori/tambah', $data);
    }

    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_kategori = $uuid->toString();
        $nama_kategori = $this->request->getVar('nama_kategori');
        
        $rules = [
            'nama_kategori' => [
                'label' => "Nama kategori",
                'rules' => "required|is_unique[simlab_kategori.nama_kategori]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_kategori' => $uuid,
                'nama_kategori' => $nama_kategori,
            ];
            $this->kategori->insert($data);
            session()->setFlashdata('success', 'Data Kategori Berhasil Ditambahkan');
            return redirect()->to('simlab/kategori')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simlab/kategori/tambah', [
                'title' => 'Tambah Data Kategori',
                'activePage' => 'kategori',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Kategori',
            'kategori' => $this->kategori->find($id),
            'validation' => $this->validation,
            'activePage' => 'kategori',
        ];
        return view('simlab/kategori/edit', $data);
    }

    public function update($id = null)
    {

        $nama_kategori = $this->request->getVar('nama_kategori');
            $rules = [
                'nama_kategori' => [
                    'label' => "Nama kategori",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
            ];

            if($this->validate($rules)) {
                $data = [
                    'nama_kategori' => $nama_kategori,
                ];
                $this->kategori->update($id, $data);
                session()->setFlashdata('success', 'Data Kategori Berhasil Diupdate');
                return redirect()->to('simlab/kategori')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
            } else {
                return view('simlab/kategori/edit', [
                    'title' => 'Edit Data Kategori',
                    'kategori' => $this->kategori->find($id),
                    'activePage' => 'kategori',
                    'validation' => $this->validation,
                ]);
            }
    }

    public function hapus($id)
    {
        $data = $this->kategori->find($id);
        $this->kategori->delete($id);
        session()->setFlashdata('success', 'Data Kategori Berhasil Dihapus');
        return redirect()->to('simlab/kategori')->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

}


?>