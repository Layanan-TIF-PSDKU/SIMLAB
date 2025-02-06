<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\PertanyaanModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PertanyaanKuesionerController extends BaseController
{   
    public function __construct()
    {
        $this->pertanyaan_kuesioner = new PertanyaanModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Jenis Kuesioner',
            'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'pertanyaan_kuesioner'
        ];
        return view('tracer/pertanyaan_kuesioner/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Pertanyaan Kuesioner',
            'activePage' => 'pertanyaan_kuesioner',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/pertanyaan_kuesioner/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_pertanyaan = $uuid->toString();
        $pertanyaan = $this->request->getVar('pertanyaan');
        $pilihan1 = $this->request->getVar('pilihan1');
        $pilihan2 = $this->request->getVar('pilihan2');
        
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'pilihan1' => [
                'label' => "Pilihan 1",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'pilihan2' => [
                'label' => "Pilihan 2",
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
                'pilihan1' => $pilihan1,
                'pilihan2' => $pilihan2,
            ];
            $this->pertanyaan_kuesioner->insert($data);
            session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil ditambahkan');
            return redirect()->to(base_url('tracer/pertanyaan_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/pertanyaan_kuesioner/tambah', [
                'title' => 'Tambah Data Pertanyaan Kuesioner',
                'cms' => $this->cms->getWarna(),
                'activePage' => 'pertanyaan_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pertanyaan Kuesioner',
            'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->find($id),
            'validation' => $this->validation,
            'cms' => $this->cms->getWarna(),
            'activePage' => 'pertanyaan_kuesioner'
        ];
        return view('tracer/pertanyaan_kuesioner/edit', $data);
    }

    public function update($id = null)
    {
        $pertanyaan = $this->request->getVar('pertanyaan');
        $pilihan1 = $this->request->getVar('pilihan1');
        $pilihan2 = $this->request->getVar('pilihan2');
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'pilihan1' => [
                'label' => "Pilihan 1",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'pilihan2' => [
                'label' => "Pilihan 2",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'pertanyaan' => $pertanyaan,
                'pilihan1' => $pilihan1,
                'pilihan2' => $pilihan2,
            ];
            $this->pertanyaan_kuesioner->update($id, $data);
            session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil diupdate');
            return redirect()->to('tracer/pertanyaan_kuesioner')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/pertanyaan_kuesioner/edit', [
                'title' => 'Edit Pertanyaan Kuesioner',
                'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'pertanyaan_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->pertanyaan_kuesioner->find($id);
        $this->pertanyaan_kuesioner->delete($id);
        session()->setFlashdata('success', 'Data Pertanyaan Kuesioner berhasil dihapus');
        return redirect()->to(base_url('tracer/pertanyaan_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}