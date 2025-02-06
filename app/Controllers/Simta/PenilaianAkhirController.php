<?php

namespace App\Controllers\Simta;

use App\Models\Simta\PenilaianAkhirModel;
use App\Models\Simta\UjianProposalModel;
use App\Models\Simta\SeminarHasilModel;
use App\Models\Simta\UjianTAModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use App\Models\Simta\BobotPenilaianModel;
use App\Models\Simta\TotalNilaiModel;
use Ramsey\Uuid\Uuid;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenilaianAkhirController extends BaseController
{   
    public function __construct()
    {
        $this->penilaianakhir = new PenilaianAkhirModel();
        $this->ujianproposal = new UjianProposalModel();
        $this->seminarhasil = new SeminarHasilModel();
        $this->ujianta = new UjianTAModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->totalnilai = new TotalNilaiModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->validation = \Config\Services::validation();
        
        helper('form');
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'ujianproposal' => $this->ujianproposal->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir'
        ];
        // dd($data);

        return view('simta/penilaianakhir/index', $data);
    }

    public function tambah($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->findAll(),
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
        ];

        return view('simta/penilaianakhir/tambah', $data);
    }

    public function store($id_ujianproposal)
    {
        $validation = \Config\Services::validation();
        $uuid = Uuid::uuid4();
        $id_hasilakhir = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $id_ujianproposal = $this->request->getVar('id_ujianproposal');
        $nilai_ujianproposal = floatval($this->request->getVar('nilai_ujianproposal'));
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'nilai_ujianproposal' => [
                'label' => "Nilai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];
        // Menghitung Nilai Akhir Penilaian
       
        if ($this->validate($rules)) {
            $data = [
                'id_hasilakhir' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'id_ujianproposal' => $id_ujianproposal,
                'nilai_ujianproposal' => $nilai_ujianproposal,
                'created_at' => $created_at,
            ];
            // dd($data);
            $this->penilaianakhir->insert($data);
            //dd($data);
            session()->setFlashdata('success', 'Data Penilaian Akhir Berhasil Ditambah');
            return redirect()->to('simta/penilaianakhir');

        } else {
            return view('simta/penilaianakhir/tambah', [
                'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
                'penilaianakhir' => $this->penilaianakhir->findAll(),
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
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

    public function editsemhas($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->find($id_ujianproposal),
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'seminarhasil' => $this->seminarhasil->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation, 
        ];

        return view('simta/penilaianakhir/editsemhas', $data);
    }
    public function updatesemhas($id_ujianproposal)
    {
        $nilai_seminarhasil = floatval($this->request->getVar('nilai_seminarhasil'));
    
        $rules = [
            'nilai_seminarhasil' => [
                'label' => "Nilai",
                'rules' => "required|numeric",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'numeric' => "{field} harus berupa angka",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            // Mendapatkan Data Total Penilaian dari database
            $penilaianakhir = $this->penilaianakhir->getTotalNilai($id_ujianproposal);
            $id_hasilakhir = $penilaianakhir->id_hasilakhir;
            // $nilai_seminarhasil = $this->seminarhasil->find($id_ujianproposal);
            $data = [
                'id_hasilakhir' => $id_hasilakhir,
                'nilai_seminarhasil' => $nilai_seminarhasil,
            ];

            //  dd($data);
            $this->penilaianakhir->save($data);

            session()->setFlashdata('success', 'Data Penilaian Akhir Berhasil Diperbarui');
            return redirect()->to('simta/penilaianakhir');
        } else {
            return view('simta/penilaianakhir/editsemhas', [
                'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
                'penilaianakhir' => $this->penilaianakhir->find($id_ujianproposal),
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'seminarhasil' => $seminarhasil,
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

    public function editsidang($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->find($id_ujianproposal),
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'seminarhasil' => $this->seminarhasil->find($id_ujianproposal),
            'ujianta' => $this->ujianta->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
        ];
        return view('simta/penilaianakhir/editsidang', $data);
    }

    public function updatesidang($id_ujianproposal)
    {
        $nilai_ujianta = floatval($this->request->getVar('nilai_ujianta'));
        $rules = [
            'nilai_ujianta' => [
                'label' => "Nilai",
                'rules' => "required|decimal",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];
        // Menghitung Nilai Akhir Penilaian
        if ($this->validate($rules)) {
            var_dump($rules);
            var_dump($nilai_ujianta);
            // Mendapatkan Data Total Penilaian dari database
            $penilaianakhir = $this->penilaianakhir->getTotalNilai($id_ujianproposal);
            $id_hasilakhir = $penilaianakhir->id_hasilakhir;
            
            // Mengambil nilai-nilai dengan tipe data yang sesuai
            $nilai_ujianproposal = floatval($this->penilaianakhir->getTotalNilai($id_ujianproposal)->nilai_ujianproposal);
            $nilai_seminarhasil = floatval($this->penilaianakhir->getTotalNilai($id_ujianproposal)->nilai_seminarhasil);
            
            // Menghitung hasil akhir dengan menambahkan nilai-nilai yang sudah diambil
            $hasilakhir = $nilai_ujianproposal + $nilai_seminarhasil + $nilai_ujianta;
            
            $data = [
                'id_hasilakhir' => $id_hasilakhir,
                'nilai_ujianta' => $nilai_ujianta,
                'hasilakhir' => $hasilakhir,    
            ];
            $this->penilaianakhir->save($data);
            session()->setFlashdata('success', 'Data Penilaian Akhir Berhasil Ditambah');
            return redirect()->to('simta/penilaianakhir');
        } else {
            return view('simta/penilaianakhir/editsidang', [
                'title' => 'Tambah Data Penilaian Akhir Tugas Akhir',
                'penilaianakhir' => $this->penilaianakhir->find($id_ujianproposal),
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'seminarhasil' => $this->seminarhasil->find($id_ujianproposal),
                'ujianta' => $this->ujianta->find($id_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'penilaianakhir',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hasilakhir($id_hasilakhir)
    {
        $data = [
            'title' => 'Tambah Data Hasil Akhir Tugas Akhir',
            'penilaianakhir' => $this->penilaianakhir->find($id_hasilakhir),
            'ujianproposal' => $this->ujianproposal->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
        ];

        return view('simta/penilaianakhir/hasilakhir', $data);
    }

    public function total($id_hasilakhir)
    {
        $data = [
            $nilai_ujianproposal = $this->request->getVar('nilai_ujianproposal'),
            $nilai_seminarhasil = $this->request->getVar('nilai_seminarhasil'),
            $nilai_ujianta = $this->request->getVar('nilai_ujianta'),

        ];
        //dd($data);
        $rules = [
            'nilai_ujianproposal' => [
                'label' => "nilai_ujianproposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'nilai_seminarhasil' => [
                'label' => "nilai_seminarhasil",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'nilai_ujianta' => [
                'label' => "nilai_ujianta",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];
        // dd($rules);
        if ($this->validate($rules)) {
            $data = [
                'nilai_ujianproposal' => $nilai_ujianproposal,
                'nilai_seminarhasil' => $nilai_seminarhasil,
                'nilai_ujianta' => $nilai_ujianta,
            ];
            // return dd($data);
            $this->penilaianakhir->update($id_hasilakhir, $data);
            session()->setFlashdata('success', 'Data Hasil Akhir Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/penilaianakhir');
        } else {
            return view('simta/penilaianakhir/hasilakhir', [
                'title' => 'Tambah Data Hasil Akhir Tugas Akhir',
                'penilaianakhir' => $this->penilaianakhir->find($id_hasilakhir),
                'ujianproposal' => $this->ujianproposal->findAll(),
                'activePage' => 'penilaianakhir',
                'validation' => $this->validation,
            ]);
        }
    }

    public function cetak_penilaian($id_hasilakhir)
    {
        $data = [
            'penilaianakhir' => $this->penilaianakhir->find($id_hasilakhir),
            'ujianproposal' => $this->ujianproposal->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'penilaianakhir',
            'validation' => $this->validation,
        ];
        //dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simta/penilaianakhir/penilaian_akhir', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian_Akhir_'.$data['penilaianakhir']->id_mhs.'.pdf');

    }
}