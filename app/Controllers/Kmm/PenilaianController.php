<?php

namespace App\Controllers\Kmm;

use App\Controllers\BaseController;
use App\Models\Kmm\BobotModel;
use App\Models\Kmm\KmmModel;
use App\Models\Kmm\PenilaianModel;
use App\Models\Kmm\PertanyaanPenilaianModel;
use App\Models\Kmm\TotalNilaiModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MitraModel;
use App\Models\Master\StafModel;
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
        $this->kmm = new KmmModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->pertanyaan = new PertanyaanPenilaianModel();
        $this->penilaian = new PenilaianModel();
        $this->total = new TotalNilaiModel();
        $this->bobot = new BobotModel();
        $this->spreadsheet = new Spreadsheet();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Penilaian KMM',
            'kmm' => $this->kmm->getKMMbyIdDosen(),
            'kmm2' => $this->kmm->getKMMbyIdMitra(),
            'kmm3' => $this->kmm->getKMM(),
            'penilaian' => $this->penilaian->findAll(),
            'total' => $this->total->getPenilaian(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
        ];
        return view('kmm/penilaian/index', $data);
    }

    public function penilaian_dosen($id_kmm)
    {
        $data = [
            'title' => 'Penilaian KMM',
            'kmm' => $this->kmm->find($id_kmm),
            'pertanyaan_dsn' => $this->pertanyaan->getPertanyaanDosen(),
            'nilai_maks_pertanyaan' => $this->pertanyaan->getTotalNilaiMaksPertanyaanDosen(),
            'validation' => $this->validation,
        ];

        return view('kmm/penilaian/tambah2', $data);
    }

    public function penilaian_mitra($id_kmm)
    {
        $data = [
            'title' => 'Penilaian KMM',
            'kmm' => $this->kmm->find($id_kmm),
            // 'pertanyaan_dsn' => $this->pertanyaan->getPertanyaanDosen(),
            'pertanyaan_mtr' => $this->pertanyaan->getPertanyaanMitra(),
            'validation' => $this->validation,
        ];

        return view('kmm/penilaian/tambah', $data);
    }

    public function simpan_penilaian_mitra($id_kmm)
    {
        $uuid = Uuid::uuid4();
        $id_penilaian = $uuid->toString();
        $id_kmm = $this->request->getVar('id_kmm');
        $id_pertanyaan = $this->request->getVar('id_pertanyaan');
        $nilai = $this->request->getVar('nilai');

        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            // Menyimpan Nilai dari Form Penilaian
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan); $i++) {
                $data = array(
                    'id_penilaian' => $id_penilaian++,
                    'id_kmm' => $id_kmm,
                    'id_pertanyaan' => $id_pertanyaan[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;  
            }
            $this->penilaian->insertBatch($data_arr);
            
            // Mendapatkan Bobot Penilaian
            $bobot = $this->bobot->getBobot();
            $bobot_mitra = ($bobot->bobot_mitra) / 100;
            $bobot_dosen = ($bobot->bobot_dosen) / 100;

            // Menghitung Total Penilaian Mitra
            $total_nilai_mitra = $this->penilaian->getTotalNilaiMitra($id_kmm);
            $nilai_total_mitra = $total_nilai_mitra * ($bobot_mitra);

            // Mendapatkan Data Total Penilaian dari database
            $total = $this->total->getTotalNilai($id_kmm);
            $id_total = $total->id_total_nilai;
            $total_nilai_dosen = $this->penilaian->getTotalNilaiDosen($id_kmm);
            $total_dosen = ($total_nilai_dosen) * $bobot_dosen;

            // Menghitung Nilai Akhir Penilaian
            $nilai_akhir = $total_dosen + $nilai_total_mitra;
            
            // Memasukkan / Mengupdate Total Penilaian Mitra dalam database
            $data2 = array(
                'id_total_nilai' => $id_total,
                'nilai_total_mitra' => $total_nilai_mitra,
                'nilai_akhir' => $nilai_akhir,
            );
            $this->total->save($data2);

            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('kmm/penilaian');
        } else {
            return view('kmm/penilaian/tambah', [
                'title' => 'Penilaian KMM',
                'kmm' => $this->kmm->find($id_kmm),
                'pertanyaan_mtr' => $this->pertanyaan->getPertanyaanMitra(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function simpan_penilaian_dosen($id_kmm)
    {
        $uuid = Uuid::uuid4();
        $id_penilaian = $uuid->toString();
        $id_kmm = $this->request->getVar('id_kmm');
        $id_pertanyaan = $this->request->getVar('id_pertanyaan');
        $nilai = $this->request->getVar('nilai');

        $rules = [
            'nilai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nilai harus diisi",
                ],
            ],
        ];
        
        if ($this->validate($rules)) {
            // Menyimpan Nilai dari Form Penilaian
            $data_arr = [];
            for ($i = 0; $i < sizeof($id_pertanyaan); $i++) {
                $data = array(
                    'id_penilaian' => $id_penilaian++,
                    'id_kmm' => $id_kmm,
                    'id_pertanyaan' => $id_pertanyaan[$i],
                    'nilai' => $nilai[$i],
                );
                $data_arr[] = $data;
            }
            $this->penilaian->insertBatch($data_arr);
            
            // Mendapatkan Bobot Penilaian
            $bobot = $this->bobot->getBobot();
            $bobot_dosen = ($bobot->bobot_dosen) / 100;
            $bobot_mitra = ($bobot->bobot_mitra) / 100;
            
            // Mendapatkan Data Total Penilaian dari database
            $total = $this->total->getTotalNilai($id_kmm);
            $total_nilai_mitra = $this->penilaian->getTotalNilaiMitra($id_kmm);
            $id_total = $total->id_total_nilai;
            $total_mitra = ($total_nilai_mitra) * $bobot_mitra;
            
            // Menghitung Total Penilaian Dosen
            $total_nilai_dosen = $this->penilaian->getTotalNilaiDosen($id_kmm);
            $nilai_total_dosen = ($total_nilai_dosen * $bobot_dosen);

            // Menghitung Nilai Akhir Penilaian
            $nilai_akhir = $nilai_total_dosen + $total_mitra;
            
            // Memasukkan atau Mengupdate Data Total Penilaian Dosen dalam database
            $data = [
                'id_total_nilai' => $id_total,
                'nilai_total_dosen' => $total_nilai_dosen,
                'nilai_akhir' => $nilai_akhir,
            ];
            $this->total->save($data);

            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('kmm/penilaian');
        } else {
            return view('kmm/penilaian/tambah2', [
                'title' => 'Penilaian KMM',
                'kmm' => $this->kmm->find($id_kmm),
                'pertanyaan_dsn' => $this->pertanyaan->getPertanyaanDosen(),
                'pertanyaan_mtr' => $this->pertanyaan->getPertanyaanMitra(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function getFilterDataNilaiByIdDosen($th_masuk)
    {
        $filterDosen = $this->total->getFilterDataNilaiByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }
    
    public function getFilterDataNilai($th_masuk)
    {
        $filterAdmin = $this->total->getFilterDataNilai($th_masuk);
        return json_encode($filterAdmin);
    }

    public function cetak_penilaian_prodi_pdf($id_kmm)
    {
        $data = [
            'kmm' => $this->kmm->getKMMById($id_kmm),
            'pertanyaan' => $this->pertanyaan->getPertanyaanDosen(),
            'penilaian' => $this->penilaian->getPenilaian(),
            'total' => $this->penilaian->getTotalNilaiDosen($id_kmm),
        ];
        
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('kmm/penilaian/penilaian_prodi', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-Prodi-'.$data['kmm']->nm_mhs.'.pdf');
    }
    
    public function cetak_penilaian_mitra_pdf($id_kmm)
    {
        $data = [
            'kmm' => $this->kmm->getKMMById($id_kmm),
            'pertanyaan' => $this->pertanyaan->getPertanyaanMitra(),
            'penilaian' => $this->penilaian->getPenilaianMitra(),
            'total' => $this->penilaian->getTotalNilaiMitra($id_kmm),
        ];
        
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('kmm/penilaian/penilaian_mitra', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Penilaian-Mitra-'.$data['kmm']->nm_mhs.'.pdf');
    }

    public function cetak_penilaian_excel($th_masuk)
    {
        $kmm = $this->total->getFilterDataNilai($th_masuk);
        $sheet = $this->spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIM');
        $sheet->setCellValue('C1', 'Nama Mahasiswa');
        $sheet->setCellValue('D1', 'Nama Dosen Pembimbing');
        $sheet->setCellValue('E1', 'Nama Mitra');
        $sheet->setCellValue('F1', 'Total Nilai Dosen');
        $sheet->setCellValue('G1', 'Total Nilai Dosen');
        $sheet->setCellValue('H1', 'Total Penilaian');
        
        $no = 1;
        $baris = 2;

        foreach ($kmm as $k) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $k->nim);
            $sheet->setCellValue('C' . $baris, $k->nm_mhs);
            $sheet->setCellValue('D' . $baris, $k->nm_staf);
            $sheet->setCellValue('E' . $baris, $k->nama_instansi);
            if($k->nilai_total_dosen == null){
                $sheet->setCellValue('F' . $baris, '0');
            } else {
                $sheet->setCellValue('F' . $baris, $k->nilai_total_dosen);
            }
            if($k->nilai_total_mitra == null){
                $sheet->setCellValue('G' . $baris, '0');
            } else {
                $sheet->setCellValue('G' . $baris, $k->nilai_total_mitra);
            }
            if($k->nilai_akhir == null){
                $sheet->setCellValue('H' . $baris, '0');
            } else {
                $sheet->setCellValue('H' . $baris, $k->nilai_akhir);
            }
            $no++;
            $baris++;
        }

        $filename = 'penilaian-kmm-mahasiswa-'.$th_masuk;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $kriter = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $kriter->save('php://output');
        exit();
    }
}