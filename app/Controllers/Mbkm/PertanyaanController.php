<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MataKuliahModel;
use App\Models\Mbkm\PertanyaanUtsModel;
use App\Models\Mbkm\PertanyaanUasModel;
use Ramsey\Uuid\Uuid;

class PertanyaanController extends BaseController
{
    public function __construct()
    {
        $this->matkul = new MataKuliahModel();
        $this->pertanyaanUts = new PertanyaanUtsModel();
        $this->pertanyaanUas = new PertanyaanUasModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index()
    {
        $data = [
            'activePage' => 'pertanyaan',
            'title' => 'Indikator Penilaian',
        ];

        return view('mbkm/pertanyaan/index', $data);
    }
    public function index_uts()
    {
        $data = [
            'title' => 'Data Pertanyaan UTS',
            'pertanyaanUts' => $this->pertanyaanUts->getPertanyaanUts(),
            'pertanyaanUas' => $this->pertanyaanUas->getPertanyaanUas(),
            // 'total_pertanyaan_dosen_uts' => $this->pertanyaanUts->getTotalPertanyaanDosenUts(),
            'activePage' => 'pertanyaan',
        ];

        return view('mbkm/pertanyaan/index_uts', $data);
    }
    public function index_uas()
    {
        $data = [
            'title' => 'Data Pertanyaan UAS',
            'pertanyaanUts' => $this->pertanyaanUts->getPertanyaanUts(),
            'pertanyaanUas' => $this->pertanyaanUas->getPertanyaanUas(),
            // 'total_pertanyaan_dosen_uts' => $this->pertanyaanUts->getTotalPertanyaanDosenUts(),
            'activePage' => 'pertanyaan',
        ];

        return view('mbkm/pertanyaan/index_uas', $data);
    }

    // FUNGSI CRUD UTS
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Pertanyaan',
            'validation' => $this->validation,
            'matkul' => $this->matkul->findAll(),
            'validation' => $this->validation,
        ];

        return view('mbkm/pertanyaan/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_pertanyaan_uts = $uuid->toString();
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $jenis_penilai = $this->request->getVar('jenis_penilai');
        $pertanyaan = $this->request->getVar('pertanyaan');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            
            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
            'jenis_penilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_pertanyaan_uts' => $uuid,
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'pertanyaan' => $pertanyaan,
                'jenis_penilai' => $jenis_penilai,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->pertanyaanUts->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('mbkm/pertanyaan/uts');
        } else {
            return view('mbkm/pertanyaan/tambah', [
                'title' => 'Pertanyaan Penilaian KMM',
                'matkul' => $this->matkul->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_pertanyaan_uts)
    {
        $data = [
            'title' => 'Edit Pertanyaan UTS',
            'validation' => $this->validation,
            'pertanyaanUts' => $this->pertanyaanUts->find($id_pertanyaan_uts),
            'matkul' => $this->matkul->findAll(),
        ];

        return view('mbkm/pertanyaan/edit', $data);
    }

    public function update($id_pertanyaan_uts)
    {
       
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $jenis_penilai = $this->request->getVar('jenis_penilai');
        $pertanyaan = $this->request->getVar('pertanyaan');
        $rules = [
            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
            'jenis_penilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'pertanyaan' => $pertanyaan,
                'jenis_penilai' => $jenis_penilai,
            ];

            $this->pertanyaanUts->update($id_pertanyaan_uts, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('mbkm/pertanyaan/uts');
        } else {
            return view('mbkm/pertanyaan/edit', [
                'title' => 'Edit Pertanyaan MBKM',
                'validation' => $this->validation,
                'pertanyaanUts' => $this->pertanyaanUts->find($id_pertanyaan_uts),
                'matkul' => $this->matkul->findAll(),
            ]);
        }
    }

    public function hapus($id_pertanyaan_uts)
    {
        $this->pertanyaanUts->delete($id_pertanyaan_uts);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('mbkm/pertanyaan/uts');
    }

     // FUNGSI CRUD UAS
    public function tambah_uas()
    {
        $data = [
            'title' => 'Tambah Data Pertanyaan UAS',
            'validation' => $this->validation,
            'matkul' => $this->matkul->findAll(),
            'validation' => $this->validation,
        ];

        return view('mbkm/pertanyaan/tambah_uas', $data);
    }

    public function simpan_uas()
    {
        $uuid = Uuid::uuid4();
        $id_pertanyaan_uas = $uuid->toString();
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $jenis_penilai = $this->request->getVar('jenis_penilai');
        $pertanyaan = $this->request->getVar('pertanyaan');

        $rules = [
            
            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
            'jenis_penilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_pertanyaan_uas' => $uuid,
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'pertanyaan' => $pertanyaan,
                'jenis_penilai' => $jenis_penilai,
                
            ];
            $this->pertanyaanUas->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('mbkm/pertanyaan/uas');
        } else {
            return view('mbkm/pertanyaan/tambah_uas', [
                'title' => 'Data Pertanyaan UAS',
                'matkul' => $this->matkul->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit_uas($id_pertanyaan_uas)
    {
        $data = [
            'title' => 'Edit Pertanyaan UAS',
            'validation' => $this->validation,
            'pertanyaanUas' => $this->pertanyaanUas->find($id_pertanyaan_uas),
            'matkul' => $this->matkul->findAll(),
        ];

        return view('mbkm/pertanyaan/edit_uas', $data);
    }

    public function update_uas($id_pertanyaan_uas)
    {
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $jenis_penilai = $this->request->getVar('jenis_penilai');
        $pertanyaan = $this->request->getVar('pertanyaan');
        $rules = [

            'pertanyaan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
            
            'jenis_penilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'pertanyaan' => $pertanyaan,
                'jenis_penilai' => $jenis_penilai,
            ];
            $this->pertanyaanUas->update($id_pertanyaan_uas, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('mbkm/pertanyaan/uas');
        } else {
            return view('mbkm/pertanyaan/edit', [
                'title' => 'Edit Pertanyaan MBKM',
                'validation' => $this->validation,
                'pertanyaanUas' => $this->pertanyaanUas->find($id_pertanyaan_uas),
                'matkul' => $this->matkul->findAll(),
            ]);
        }
    }

    public function hapus_uas($id_pertanyaan_uas)
    {
        $this->pertanyaanUas->delete($id_pertanyaan_uas);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('mbkm/pertanyaan/uas');
    }
}