<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\KmmModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Master\MitraModel;
use App\Controllers\BaseController;

class LapAkhirController extends BaseController
{
    public function __construct()
    {
        $this->kmm = new KmmModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Laporan Akhir KMM',
            'kmm' => $this->kmm->getKMMbyIdMhs(),
            'kmm2' => $this->kmm->getKMMbyIdDosen(),
            'kmm3' => $this->kmm->getAllKMM(),
            'kmm4' => $this->kmm->getKMMbyIdMitra(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'mitra' => $this->mitra->findAll(),
        ];

        return view('kmm/lap_akhir/index', $data);
    }

    public function upload_lap_akhir($id_kmm)
    {
        $laporan_akhir = $this->request->getFile('laporan_akhir');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'laporan_akhir' => [
                'rules' => "ext_in[laporan_akhir,pdf]|max_size[laporan_akhir,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                    ]
            ],
        ];

        if($this->validate($rules)) {
            $laporan = $this->kmm->find($id_kmm);
            $old_lap_akhir = $laporan->laporan_akhir;
            if($laporan->laporan_akhir != null) {
                if($laporan_akhir->isValid() && !$laporan_akhir->hasMoved())
                {
                    if(file_exists('kmm_assets/laporan-akhir/' . $old_lap_akhir)){
                        unlink('kmm_assets/laporan-akhir/' . $old_lap_akhir);
                    }
                       $laporanName = $laporan_akhir->getRandomName();
                       $laporan_akhir->move('kmm_assets/laporan-akhir/', $laporanName);
                } else {
                        $laporanName = $laporan->laporan_akhir;
                }
            } else {
                $laporanName = $laporan_akhir->getRandomName();
                $laporan_akhir->move('kmm_assets/laporan-akhir/', $laporanName);
            }
            
            $data = [
                'laporan_akhir' => $laporanName,
                'status_laporan' => 'pending',
                'updated_at' => $updated_at,
            ];

            $this->kmm->update($id_kmm, $data);
            session()->setFlashdata('success', 'Laporan Akhir Berhasil Diupload!');
            return redirect()->to('kmm/lap-akhir');
        } else {
            session()->setFlashdata('error', 'Laporan Akhir Gagal Diupload!');
            return redirect()->to('kmm/lap-akhir');
        }
        
    }

    public function download_lap_akhir($id_kmm)
    {
        $lap_akhir = $this->kmm->find($id_kmm);       
        return $this->response->download('kmm_assets/laporan-akhir/' . $lap_akhir->laporan_akhir, null);
    }

    public function verif_disetujui($id_kmm){
        $data = [
            'status_laporan' => 'disetujui',
            'catatan_lap_akhir' => 'Tidak Ada Catatan',
        ];

        $this->kmm->update($id_kmm, $data);
        session()->setFlashdata('success', 'Laporan Akhir Disetujui!');
        return redirect()->to('kmm/lap-akhir');
    }
    
    public function verif_revisi($id_kmm){
        $status_laporan = 'revisi';
        $catatan_lap_akhir = $this->request->getVar('catatan_lap_akhir');

        $rules = [
            'catatan_lap_akhir' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Catatan harus diisi",
                ]
            ],
        ];

        if($this->validate($rules)){
            $data = [
                'status_laporan' => $status_laporan,
                'catatan_lap_akhir' => $catatan_lap_akhir,
            ];
            $this->kmm->update($id_kmm, $data);
            session()->setFlashdata('success', 'Update Status Berhasil!');
            return redirect()->to('kmm/lap-akhir');
        } else {
            session()->setFlashdata('error', 'Catatan Wajib Diisi!');
            return redirect()->to('kmm/lap-akhir');
        }
    }

    public function getFilterDataLapAkhir($th_masuk)
    {
        $filter = $this->kmm->getFilterDataLapAkhir($th_masuk);
        return json_encode($filter);
    }

    public function getFilterDataLapAkhirByIdDosen($th_masuk)
    {
        $filterDosen = $this->kmm->getFilterDataLapAkhirByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }
}