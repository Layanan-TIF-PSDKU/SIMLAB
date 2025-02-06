<?php

namespace App\Controllers\Simta;

use App\Models\Simta\PenilaianAkhirModel;
use App\Models\Simta\PengujiUjianProposalModel;
use App\Models\Simta\SeminarHasilModel;
use App\Models\Simta\PengujiUjianTAModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use App\Models\Simta\BobotPenilaianModel;
use App\Models\Simta\TotalNilaiModel;
use Ramsey\Uuid\Uuid;

class PenilaianAkhirController extends BaseController
{   
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->penilaianakhir = new PenilaianAkhirModel();
        $this->pengujiujianproposal = new PengujiUjianProposalModel();
        $this->seminarhasil = new SeminarHasilModel();
        $this->pengujiujianta = new PengujiUjianTAModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->totalnilai = new TotalNilaiModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        
        helper('form');
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'pengujiujianproposal' => $this->pengujiujianproposal->findAll(),
            'pengujiujianta' => $this->pengujiujianta->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir'
        ];

        return view('simta/penilaianakhir/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'pengujiujianproposal' => $this->pengujiujianproposal->findAll(),
            'seminarhasil' => $this->seminarhasil->findAll(),
            'pengujiujianta' => $this->pengujiujianta->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,

            
        ];

        return view('simta/penilaianakhir/tambah', $data);
    }

    public function store()
    {
        $uuid = Uuid::uuid4();
        $id_hasilakhir = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nilai_ujianproposal1 = intval($this->request->getVar('nilai1_ujianproposal'));
        $nilai_ujianproposal2 = intval($this->request->getVar('nilai2_ujianproposal'));
        $nilai_seminarhasil = intval($this->request->getVar('nilai_seminarhasil'));
        $nilai_ujianta1 = intval($this->request->getVar('nilai_ujianta1'));
        $nilai_ujianta2 = intval($this->request->getVar('nilai_ujianta2'));
        $nilai_ujianta3 = intval($this->request->getVar('nilai_ujianta3'));


        $rules = [
            'id_mhs' => [
                'label' => "Nama Mahasiswa",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'id_staf' => [
                'label' => "Nama Staf",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];
//dd($rules);
//Mencari Rata-Rata 
$nilai_ujianproposal = ($nilai_ujianproposal1 +$nilai_ujianproposal2) / 2;
$nilai_ujianta = ($nilai_ujianta1 +$nilai_ujianta2 +$nilai_ujianta3) / 3;
      // Mendapatkan Bobot Penilaian
$bobotpenilaian = $this->bobotpenilaian->getBobot();
$bobot_ujianproposal = ($bobotpenilaian->bobot_ujianproposal) / 100;
$bobot_seminarhasil = ($bobotpenilaian->bobot_seminarhasil) / 100;
$bobot_ujianta = ($bobotpenilaian->bobot_ujianta) / 100;

// Menghitung Total Penilaian 
$nilai_ujianproposal = $nilai_ujianproposal * ($bobot_ujianproposal);
$nilai_seminarhasil = $nilai_seminarhasil * ($bobot_seminarhasil);
$nilai_ujianta = $nilai_ujianta * ($bobot_ujianta);
//dd($nilai_ujianproposal);

// Menghitung Nilai Akhir Penilaian
$hasilakhir = $nilai_ujianproposal + $nilai_seminarhasil + $nilai_ujianta;
       
        if ($this->validate($rules)) {
        $data = [
            'id_hasilakhir' => $uuid,
            'id_mhs' => $id_mhs,
            'id_staf' => $id_staf,
            'nilai_ujianproposal' => $nilai_ujianproposal,
            'nilai_seminarhasil' => $nilai_seminarhasil,
            'nilai_ujianta' => $nilai_ujianta,
            'hasilakhir' => $hasilakhir
        ];
        //dd($data);
        $this->penilaianakhir->insert($data);
        //dd($data);
        session()->setFlashdata('success', 'Data Penilaian Akhir berhasil diupdate');
        return redirect()->to('simta/penilaianakhir')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');

        } else {
            return view('simta/penilaianakhir/tambah', [
                'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'pengujiujianproposal' => $this->pengujiujianproposal->findAll(),
            'seminarhasil' => $this->seminarhasil->findAll(),
            'pengujiujianta' => $this->pengujiujianta->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
            ]);
        }
    // }
    //     // Bobot penilaian
    //     $bobotUjianProposal = 0.1;
    //     $bobotSeminarHasil = 0.3;
    //     $bobotUjianTugasAkhir = 0.6;

    //     // Hitung bobot masing-masing penilaian
    //     $nilaiUjianProposal = $nilai_ujianproposal * $bobotUjianProposal;
    //     $nilaiSeminarHasil = $nilai_seminarhasil * $bobotSeminarHasil;
    //     $nilaiUjianTugasAkhir = $nilai_ujianta * $bobotUjianTugasAkhir;

    //     // Total bobot penilaian
    //     $hasilakhir = $nilaiUjianProposal + $nilaiSeminarHasil + $nilaiUjianTugasAkhir;


    //     // Simpan data ke dalam database
    //     $penilaianakhirModel = new \App\Models\Simta\PenilaianAkhirModel();
    //     $penilaianakhirModel->save([
    //     'id_mhs' => $id_mhs,
    //     'id_staf' => $id_staf,
    //     'nilai_ujianproposal' => $nilai_ujianproposal,
    //     'nilai_seminarhasil' => $nilai_seminarhasil,
    //     'nilai_ujianta' => $nilai_ujianta,
    //     'hasilakhir' => $hasilakhir
    // ]);

    }

    public function edit($id_staf)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'pengujiujianproposal' => $this->pengujiujianproposal->selectSum1($id_staf),
            'pengujiujianproposal' => $this->pengujiujianproposal->selectSum2($id_staf),
            'seminarhasil' => $this->seminarhasil->getTotalNilaiSeminarHasil($id_staf),
            'pengujiujianta' => $this->pengujiujianta->selectSum3(),
            'pengujiujianta' => $this->pengujiujianta->selectSum4(),
            'pengujiujianta' => $this->pengujiujianta->selectSum5(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->getAll($id_staf),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
        ];

        return view('simta/penilaianakhir/tambah', $data);
    }

    public function update($id_staf)
    {
        $uuid = Uuid::uuid4();
        $id_hasilakhir = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $nilai_ujianproposal = intval($this->request->getVar('nilai_ujianproposal'));
        $nilai_seminarhasil = intval($this->request->getVar('nilai_seminarhasil'));
        $nilai_ujianta = intval($this->request->getVar('nilai_ujianta'));


        $rules = [
            'id_mhs' => [
                'label' => "Nama Mahasiswa",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];
//dd($rules);
//Mencari Rata-Rata 
$nilai_ujianproposal = (selectSum1 + selectSum2) / 2;
$nilai_ujianta = (selectSum3 + selectSum4 + selectSum5) / 3;
      // Mendapatkan Bobot Penilaian
$bobotpenilaian = $this->bobotpenilaian->getBobot();
$bobot_ujianproposal = ($bobotpenilaian->bobot_ujianproposal) / 100;
$bobot_seminarhasil = ($bobotpenilaian->bobot_seminarhasil) / 100;
$bobot_ujianta = ($bobotpenilaian->bobot_ujianta) / 100;

// Menghitung Total Penilaian 
$nilai_ujianproposal = $nilai_ujianproposal * ($bobot_ujianproposal);
$nilai_seminarhasil = $nilai_seminarhasil * ($bobot_seminarhasil);
$nilai_ujianta = $nilai_ujianta * ($bobot_ujianta);
//dd($nilai_ujianproposal);

// Menghitung Nilai Akhir Penilaian
$hasilakhir = $nilai_ujianproposal + $nilai_seminarhasil + $nilai_ujianta;
       
        if ($this->validate($rules)) {
        $data = [
            'id_hasilakhir' => $uuid,
            'id_mhs' => $id_mhs,
            'id_staf' => $id_staf,
            'nilai_ujianproposal' => $nilai_ujianproposal,
            'nilai_seminarhasil' => $nilai_seminarhasil,
            'nilai_ujianta' => $nilai_ujianta,
            'hasilakhir' => $hasilakhir
        ];
        //dd($data);
        $this->penilaianakhir->insert($data);
        //dd($data);
        session()->setFlashdata('success', 'Data Penilaian Akhir berhasil diupdate');
        return redirect()->to('simta/penilaianakhir')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');

        } else {
            return view('simta/penilaianakhir/tambah', [
                'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
            ]);
        }
    }
}