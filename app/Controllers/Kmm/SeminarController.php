<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\KmmModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Master\MitraModel;
use App\Models\Kmm\TotalNilaiModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class SeminarController extends BaseController
{
    public function __construct()
    {
        $this->kmm = new KmmModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->nilai = new TotalNilaiModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Seminar KMM',
            'seminar' => $this->kmm->getAllKMM(),
            'seminar2' => $this->kmm->getLastKMM(),
            'seminar3' => $this->kmm->getKMMbyIdDosen(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'mitra' => $this->mitra->findAll(),
        ];
        // dd($data['angkatan']);
        return view('kmm/seminar/index', $data);
    }
    
    public function edit($id_kmm){
        $data = [
            'title' => 'Pendaftaran Seminar KMM',
            'seminar' => $this->kmm->find($id_kmm),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'staf' => $this->staf->findAll(),
            'mitra' => $this->mitra->findAll(),
            'validation' => $this->validation,
        ];

        return view('kmm/seminar/tambah', $data);
    }

    public function update($id_kmm)
    {
        $judul_kmm = $this->request->getVar('judul_kmm');
        $logbook = $this->request->getFile('logbook');
        $logbookName = $logbook->getRandomName();
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'judul_kmm' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Judul KMM harus diisi",
                ]
            ],
            'logbook' => [
                'rules' => "ext_in[logbook,pdf]|max_size[logbook,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                    ]
            ],
        ];

        if($this->validate($rules)) {
            $data = [
                'judul_kmm' => $judul_kmm,
                'logbook' => $logbookName,
                'updated_at' => $updated_at,
            ];

            $this->kmm->update($id_kmm, $data);
            $logbook->move('kmm_assets/logbook/', $logbookName);
            session()->setFlashdata('success', 'Pendaftaran Seminar Berhasil');
            return redirect()->to('kmm/seminar');
        } else {
            return view('kmm/seminar/tambah', [
                'title' => 'Pendaftaran Seminar KMM',
                'seminar' => $this->kmm->getKMMbyIdMhs(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'staf' => $this->staf->findAll(),
                'mitra' => $this->mitra->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function update_jadwal_seminar($id_kmm)
    {
        $tgl = $this->request->getVar('tgl_seminar');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'tgl_seminar' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Tanggal Seminar KMM harus diisi",
                ]
            ],
        ];

        if($this->validate($rules)) {
            $data = [
                'tgl_seminar' => $tgl,
                'updated_at' => $updated_at,
            ];

            $this->kmm->update($id_kmm, $data);

            $data2 = [
                'id_total_nilai' => Uuid::uuid4()->toString(),
                'id_kmm' => $id_kmm,
            ];

            $this->nilai->insert($data2);
            
            session()->setFlashdata('success', 'Jadwal Seminar Berhasil Ditetapkan');
            return redirect()->to('kmm/seminar');
        } else {
            session()->setFlashdata('error', 'Jadwal Seminar Gagal Ditetapkan');
            return redirect()->to('kmm/seminar');
        }
    }

    public function getFilterDataSeminar($th_masuk)
    {
        $filterMahasiswa = $this->kmm->getFilterDataSeminar($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function getFilterDataSeminarByIdDosen($th_masuk)
    {
        $filterDosen = $this->kmm->getFilterDataSeminarByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }

}