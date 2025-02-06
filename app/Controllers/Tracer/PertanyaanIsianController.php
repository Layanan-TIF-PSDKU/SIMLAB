<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\PertanyaanIsianModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PertanyaanIsianController extends BaseController
{   
    public function __construct()
    {
        $this->pertanyaan_isian = new PertanyaanIsianModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Jenis Kuesioner',
            'pertanyaan_isian' => $this->pertanyaan_isian->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'pertanyaan_isian'
        ];
        return view('tracer/pertanyaan_isian/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Pertanyaan Kuesioner',
            'activePage' => 'pertanyaan_isian',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/pertanyaan_isian/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_pertanyaan = $uuid->toString();
        $pertanyaan = $this->request->getVar('pertanyaan');
        
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_pertanyaan' => $uuid,
                'pertanyaan' => $pertanyaan,
            ];
            $this->pertanyaan_isian->insert($data);
            session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil ditambahkan');
            return redirect()->to(base_url('tracer/pertanyaan_isian'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/pertanyaan_isian/tambah', [
                'title' => 'Tambah Data Pertanyaan Kuesioner',
                'cms' => $this->cms->getWarna(),
                'activePage' => 'pertanyaan_isian',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pertanyaan Kuesioner',
            'pertanyaan_isian' => $this->pertanyaan_isian->find($id),
            'validation' => $this->validation,
            'cms' => $this->cms->getWarna(),
            'activePage' => 'pertanyaan_isian'
        ];
        return view('tracer/pertanyaan_isian/edit', $data);
    }

    public function update($id = null)
    {
        $pertanyaan = $this->request->getVar('pertanyaan');
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'pertanyaan' => $pertanyaan,
            ];
            $this->pertanyaan_isian->update($id, $data);
            session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil diupdate');
            return redirect()->to('tracer/pertanyaan_isian')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/pertanyaan_isian/edit', [
                'title' => 'Edit Pertanyaan Kuesioner',
                'pertanyaan_isian' => $this->pertanyaan_isian->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'pertanyaan_isian',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->pertanyaan_isian->find($id);
        $this->pertanyaan_isian->delete($id);
        session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil dihapus');
        return redirect()->to(base_url('tracer/pertanyaan_isian'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}