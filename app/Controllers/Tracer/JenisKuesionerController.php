<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\JenisKuesionerModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class JenisKuesionerController extends BaseController
{   
    public function __construct()
    {
        $this->jenis_kuesioner = new JenisKuesionerModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Jenis Kuesioner',
            'jenis_kuesioner' => $this->jenis_kuesioner->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'jenis_kuesioner'
        ];
        return view('tracer/jenis_kuesioner/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Jenis Kuesioner',
            'activePage' => 'jenis_kuesioner',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/jenis_kuesioner/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_jenis_kuesioner = $uuid->toString();
        $nama = $this->request->getVar('nama');
        
        $rules = [
            'nama' => [
                'label' => "Nama",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_jenis_kuesioner' => $uuid,
                'nama' => $nama,
            ];
            $this->jenis_kuesioner->insert($data);
            session()->setFlashdata('success', 'Data Jenis Kuesioner berhasil ditambahkan');
            return redirect()->to(base_url('tracer/jenis_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/jenis_kuesioner/tambah', [
                'title' => 'Tambah Data Jenis Kuesioner',
                'activePage' => 'jenis_kuesioner',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Jenis Kuesioner',
            'jenis_kuesioner' => $this->jenis_kuesioner->find($id),
            'validation' => $this->validation,
            'cms' => $this->cms->getWarna(),
            'activePage' => 'jenis_kuesioner'
        ];
        return view('tracer/jenis_kuesioner/edit', $data);
    }

    public function update($id = null)
    {
        $nama = $this->request->getVar('nama');
        $rules = [
            'nama' => [
                'label' => "Nama",
                'rules' => "is_unique[tracer_jenis_kuesioner.nama, id_jenis_kuesioner, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'nama' => $nama,
            ];
            $this->jenis_kuesioner->update($id, $data);
            session()->setFlashdata('success', 'Data Jenis Kuesioner berhasil diupdate');
            return redirect()->to('tracer/jenis_kuesioner')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/jenis_kuesioner/edit', [
                'title' => 'Edit Jenis Kuesioner',
                'jenis_kuesioner' => $this->jenis_kuesioner->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'jenis_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->jenis_kuesioner->find($id);
        $this->jenis_kuesioner->delete($id);
        session()->setFlashdata('success', 'Data Jenis Kuesioner berhasil dihapus');
        return redirect()->to(base_url('tracer/jenis_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}