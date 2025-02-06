<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MitraModel;
use App\Models\Master\StafModel;
use App\Models\Mbkm\BobotModel;
use App\Models\Mbkm\MbkmFixModel;
use App\Models\Mbkm\NilaiKonversiModel;
use App\Models\Mbkm\PenilaianUasModel;
use App\Models\Mbkm\PenilaianUtsModel;
use App\Models\Mbkm\PertanyaanUasModel;
use App\Models\Mbkm\PertanyaanUtsModel;
use App\Models\Mbkm\TotalNilaiUasModel;
use App\Models\Mbkm\TotalNilaiUtsModel;
use Ramsey\Uuid\Uuid;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PenilaianController extends BaseController
{
    public function __construct()
    {
        $this->mbkmFix = new MbkmFixModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->bobot = new BobotModel();
        $this->pertanyaanUts = new PertanyaanUtsModel();
        $this->penilaianUts = new PenilaianUtsModel();
        $this->pertanyaanUas = new PertanyaanUasModel();
        $this->penilaianUas = new PenilaianUasModel();
        $this->totalUts = new TotalNilaiUtsModel();
        $this->totalUas = new TotalNilaiUasModel();
        $this->konv = new NilaiKonversiModel();
        $this->validation = \Config\Services::validation();
        $this->spreadsheet = new Spreadsheet();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Penilaian MBKM',

        ];

        return view('mbkm/penilaian/index', $data);
    }
    public function index_uts()
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->getMbkmFixByDosenPenilaianUts(),
            // 'mbkm' => $this->mbkmFix->getMbkmFixByAdmin(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'mbkm2' => $this->mbkmFix->getMbkmFixByMitra(),
            'mbkm3' => $this->mbkmFix->getMbkmFixByDosenPenilaian(),
            'penilaianUts' => $this->penilaianUts->findAll(),
            'penilaianUas' => $this->penilaianUas->findAll(),
            'totalUts' => $this->totalUts->getTotPenilaianbyMbkm(),
            'totalUas' => $this->totalUas->getTotPenilaianbyMbkm(),
        ];

        
        function randomColor() {
            $letters = '0123456789ABCDEF';
            $color = '#';
            for ($i = 0; $i < 6; $i++) {
                $color .= $letters[rand(0, 15)];
            }
            return $color;
        }
        
        $results = $this->totalUts->getKalkulasiNilaiUTS();
        $data2 = [
            'labels' => ["60-69", "70-79", "80-89", "90-100"],
            'datasets' => [
                [
                   'label' => 'Nilai Mahasiswa',
                    'data' => [0, 0, 0, 0],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1
                ]
            ]
        ];
        
        foreach ($results as $result) {
            if($result->nilai_final_uts >= 60 && $result->nilai_final_uts <= 69){
                $data2['datasets'][0]['data'][0]++;
            }else if($result->nilai_final_uts >= 70 && $result->nilai_final_uts <= 79){
                $data2['datasets'][0]['data'][1]++;
            }else if($result->nilai_final_uts >= 80 && $result->nilai_final_uts <= 89){
                $data2['datasets'][0]['data'][2]++;
            }else if($result->nilai_final_uts >= 90 && $result->nilai_final_uts <= 100){
                $data2['datasets'][0]['data'][3]++;
            }
            array_push($data2['datasets'][0]['backgroundColor'], randomColor());
            array_push($data2['datasets'][0]['borderColor'], randomColor());
        }

        return view('mbkm/penilaian/index_uts', ['data2' => $data2] + $data);
    }

    /* PENILAIAN UTS MITRA*/

    /* Form penilaian UTS mitra*/
    public function penilaian_uts_mtr($id_mbkm_fix)
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
            'penilaianUts' => $this->penilaianUts->findAll(),
            'pertanyaan_dsn_uts' => $this->pertanyaanUts->getPertanyaanDosenUts(),
            'pertanyaan_mtr_uts' => $this->pertanyaanUts->getPertanyaanMitraUts(),
            // 'total_nilai_mitra_uts' => $this->penilaianUts->getTotalNilaiMitraUts(),
            'validation' => $this->validation,
        ];
        return view('mbkm/penilaian/tambah', $data);
    }

    /* Form proses perhitungan penilaian UTS Mitra*/
    public function simpan_penilaian_uts_mtr($id_mbkm_fix)
    {
        // menampung inputan nilai dan atribut lain
        $uuid = Uuid::uuid4();
        $id_penilaian_uts = $uuid->toString();
        $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $id_pertanyaan_uts = $this->request->getVar('id_pertanyaan_uts');
        $nilai = $this->request->getVar('nilai');

        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",

                ],
            ],
        ];
        // jika lolos validasi menampung nilai dari form nilai
        if ($this->validate($rules)) {
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan_uts); $i++) {
                $data = array(
                    'id_penilaian_uts' => $id_penilaian_uts++,
                    'id_mbkm_fix' => $id_mbkm_fix,
                    'id_pertanyaan_uts' => $id_pertanyaan_uts[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;
            }
            // melakukan insert nilai setiap soal ke tb penilaian uts
            $this->penilaianUts->insertBatch($data_arr);
            // mengambil data total nilai UTS Mitra dari database
            $totalUts = $this->totalUts->getTotalNilaiUts($id_mbkm_fix);
            $id_total = $totalUts->id_total_uts;
            $total_mitra = $totalUts->nilai_mitra_uts;
            // mendapatkan nilai bobot yang disimpan pada tb bobot
            $bobot = $this->bobot->getBobot();
            $bobot_dosen = ($bobot->bobot_dosen) / 100;
            $bobot_mitra = ($bobot->bobot_mitra) / 100;

            $total_nilai_dosen_uts = $this->penilaianUts->getTotalNilaiDosenUts($id_mbkm_fix);
            $nilai_dosen_uts = ($total_nilai_dosen_uts * $bobot_dosen);
            // menghitung penilaian mitra
            $total_nilai_mitra_uts = $this->penilaianUts->getTotalNilaiMitraUts($id_mbkm_fix);
            $nilai_mitra_uts = ($total_nilai_mitra_uts * $bobot_mitra);

            $nilai_final_uts = $nilai_dosen_uts + $nilai_mitra_uts;

            $data1 = array(
                'id_total_uts' => $id_total,
                // 'id_mbkm_fix' => $id_mbkm_fix,
                // 'nilai_dosen_uts' => $nilai_dosen_uts,
                'nilai_mitra_uts' => $nilai_mitra_uts,
                'nilai_final_uts' => $nilai_final_uts,
            );
            // simpan data
            $this->totalUts->save($data1);
            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('mbkm/penilaian/uts');
        } else {
            return view('mbkm/penilaian/tambah', [
                'title' => 'Penilaian MBKM UTS',
                'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'pertanyaan_dsn_uts' => $this->pertanyaanUts->getPertanyaanDosenUts(),
                'pertanyaan_mtr_uts' => $this->pertanyaanUts->getPertanyaanMitraUts(),
                'validation' => $this->validation,
            ]);
        }
    }

    // DOSEN UTS
    public function penilaian_uts_dsn($id_mbkm_fix)
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
            'pertanyaan_dsn_uts' => $this->pertanyaanUts->getPertanyaanDosenUts(),
            'pertanyaan_mtr_uts' => $this->pertanyaanUts->getPertanyaanMitraUts(),
            'validation' => $this->validation,
        ];

        return view('mbkm/penilaian/tambah2', $data);
    }

    /* Form proses perhitungan penilaian UTS Dosen*/
    public function simpan_penilaian_uts_dsn($id_mbkm_fix)
    {
        // menampung inputan form nilai uts dosen
        $uuid = Uuid::uuid4();
        $id_penilaian_uts = $uuid->toString();
        $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $id_pertanyaan_uts = $this->request->getVar('id_pertanyaan_uts');
        $nilai = $this->request->getVar('nilai');
        // cek validasi
        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",

                ],
            ],
        ];
        // jika lolos validasi menampung data nilai
        if ($this->validate($rules)) {
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan_uts); $i++) {
                $data = array(
                    'id_penilaian_uts' => $id_penilaian_uts++,
                    'id_mbkm_fix' => $id_mbkm_fix,
                    'id_pertanyaan_uts' => $id_pertanyaan_uts[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;
            }
            // insert data pada tb penilaian uts
            $this->penilaianUts->insertBatch($data_arr);
            // mendapatkan total nilai uts
            $totalUts = $this->totalUts->getTotalNilaiUts($id_mbkm_fix);
            $id_total = $totalUts->id_total_uts;
            $total_mitra = $totalUts->nilai_mitra_uts;
            // mendapatkan bobot nilai
            $bobot = $this->bobot->getBobot();
            $bobot_dosen = ($bobot->bobot_dosen) / 100;
            $bobot_mitra = ($bobot->bobot_mitra) / 100;
            // perhitungan nilai uts (dosen)
            $total_nilai_dosen_uts = $this->penilaianUts->getTotalNilaiDosenUts($id_mbkm_fix);
            $nilai_dosen_uts = ($total_nilai_dosen_uts * $bobot_dosen);
            // perhitungan nilai UTS keseluruhan dari dosen dan mitra
            $nilai_final_uts = $nilai_dosen_uts + $total_mitra;

            // menampung data
            $data1 = array(
                'id_total_uts' => $id_total,
                'nilai_dosen_uts' => $nilai_dosen_uts,
                'nilai_final_uts' => $nilai_final_uts,
            );
            // menyimpan data pada tb total nilai uts
            $this->totalUts->save($data1);
            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('mbkm/penilaian/uts');
        } else {
            // jika inputan tidak sesuai validasi akan kembali pada halaman form nilai
            return view('mbkm/penilaian/tambah2', [
                'title' => 'Penilaian MBKM UTS',
                'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'pertanyaan_dsn_uts' => $this->pertanyaanUts->getPertanyaanDosenUts(),
                'pertanyaan_mtr_uts' => $this->pertanyaanUts->getPertanyaanMitraUts(),
                'validation' => $this->validation,
            ]);
        }
    }

    /**
     * PENILAIAN MITRA UAS
     */
    public function index_uas()
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->getAllPenilaian(),
            'mbkm3' => $this->mbkmFix->getMbkmFixByDosenPenilaian(),
            'mbkm2' => $this->mbkmFix->getMbkmFixByMitra(),
            'dosen' => $this->mbkmFix->getMbkmFixByDosenPenilaianUas(),
            'penilaianUts' => $this->penilaianUts->findAll(),
            'penilaianUas' => $this->penilaianUas->findAll(),
            'totalUts' => $this->totalUts->getTotPenilaianbyMbkm(),
            'totalUas' => $this->totalUas->getTotPenilaianbyMbkm(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'konv' => $this->konv->getKonvPenilaianbyMbkm(),

        ];

        function randomColor() {
            $letters = '0123456789ABCDEF';
            $color = '#';
            for ($i = 0; $i < 6; $i++) {
                $color .= $letters[rand(0, 15)];
            }
            return $color;
        }
        
        $results = $this->totalUas->getKalkulasiNilaiUAS();
        $data2 = [
            'labels' => ["60-69", "70-79", "80-89", "90-100"],
            'datasets' => [
                [
                   'label' => 'Nilai Mahasiswa',
                    'data' => [0, 0, 0, 0],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1
                ]
            ]
        ];
        
        foreach ($results as $result) {
            if($result->nilai_final_uas >= 60 && $result->nilai_final_uas <= 69){
                $data2['datasets'][0]['data'][0]++;
            }else if($result->nilai_final_uas >= 70 && $result->nilai_final_uas <= 79){
                $data2['datasets'][0]['data'][1]++;
            }else if($result->nilai_final_uas >= 80 && $result->nilai_final_uas <= 89){
                $data2['datasets'][0]['data'][2]++;
            }else if($result->nilai_final_uas >= 90 && $result->nilai_final_uas <= 100){
                $data2['datasets'][0]['data'][3]++;
            }
            array_push($data2['datasets'][0]['backgroundColor'], randomColor());
            array_push($data2['datasets'][0]['borderColor'], randomColor());
        }
        return view('mbkm/penilaian_uas/index', ['data2' => $data2] + $data);
        // return view('mbkm/penilaian_uas/index', $data);
    }

    public function penilaian_uas_mtr($id_mbkm_fix)
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
            // 'penilaianUas' => $this->penilaianUas->findAll(),
            'pertanyaan_dsn_uas' => $this->pertanyaanUas->getPertanyaanDosenUas(),
            'pertanyaan_mtr_uas' => $this->pertanyaanUas->getPertanyaanMitraUas(),
            // 'total_nilai_mitra_Uas' => $this->penilaianUts->getTotalNilaiMitraUts(),
            'validation' => $this->validation,
        ];

        return view('mbkm/penilaian_uas/tambah_uas_mtr', $data);
    }
    /*
    Proses Penilaian UAS MITRA
     */
    public function simpan_penilaian_uas_mtr($id_mbkm_fix)
    {
        // menampung insert data dari form
        $uuid = Uuid::uuid4();
        $id_penilaian_uas = $uuid->toString();
        $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $id_pertanyaan_uas = $this->request->getVar('id_pertanyaan_uas');
        $nilai = $this->request->getVar('nilai');
        // cek validasi
        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",

                ],
            ],
        ];
        // jika lolos validasi akan ditampung pada data array
        if ($this->validate($rules)) {
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan_uas); $i++) {
                $data = array(
                    'id_penilaian_uas' => $id_penilaian_uas++,
                    'id_mbkm_fix' => $id_mbkm_fix,
                    'id_pertanyaan_uas' => $id_pertanyaan_uas[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;
            }
            // insert data pada database penilaian UAS
            $this->penilaianUas->insertBatch($data_arr);
            // mendapatkan total nilai pada database tb total nilai uas
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $id_total = $totalUas->id_total_uas;
            $total_mitra = $totalUas->nilai_mitra_uas;

            // mendapatkan nilai bobot
            $bobot = $this->bobot->getBobot();
            $bobot_dosen = ($bobot->bobot_dosen) / 100;
            $bobot_mitra = ($bobot->bobot_mitra) / 100;

            $total_nilai_dosen_uas = $this->penilaianUas->getTotalNilaiDosenUas($id_mbkm_fix);
            $nilai_dosen_uas = ($total_nilai_dosen_uas * $bobot_dosen);

            // perhitungan nilai UAS pada mitra
            $total_nilai_mitra_uas = $this->penilaianUas->getTotalNilaiMitraUas($id_mbkm_fix);
            $nilai_mitra_uas = ($total_nilai_mitra_uas * $bobot_mitra);

            $nilai_final_uas = $nilai_dosen_uas + $nilai_mitra_uas;
            // menampung data
            $data1 = array(
                'id_total_uas' => $id_total,
                // 'id_mbkm_fix' => $id_mbkm_fix,
                // 'nilai_dosen_uas' => $nilai_dosen_uas,
                'nilai_mitra_uas' => $nilai_mitra_uas,
                'nilai_final_uas' => $nilai_final_uas,
            );
            // menyimpan data pada database
            $this->totalUas->save($data1);

            // mendapatkan data nilai total UTS
            // $id_nilai_konversi = $uuid->toString();
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $id_total = $totalUas->id_total_uas;
            $nilai_mitra_uas = $totalUas->nilai_mitra_uas;

            $konv = $this->konv->getNilaiKonversi($id_mbkm_fix);
            $id_konv = $konv->id_nilai_konversi;

            $totalUts = $this->totalUts->getTotalNilaiUts($id_mbkm_fix);
            $final_uts = $totalUts->nilai_final_uts;

            // mendapatkan nilai total UAS
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $final_uas = $totalUas->nilai_final_uas;

            $nilai_konversi = ($final_uts + $final_uas) / 2;

            // if ($nilai_dosen_uas == 0) {
            //     $nilai_konversi = $final_uts;
            // } elseif ($nilai_mitra_uas == 0) {
            //     $nilai_konversi = $final_uts;
            // } elseif ($nilai_mitra_uas > 0 && $nilai_dosen_uas > 0) {
            //     $nilai_konversi = ($final_uts + $final_uas) / 2;
            // }
            // perhitungan nilai yang dikonversi (nilai akhir)

            // dd($nilai_konversi, $final_uts );
            $data2 = array(
                'id_nilai_konversi' => $id_konv,
                'id_mbkm_fix' => $id_mbkm_fix,
                'nilai_konversi' => $nilai_konversi,
            );
            // dd($nilai_dosen_uas,$nilai_mitra_uas,$final_uts,$final_uas, $nilai_konversi);
            // insert data ke dalam database
            $this->konv->save($data2);

            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('mbkm/penilaian/uas');
        } else {
            // validasi tidak sesuai return ke halaman form penilaian UAS
            return view('mbkm/penilaian_uas/tambah_uas_mtr', [
                'title' => 'Penilaian MBKM UAS',
                'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'pertanyaan_dsn_uas' => $this->pertanyaanUas->getPertanyaanDosenUas(),
                'pertanyaan_mtr_uas' => $this->pertanyaanUas->getPertanyaanMitraUas(),
                'validation' => $this->validation,
            ]);
        }
    }

    /**
     * PENILAIAN DOSEN UAS
     */
    public function penilaian_uas_dsn($id_mbkm_fix)
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
            'pertanyaan_dsn_uas' => $this->pertanyaanUas->getPertanyaanDosenUas(),
            'pertanyaan_mtr_uas' => $this->pertanyaanUas->getPertanyaanMitraUas(),
            'validation' => $this->validation,
        ];

        return view('mbkm/penilaian_uas/tambah_uas_dsn', $data);
    }
    /* Proses Penilaian UAS Dosen */
    public function simpan_penilaian_uas_dsn($id_mbkm_fix)
    {
        // menampung data dari insert form penilaian UAS
        $uuid = Uuid::uuid4();
        $id_penilaian_uas = $uuid->toString();
        $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $id_pertanyaan_uas = $this->request->getVar('id_pertanyaan_uas');
        $nilai = $this->request->getVar('nilai');
        // Validasi
        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",

                ],
            ],
        ];
        // jika lolos validasi data akan ditampung pada data array
        if ($this->validate($rules)) {
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan_uas); $i++) {
                $data = array(
                    'id_penilaian_uas' => $id_penilaian_uas++,
                    'id_mbkm_fix' => $id_mbkm_fix,
                    'id_pertanyaan_uas' => $id_pertanyaan_uas[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;
            }
            // insert data pada database tb penilaian UAS
            $this->penilaianUas->insertBatch($data_arr);

            // mendapatkan total nilai UAS dari database
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $id_total = $totalUas->id_total_uas;
            $total_mitra = $totalUas->nilai_mitra_uas;

            // mendapatkan nilai bobot dari database
            $bobot = $this->bobot->getBobot();
            $bobot_dosen = ($bobot->bobot_dosen) / 100;
            $bobot_mitra = ($bobot->bobot_mitra) / 100;

            // perhitungan nilai UAS pada dosen
            $total_nilai_dosen_uas = $this->penilaianUas->getTotalNilaiDosenUas($id_mbkm_fix);
            $nilai_dosen_uas = ($total_nilai_dosen_uas * $bobot_dosen);

            // perhitungan total nilai UAS dosen dan mitra
            $nilai_final_uas = $nilai_dosen_uas + $total_mitra;

            $data1 = array(
                'id_total_uas' => $id_total,
                'nilai_dosen_uas' => $nilai_dosen_uas,
                'nilai_final_uas' => $nilai_final_uas,
            );
            // insert data pada database tb total UAS
            $this->totalUas->save($data1);

            // mendapatkan data nilai total UTS
            // $id_nilai_konversi = $uuid->toString();
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $id_total = $totalUas->id_total_uas;
            $nilai_mitra_uas = $totalUas->nilai_mitra_uas;

            $konv = $this->konv->getNilaiKonversi($id_mbkm_fix);
            $id_konv = $konv->id_nilai_konversi;

            $totalUts = $this->totalUts->getTotalNilaiUts($id_mbkm_fix);
            $final_uts = $totalUts->nilai_final_uts;

            // mendapatkan nilai total UAS
            $totalUas = $this->totalUas->getTotalNilaiUas($id_mbkm_fix);
            $final_uas = $totalUas->nilai_final_uas;

            $nilai_konversi = ($final_uts + $final_uas) / 2;

            // if ($nilai_dosen_uas == 0) {
            //     $nilai_konversi = $final_uts;
            // } elseif ($nilai_mitra_uas == 0) {
            //     $nilai_konversi = $final_uts;
            // } elseif ($nilai_mitra_uas > 0 && $nilai_dosen_uas > 0) {
            //     $nilai_konversi = ($final_uts + $final_uas) / 2;
            // }
            // perhitungan nilai yang dikonversi (nilai akhir)

            // dd($nilai_konversi, $final_uts );
            $data2 = array(
                'id_nilai_konversi' => $id_konv,
                'id_mbkm_fix' => $id_mbkm_fix,
                'nilai_konversi' => $nilai_konversi,
            );
            // dd($data2);
            // insert data ke dalam database
            $this->konv->save($data2);

            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('mbkm/penilaian/uas');
        } else {
            // jika tidak lolos validasi return halaman form penilaian UAS
            return view('mbkm/penilaian_uas/tambah_uas_dsn', [
                'title' => 'Penilaian MBKM UAS',
                'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'pertanyaan_dsn_uas' => $this->pertanyaanUas->getPertanyaanDosenUas(),
                'pertanyaan_mtr_uas' => $this->pertanyaanUas->getPertanyaanMitraUas(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function getFilterDataNilaiByIdDosen($th_masuk)
    {
        $filterDosen = $this->totalUts->getFilterDataNilaiByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }

    public function getFilterDataNilai($th_masuk)
    {
        $filterAdmin = $this->totalUts->getFilterDataNilaiUtsByIdAdm($th_masuk);
        return json_encode($filterAdmin);
    }

    public function getFilterDataNilaiUasDsn($th_masuk)
    {
        $filterDosen = $this->totalUas->getFilterNilaiUasDsn($th_masuk);
        return json_encode($filterDosen);
    }

    public function getFilterDataNilaiUasAdm($th_masuk)
    {
        $filterAdmin = $this->totalUas->getFilterNilaiUasAdm($th_masuk);
        return json_encode($filterAdmin);
    }

    public function cetak_nilai_uts_dsn_pdf($id_mbkm_fix)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getMbkmById($id_mbkm_fix),
            'pertanyaanUts' => $this->pertanyaanUts->getPertanyaanDosenUts(),
            'penilaianUts' => $this->penilaianUts->getPenilaianDsn($id_mbkm_fix),
            'total' => $this->penilaianUts->getTotalNilaiDosenUts($id_mbkm_fix),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/penilaian/pdf_dsn', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-UTS-Dosen' . $data['mbkm']->nm_mhs . '.pdf');
    }
    public function cetak_nilai_uts_mtr_pdf($id_mbkm_fix)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getMbkmById($id_mbkm_fix),
            'pertanyaanUtsMtr' => $this->pertanyaanUts->getPertanyaanMitraUts(),
            'penilaianUtsMtr' => $this->penilaianUts->getPenilaianMtr($id_mbkm_fix),
            'totalMtr' => $this->penilaianUts->getTotalNilaiMitraUts($id_mbkm_fix),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/penilaian/pdf_mtr', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-UTS-Mitra' . $data['mbkm']->nm_mhs . '.pdf');
    }
    
    public function cetak_penilaian_excel_uts($th_masuk)
    {
        $mbkm = $this->totalUts->getFilterDataNilaiUtsByIdAdm($th_masuk);
        // $mbkm = $this->totalUts->getFilterDataNilai($th_masuk);
        $sheet = $this->spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Mahasiswa');
        $sheet->setCellValue('D1', 'Nama Dosen Pembimbing');
        $sheet->setCellValue('E1', 'Nama Mitra');
        $sheet->setCellValue('F1', 'Total Nilai Dosen');
        $sheet->setCellValue('G1', 'Total Nilai Mitra');
        $sheet->setCellValue('H1', 'Nilai UTS');
        
        $no = 1;
        $baris = 2;

        foreach ($mbkm as $k) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $k->nim);
            $sheet->setCellValue('C' . $baris, $k->nm_mhs);
            $sheet->setCellValue('D' . $baris, $k->nm_staf);
            $sheet->setCellValue('E' . $baris, $k->nm_mitra);
            if($k->nilai_dosen_uts == null){
                $sheet->setCellValue('F' . $baris, '0');
            } else {
                $sheet->setCellValue('F' . $baris, $k->nilai_dosen_uts);
            }
            if($k->nilai_mitra_uts == null){
                $sheet->setCellValue('G' . $baris, '0');
            } else {
                $sheet->setCellValue('G' . $baris, $k->nilai_mitra_uts);
            }
            if($k->nilai_final_uts == null){
                $sheet->setCellValue('H' . $baris, '0');
            } else {
                $sheet->setCellValue('H' . $baris, $k->nilai_final_uts);
            }
            $no++;
            $baris++;
        }

        $filename = 'penilaian-uts-mbkm-mahasiswa-'.$th_masuk;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $kriter = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $kriter->save('php://output');
        exit();
    }
    
    public function cetak_penilaian_excel_uas($th_masuk)
    {
        $mbkm = $this->totalUas->getFilterNilaiUasAdm($th_masuk);
        // $mbkm = $this->totalUts->getFilterDataNilai($th_masuk);
        $sheet = $this->spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Mahasiswa');
        $sheet->setCellValue('D1', 'Nama Dosen Pembimbing');
        $sheet->setCellValue('E1', 'Nama Mitra');
        $sheet->setCellValue('F1', 'Total Nilai Dosen');
        $sheet->setCellValue('G1', 'Total Nilai Mitra');
        $sheet->setCellValue('H1', 'Nilai UAS');
        $sheet->setCellValue('I1', 'Nilai Akhir');
        
        $no = 1;
        $baris = 2;

        foreach ($mbkm as $k) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $k->nim);
            $sheet->setCellValue('C' . $baris, $k->nm_mhs);
            $sheet->setCellValue('D' . $baris, $k->nm_staf);
            $sheet->setCellValue('E' . $baris, $k->nm_mitra);
            if($k->nilai_dosen_uas == null){
                $sheet->setCellValue('F' . $baris, '0');
            } else {
                $sheet->setCellValue('F' . $baris, $k->nilai_dosen_uas);
            }
            if($k->nilai_mitra_uas == null){
                $sheet->setCellValue('G' . $baris, '0');
            } else {
                $sheet->setCellValue('G' . $baris, $k->nilai_mitra_uas);
            }
            if($k->nilai_final_uas == null){
                $sheet->setCellValue('H' . $baris, '0');
            } else {
                $sheet->setCellValue('H' . $baris, $k->nilai_final_uas);
            }
            if($k->nilai_konversi == null){
                $sheet->setCellValue('I' . $baris, '0');
            } else {
                $sheet->setCellValue('I' . $baris, $k->nilai_konversi);
            }
            $no++;
            $baris++;
        }

        $filename = 'penilaian-uas-mbkm-mahasiswa-'.$th_masuk;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $kriter = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $kriter->save('php://output');
        exit();
    }
    
    public function cetak_nilai_uas_dsn_pdf($id_mbkm_fix)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getMbkmById($id_mbkm_fix),
            'pertanyaanUasDsn' => $this->pertanyaanUas->getPertanyaanDosenUas(),
            'penilaianUtsDsn' => $this->penilaianUas->getPenilaianUasDsn($id_mbkm_fix),
            'totalDsn' => $this->penilaianUas->getTotalNilaiDosenUas($id_mbkm_fix),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/penilaian_uas/pdf_dsn', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-UAS-Dosen' . $data['mbkm']->nm_mhs . '.pdf');
    }
    public function cetak_nilai_uas_mtr_pdf($id_mbkm_fix)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getMbkmById($id_mbkm_fix),
            'pertanyaanUasMtr' => $this->pertanyaanUas->getPertanyaanMitraUas(),
            'penilaianUtsMtr' => $this->penilaianUas->getPenilaianUasMtr($id_mbkm_fix),
            'totalMtr' => $this->penilaianUas->getTotalNilaiMitraUas($id_mbkm_fix),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/penilaian_uas/pdf_mitra', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-UAS-Mitra' . $data['mbkm']->nm_mhs . '.pdf');
    }
    public function index_nilai_akhir()
    {
        $data = [
            'title' => 'Penilaian MBKM',
            'mbkm' => $this->mbkmFix->getAllPenilaian(),
            'mbkmDsn' => $this->mbkmFix->getAllPenilaianByDosen(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'nilaiUts' => $this->penilaianUts->findAll(),
            'nilaiUas' => $this->penilaianUas->findAll(),
            'validation' => $this->validation,
        ];

        return view('mbkm/nilai_akhir/index', $data);
    }
    public function getFilterDataAllNilaiDsn($th_masuk)
    {
        $filterAdmin = $this->mbkmFix->getAllNilaiFilterAdm($th_masuk);
        return json_encode($filterDosen);
    }

    public function getFilterDataAllNilaiAdm($th_masuk)
    {
        $filterAdmin = $this->mbkmFix->getAllNilaiFilterAdm($th_masuk);
        return json_encode($filterAdmin);
        // dd($filterAdmin);
        
    }
    public function cetak_penilaian_akhir_excel($th_masuk)
    {
        $mbkm = $this->mbkmFix->getAllNilaiFilterAdm($th_masuk);
        $sheet = $this->spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Kelas');
        $sheet->setCellValue('D1', 'Nama Mahasiswa');
        $sheet->setCellValue('E1', 'Nama Dosen Pembimbing');
        $sheet->setCellValue('F1', 'Nama Mitra');
        $sheet->setCellValue('G1', 'Nilai UTS');
        $sheet->setCellValue('H1', 'Nilai UAS');
        $sheet->setCellValue('I1', 'Nilai Akhir');
        
        $no = 1;
        $baris = 2;

        foreach ($mbkm as $k) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $k->nim);
            $sheet->setCellValue('C' . $baris, $k->nim);
            $sheet->setCellValue('D' . $baris, $k->nm_mhs);
            $sheet->setCellValue('E' . $baris, $k->nm_staf);
            $sheet->setCellValue('F' . $baris, $k->nm_mitra);
            if($k->nilai_final_uts == null){
                $sheet->setCellValue('G' . $baris, '0');
            } else {
                $sheet->setCellValue('G' . $baris, $k->nilai_final_uts);
            }
            if($k->nilai_final_uas == null){
                $sheet->setCellValue('H' . $baris, '0');
            } else {
                $sheet->setCellValue('H' . $baris, $k->nilai_final_uas);
            }
            if($k->nilai_konversi == null){
                $sheet->setCellValue('I' . $baris, '0');
            } else {
                $sheet->setCellValue('I' . $baris, $k->nilai_konversi);
            }
            $no++;
            $baris++;
        }

        $filename = 'penilaian-akhir-mbkm-mahasiswa-'.$th_masuk;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $kriter = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $kriter->save('php://output');
        exit();
    }
    public function cetak_nilai_akhir_pdf($th_masuk)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getAllNilaiFilterAdm($th_masuk),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/nilai_akhir/pdf', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Rekap-Nilai-Akhir-MBKM-' . $th_masuk . '.pdf');
    }
}