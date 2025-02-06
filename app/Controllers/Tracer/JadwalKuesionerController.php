<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\TahunModel;
use App\Models\Tracer\JenisKuesionerModel;
use App\Models\Tracer\JadwalKuesionerModel;
use App\Models\Tracer\JawabanKuesionerModel;
use App\Models\Tracer\JawabanIsianModel;
use App\Models\Tracer\PertanyaanModel;
use App\Models\Tracer\Total1Model;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class JadwalKuesionerController extends BaseController
{   
    public function __construct()
    {
        $this->tahun = new TahunModel();
        $this->jenis_kuesioner = new JenisKuesionerModel();
        $this->jadwal_kuesioner = new JadwalKuesionerModel();
        $this->jawaban_kuesioner = new JawabanKuesionerModel();
        $this->jawaban_isian = new JawabanIsianModel();
        $this->pertanyaan_kuesioner = new PertanyaanModel();
        $this->total_1 = new Total1Model();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Jadwal Kuesioner',
            'jadwal_kuesioner' => $this->jadwal_kuesioner->getJenisKuesioner(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'jadwal_kuesioner'
        ];
        return view('tracer/jadwal_kuesioner/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Jenis Kuesioner',
            'jenis_kuesioner' => $this->jenis_kuesioner->findAll(),
            'tahun' => $this->tahun->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'jenis_kuesioner',
            'validation' => $this->validation,
        ];
        
        return view('tracer/jadwal_kuesioner/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_jadwal_kuesioner = $uuid->toString();
        $jenis_survey = $this->request->getVar('jenis_survey');
        $tahun_lulus = $this->request->getVar('tahun_lulus');
        $batas_pengisian = $this->request->getVar('batas_pengisian');
        
        $rules = [
            'jenis_survey' => [
                'label' => "Jenis Kuesioner",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'tahun_lulus' => [
                'label' => "Tahun",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'batas_pengisian' => [
                'label' => "Batas Waktu Pengisian",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_jadwal_kuesioner' => $uuid,
                'jenis_survey' => $jenis_survey,
                'tahun_lulus' => $tahun_lulus,
                'batas_pengisian' => $batas_pengisian,
            ];
            $this->jadwal_kuesioner->insert($data);
            session()->setFlashdata('success', 'Data Jadwal Kuesioner berhasil ditambahkan');
            return redirect()->to(base_url('tracer/jadwal_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/jadwal_kuesioner/tambah', [
                'title' => 'Tambah Data Jadwal Kuesioner',
                'jenis_kuesioner' => $this->jenis_kuesioner->findAll(),
                'tahun' => $this->tahun->findAll(),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'jadwal_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Jenis Kuesioner',
            'jadwal_kuesioner' => $this->jadwal_kuesioner->find($id),
            'jenis_kuesioner' => $this->jenis_kuesioner->findAll(),
            'tahun' => $this->tahun->findAll(),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'jadwal_kuesioner'
        ];
        return view('tracer/jadwal_kuesioner/edit', $data);
    }

    public function update($id = null)
    {
        $jenis_survey = $this->request->getVar('jenis_survey');
        $tahun_lulus = $this->request->getVar('tahun_lulus');
        $batas_pengisian = $this->request->getVar('batas_pengisian');
        $rules = [
            'jenis_survey' => [
                'label' => "Nama",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi"
                ]
            ],
            'tahun_lulus' => [
                'label' => "Tahun",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi"
                ]
            ],
            'batas_pengisian' => [
                'label' => "Batas Waktu Pengisian",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'jenis_survey' => $jenis_survey,
                'tahun_lulus' => $tahun_lulus,
                'batas_pengisian' => $batas_pengisian,
            ];
            $this->jadwal_kuesioner->update($id, $data);
            session()->setFlashdata('success', 'Data Jadwal Kuesioner berhasil diupdate');
            return redirect()->to('tracer/jadwal_kuesioner')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/jadwal_kuesioner/edit', [
                'title' => 'Edit Jadwal Kuesioner',
                'jadwal_kuesioner' => $this->jadwal_kuesioner->find($id),
                'jenis_kuesioner' => $this->jenis_kuesioner->findAll(),
                'tahun' => $this->tahun->findAll(),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'jadwal_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }

    public function getTotalById($id)
    {
        return $this->where('total', $id)->countAllResults();
    }

    public function hasil($id)
    {
        $total_1 = new Total1Model();
        $jawaban_isian = new JawabanIsianModel();

        $jawabanData = []; // Array untuk menyimpan data hasil penghitungan
        $jawabanDataIsian = []; // Array untuk menyimpan data hasil penghitungan

        // Ambil semua pertanyaan unik dari kolom pertanyaan
        $pertanyaanOptions = $total_1->distinct()->findColumn('pertanyaan');
        $pertanyaanIsian = $jawaban_isian->distinct()->findColumn('pertanyaan_isian');

        // Lakukan penghitungan dan simpan hasil untuk setiap pertanyaan
        foreach ($pertanyaanOptions as $pertanyaan) {
            $jawabanOptions = $total_1->distinct()->where('pertanyaan', $pertanyaan)->findColumn('pilihan');

            // Lakukan penghitungan untuk setiap nilai jawaban
            foreach ($jawabanOptions as $pilihan) {
                $count = $total_1->where('pertanyaan', $pertanyaan)
                                ->where('pilihan', $pilihan)
                                ->countAllResults();

                $jawabanData[$pertanyaan][$pilihan] = $count;
            }
        }
        foreach ($pertanyaanIsian as $pertanyaan_isian) {
            $jawabanIsian = $jawaban_isian->distinct()->where('pertanyaan_isian', $pertanyaan_isian)->findColumn('isian');

            // Lakukan penghitungan untuk setiap nilai jawaban
            foreach ($jawabanIsian as $isian) {
                $count = $jawaban_isian->where('pertanyaan_isian', $pertanyaan_isian)
                                ->where('isian', $isian)
                                ->findAll();

                $jawabanDataIsian[$pertanyaan_isian][$isian] = $count;
            }
        }
        $data = [
            'title' => 'Hasil Jadwal Kuesioner',
            'cms' => $this->cms->getWarna(),
            'jawabanData' => $jawabanData,
            'jawabanDataIsian' => $jawabanDataIsian,
    
            'validation' => $this->validation,
            'activePage' => 'jadwal_kuesioner'
        ];
        return view('tracer/jadwal_kuesioner/hasil', $data, );
    }

    public function hapus($id)
    {
        $data = $this->jadwal_kuesioner->find($id);
        $this->jadwal_kuesioner->delete($id);
        session()->setFlashdata('success', 'Data Jadwal Kuesioner berhasil dihapus');
        return redirect()->to(base_url('tracer/jadwal_kuesioner'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}