<?php

namespace App\Controllers\Sipema;

use App\Models\Sipema\SubBidangModel;
use App\Models\Sipema\HasilPemetaanKeterampilanModel;
use App\Models\Sipema\NilaiModel;
use App\Models\Sipema\PemetaanMataKuliahModel;
use App\Models\Sipema\BidangModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MataKuliahModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class HasilPemetaanKeterampilanController extends BaseController
{
    public function __construct()
    {
        $this->sub_bidang = new SubBidangModel();
        $this->hasil_pemetaan_keterampilan = new HasilPemetaanKeterampilanModel();
        $this->bidang = new BidangModel();
        $this->sub_bidang = new SubBidangModel();
        $this->nilai = new NilaiModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $this->hasil_pemetaan_keterampilan->getCekHapusDataIdSubBidang();
        $this->hasil_pemetaan_keterampilan->getCekHapusDataIdMahasiswa();

        $data = [
            'title' => 'Data Hasil Pemetaan Keterampilan',
            'bidang' => $this->bidang->findAll(),
            'sub_bidang' => $this->sub_bidang->findAll(),
            'hasil_pemetaan_keterampilan' => $this->hasil_pemetaan_keterampilan->getKalkulasiHasilPemetaan(),
            'activePage' => 'hasil pemetaan keterampilan'
        ];

        function randomColor() {
            $letters = '0123456789ABCDEF';
            $color = '#';
            for ($i = 0; $i < 6; $i++) {
                $color .= $letters[rand(0, 15)];
            }
            return $color;
        }

        // Grafik Antar Sub Bidang Seluruh Mahasiswa
        $results = $this->hasil_pemetaan_keterampilan->getChartDataMahasiswaBySubBidang();
        $data2 = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Nilai Akhir',
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1
                ]
            ]
        ];
        
        foreach ($results as $result) {
            array_push($data2['labels'], $result->nama_mahasiswa . "\n" . $result->nama_sub_bidang);
            array_push($data2['datasets'][0]['data'], $result->nilai_akhir);
            array_push($data2['datasets'][0]['backgroundColor'], randomColor());
            array_push($data2['datasets'][0]['borderColor'], randomColor());
        }

        // Grafik Antar Sub Bidang
        $results2 = $this->hasil_pemetaan_keterampilan->getAllChartData();
        $data3 = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Nilai Akhir',
                    'data' => [],
                    'backgroundColor' => [],
                    'borderColor' => [],
                    'borderWidth' => 1
                ]
            ]
        ];
        
        foreach ($results2 as $result2) {
            array_push($data3['labels'], $result2->nama_bidang . ' - ' . $result2->nama_sub_bidang);
            array_push($data3['datasets'][0]['data'], $result2->nilai_akhir);
            array_push($data3['datasets'][0]['backgroundColor'], randomColor());
            array_push($data3['datasets'][0]['borderColor'], randomColor());
        }
        
        return view('sipema/hasil_pemetaan_keterampilan/index', ['data2' => $data2, 'data3' => $data3] + $data);
    }
    
    public function getDataSubBidang($id_bidang, $id_sub_bidang = null, $nilai_akhir_filter = null, $sks_filter = null){
        $data = $this->hasil_pemetaan_keterampilan->getDataSubBidang($id_bidang, $id_sub_bidang, $nilai_akhir_filter, $sks_filter);
        return json_encode($data);
    }

    public function getSubBidangByBidang($id_bidang) {
        $sub_bidang = $this->hasil_pemetaan_keterampilan->getSubBidangByBidang($id_bidang);
        return json_encode($sub_bidang);
    }

    public function getChartDataByMahasiswa($id_mhs)
    {
        $results = $this->hasil_pemetaan_keterampilan->getChartData($id_mhs);
        $data = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Nilai Akhir',
                    'data' => [],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)'
                ]
            ]
        ];
        foreach ($results as $result) {
            array_push($data['labels'], $result->nama_bidang . ' - ' . $result->nama_sub_bidang);
            array_push($data['datasets'][0]['data'], $result->nilai_akhir);
        }
        return json_encode($data);
    }

    public function getDataBidangNilaiAkhirSks($id_bidang, $nilai_akhir_filter, $sks_filter)
    {
        $data = $this->hasil_pemetaan_keterampilan->getDataBidangNilaiAkhirSks($id_bidang, $nilai_akhir_filter, $sks_filter);
        return json_encode($data);
    }

    public function getDataBidangNilaiAkhir($id_bidang, $nilai_akhir_filter)
    {
        $data = $this->hasil_pemetaan_keterampilan->getDataBidangNilaiAkhir($id_bidang, $nilai_akhir_filter);
        return json_encode($data);
    }

    public function getDataBidangSks($id_bidang, $sks_filter)
    {
        $data = $this->hasil_pemetaan_keterampilan->getDataBidangSks($id_bidang, $sks_filter);
        return json_encode($data);
    }

    public function getDataBidangSubBidangSks($id_bidang, $id_sub_bidang, $sks_filter)
    {
        $data = $this->hasil_pemetaan_keterampilan->getDataBidangSubBidangSks($id_bidang, $id_sub_bidang, $sks_filter);
        return json_encode($data);
    }
}