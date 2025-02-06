<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\TipsKarirModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class TipsKarirController extends BaseController
{   
    public function __construct()
    {
        $this->tips_karir = new TipsKarirModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Tips Karir',
            'tips_karir' => $this->tips_karir->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'tips_karir'
        ];
        return view('tracer/tips_karir/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Tips Karir',
            'activePage' => 'tips_karir',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/tips_karir/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_tips_karir = $uuid->toString();
        $judul = $this->request->getVar('judul');
        $deskripsi = $this->request->getVar('deskripsi');
        
        $rules = [
            'judul' => [
                'label' => "Judul",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'deskripsi' => [
                'label' => "Deskripsi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_tips_karir' => $uuid,
                'judul' => $judul,
                'deskripsi' => $deskripsi,
            ];
            $this->tips_karir->insert($data);
            session()->setFlashdata('success', 'Data Tips Karir berhasil ditambahkan');
            return redirect()->to(base_url('tracer/tips_karir'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/tips_karir/tambah', [
                'title' => 'Tambah Data Tips Karir',
                'activePage' => 'tips_karir',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Tips Karir',
            'tips_karir' => $this->tips_karir->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'tips_karir'
        ];
        return view('tracer/tips_karir/edit', $data);
    }

    public function update($id = null)
    {
        $judul = $this->request->getVar('judul');
        $deskripsi = $this->request->getVar('deskripsi');
        $rules = [
            'judul' => [
                'label' => "Judul",
                'rules' => "is_unique[tracer_tips_karir.judul, id_tips_karir, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nama' => [
                'label' => "Deskripsi",
                'rules' => "is_unique[tracer_tips_karir.deskripsi, id_tips_karir, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
            ];
            $this->tips_karir->update($id, $data);
            session()->setFlashdata('success', 'Data Tips Karir berhasil diupdate');
            return redirect()->to('tracer/tips_karir')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/tips_karir/edit', [
                'title' => 'Edit Tips Karir',
                'tips_karir' => $this->tips_karir->find($id),
                'activePage' => 'tips_karir',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->tips_karir->find($id);
        $this->tips_karir->delete($id);
        session()->setFlashdata('success', 'Data Tips Karir berhasil dihapus');
        return redirect()->to(base_url('tracer/tips_karir'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}