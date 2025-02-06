<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\PertanyaanPenilaianModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PertanyaanController extends BaseController
{
    public function __construct()
    {
        $this->pertanyaan = new PertanyaanPenilaianModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Indikator Penilaian KMM',
            'pertanyaan' => $this->pertanyaan->findAll(),
        ];
        
        return view('kmm/pertanyaan/index', $data);
    }
    
    public function create(){
        $data = [
            'title' => 'Indikator Penilaian KMM',
            'pertanyaan' => $this->pertanyaan->findAll(),
            'validation' => $this->validation,
        ];

        return view('kmm/pertanyaan/tambah', $data);
    }

    public function store()
    {
        $uuid =  Uuid::uuid4();
        $id_pertanyaan = $uuid->toString();
        $pertanyaan = $this->request->getVar('pertanyaan');
        $jenis_pertanyaan = $this->request->getVar('jenis_pertanyaan');
        $nilai_maks = $this->request->getVar('nilai_maks');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pertanyaan harus diisi",
                ]
            ],
            'jenis_pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis pertanyaan harus diisi",
                ]
            ],
        ];

        
        if($this->validate($rules)) {
            $data = [
                'id_pertanyaan' => $uuid,
                'pertanyaan' => $pertanyaan,
                'jenis_pertanyaan' => $jenis_pertanyaan,
                'nilai_maks' => $nilai_maks,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->pertanyaan->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('kmm/pertanyaan-penilaian');
        } else {
            return view('kmm/pertanyaan/tambah', [
                'title' => 'Indikator Penilaian KMM',
                'pertanyaan' => $this->pertanyaan->findAll(),
                'validation' => $this->validation
            ]);
        }
    }
    
    public function edit($id_pertanyaan)
    {
        $data = [
            'title' => 'Indikator Penilaian KMM',
            'validation' => $this->validation,
            'pertanyaan' => $this->pertanyaan->find($id_pertanyaan),
        ];

        return view('kmm/pertanyaan/edit', $data);
    }

    public function update($id_pertanyaan)
    {
        $pertanyaan = $this->request->getVar('pertanyaan');
        $jenis_pertanyaan = $this->request->getVar('jenis_pertanyaan');
        $nilai_maks = $this->request->getVar('nilai_maks');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pertanyaan harus diisi",
                    ]
                ],
                'jenis_pertanyaan' => [
                    'rules' => "required",
                    'errors' => [
                        'required' => "Jenis Pertanyaan harus diisi",
                        ]
                ],
            ];
            
        if($this->validate($rules)) {
            $data = [
                'pertanyaan' => $pertanyaan,
                'jenis_pertanyaan' => $jenis_pertanyaan,
                'nilai_maks' => $nilai_maks,
                'updated_at' => $updated_at,
            ];
            
            $this->pertanyaan->update($id_pertanyaan, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('kmm/pertanyaan-penilaian');
        } else {
            return view('kmm/pertanyaan/edit', [
                'title' => 'Indikator Penilaian KMM',
                'validation' => $this->validation,
                'pertanyaan' => $this->pertanyaan->find($id_pertanyaan),
            ]);
        }
    }

    public function delete($id_pertanyaan)
    {        
        $this->pertanyaan->delete($id_pertanyaan);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('kmm/pertanyaan-penilaian');
    }
}
?>