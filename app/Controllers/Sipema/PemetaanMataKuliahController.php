<?php

namespace App\Controllers\Sipema;

use App\Controllers\BaseController;
use App\Models\Master\MataKuliahModel;
use App\Models\Sipema\BidangModel;
use App\Models\Sipema\SubBidangModel;
use App\Models\Sipema\BobotModel;
use App\Models\Sipema\PemetaanMataKuliahModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PemetaanMataKuliahController extends BaseController
{
    public function __construct()
    {
        $this->pemetaan_mata_kuliah = new PemetaanMataKuliahModel();
        $this->mata_kuliah = new MataKuliahModel();
        $this->bidang = new BidangModel();
        $this->sub_bidang = new SubBidangModel();
        $this->bobot= new BobotModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Pemetaaan Mata Kuliah',
            'bidang' => $this->bidang->findAll(),
            'sub_bidang' => $this->sub_bidang->findAll(),
            'bobot' => $this->bobot->findAll(),
            'DetailPemetaanMataKuliah' => $this->pemetaan_mata_kuliah->getDetailPemetaanMataKuliah(),
        ];
        return view('sipema/pemetaan_mata_kuliah/index', $data);
    }

    public function tambah_sub_bidang_pemetaan()
    {
        $data = [
            'title' => 'Tambah Data Pemetaan Mata Kuliah',
            'sub_bidang' => $this->sub_bidang->findAll(),
            'bobot' => $this->bobot->findAll(),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'activePage' => 'pemetaan mata kuliah',
            'validation' => $this->validation,
        ];
        
        return view('sipema/pemetaan_mata_kuliah/tambah', $data);
    }

    public function tambah_detail_pemetaan_mata_kuliah()
    {
        $data = [
            'title' => 'Tambah Data Nilai Mata Kuliah',
            'sub_bidang' => $this->sub_bidang->findAll(),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'bobot' => $this->bobot->findAll(),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'activePage' => 'pemetaan mata kuliah',
            'validation' => $this->validation,
        ];
        
        return view('sipema/detail_pemetaan_mata_kuliah/tambah', $data);
    }

    public function simpan()
    {
        $id_sub_bidang = $this->request->getVar('id_sub_bidang');
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $id_bobot = $this->request->getVar('id_bobot');
        $created_at = round(microtime(true) * 1000);
        $isDuplicate = $this->pemetaan_mata_kuliah
                            ->where('id_sub_bidang', $id_sub_bidang)
                            ->whereIn('id_mata_kuliah', $id_mata_kuliah) 
                            ->get()
                            ->getRow();
                            
        $rules = [
            'id_sub_bidang' => [
                'label' => "Nama Sub Bidang",
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} harus dipilih",
                ]
            ],
        ];
       
        if($this->validate($rules)) {
            if($isDuplicate){
                session()->setFlashdata('error', 'Terdapat Nama Mata Kuliah sudah ada pada Nama Sub Bidang tersebut');
                return redirect()->back();
            }else{
                $data = array();
                $jumlah_mata_kuliah = count((array)$id_mata_kuliah);
                for ($i = 0; $i < $jumlah_mata_kuliah; $i++) {
                    $data[] = array(
                        'id_pmk' => Uuid::uuid4()->toString(),
                        'id_sub_bidang' => $id_sub_bidang,
                        'id_mata_kuliah' => $id_mata_kuliah[$i],
                        'id_bobot' => $id_bobot[$i],
                        'created_at' => $created_at,
                    );
                }
                $this->pemetaan_mata_kuliah->table('sipema_pemetaan_mata_k')->insertBatch($data);
                return redirect()->to(base_url('sipema/pemetaan_mata_kuliah'))->with('status_icon', 'success')->with('status_text', 'Data pemetaan mata kuliah berhasil ditambah');
            }
        } else {
            return view('sipema/pemetaan_mata_kuliah/tambah', [
                'title' => 'Tambah Data Pemetaan Mata Kuliah',
                'sub_bidang' => $this->sub_bidang->findAll(),
                'bobot' => $this->bobot->findAll(),
                'mata_kuliah' => $this->mata_kuliah->findAll(),
                'activePage' => 'pemetaan mata kuliah',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit_sub_bidang_pemetaan($id_sub_bidang)
    {
        $data = [
            'title' => 'Edit Data Pemetaan Mata Kuliah',
            'pemetaan_mata_kuliah' => $this->pemetaan_mata_kuliah->getSubBidangPemetaanById($id_sub_bidang),
            'sub_bidang' => $this->sub_bidang->findAll(),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'activePage' => 'pemetaan mata kuliah',
            'validation' => $this->validation,
        ];
        return view('sipema/pemetaan_mata_kuliah/edit', $data);
    }
    
    public function edit_detail_pemetaan_mata_kuliah($id_sub_bidang, $id_mata_kuliah)
    {
        $data = [
            'title' => 'Edit Data Detail Pemetaan Mata Kuliah',
            'detail_pemetaan_mata_kuliah' => $this->pemetaan_mata_kuliah->updateDetailPemetaanMataKuliah($id_sub_bidang, $id_mata_kuliah),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'bobot' => $this->bobot->findAll(),
            'activePage' => 'pemetaan mata kuliah',
            'validation' => $this->validation,
        ];
        
        return view('sipema/detail_pemetaan_mata_kuliah/edit', $data);
    }

    public function update_sub_bidang_pemetaan($id = null)
    {
        $id_sub_bidang = $this->request->getVar('id_sub_bidang');
        $updated_at = round(microtime(true) * 1000);
        $data = [
            'id_sub_bidang' => $id_sub_bidang,
            'updated_at' => $updated_at
        ];

        $this->pemetaan_mata_kuliah->set($data)->where('id_sub_bidang', $id)->update();
        return redirect()->to('sipema/pemetaan_mata_kuliah')->with('status_icon', 'success')->with('status_text', 'Data pemetaan mata kuliah berhasil diupdate');
    }    

    public function update_detail_pemetaan_mata_kuliah($id_sub_bidang, $id_mata_kuliah)
    {
        $id_mata_kuliah_input = $this->request->getVar('id_mata_kuliah');
        $id_bobot = $this->request->getVar('id_bobot');
        $updated_at = round(microtime(true) * 1000);
        $existingData = $this->pemetaan_mata_kuliah
            ->where('id_sub_bidang', $id_sub_bidang)
            ->where('id_mata_kuliah !=', $id_mata_kuliah)
            ->get()
            ->getResult();

        $isDuplicate = false;
        foreach ($existingData as $data) {
            if ($data->id_mata_kuliah == $id_mata_kuliah_input) {
                $isDuplicate = true;
                break;
            }
        }

        if ($isDuplicate) {
            session()->setFlashdata('error', 'Nama Mata Kuliah sudah ada pada Nama Sub Bidang tersebut');
            return redirect()->back();
        } else {
            $data = [
                'id_mata_kuliah' => $id_mata_kuliah_input,
                'id_bobot' => $id_bobot,
                'updated_at' => $updated_at,
            ];

            $this->pemetaan_mata_kuliah
                ->set($data)
                ->where(['id_sub_bidang' => $id_sub_bidang, 'id_mata_kuliah' => $id_mata_kuliah])
                ->update();

            return redirect()->to('sipema/pemetaan_mata_kuliah')
                ->with('status_icon', 'success')
                ->with('status_text', 'Data pemetaan mata kuliah berhasil diupdate');
        }
    }

    public function hapus_sub_bidang_pemetaan($id_sub_bidang)
    {
        $this->pemetaan_mata_kuliah->where('id_sub_bidang', $id_sub_bidang)->delete();
        session()->setFlashdata('status_icon', 'success');
        session()->setFlashdata('status_text', 'Data Pemetaan Mata Kuliah berhasil dihapus');
        return redirect()->to(base_url('sipema/pemetaan_mata_kuliah/'));
    }

    public function hapus_detail_pemetaan_mata_kuliah($id_sub_bidang)
    {
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $this->pemetaan_mata_kuliah->where(['id_sub_bidang' => $id_sub_bidang, 'id_mata_kuliah' => $id_mata_kuliah])->delete();
        session()->setFlashdata('status_icon', 'success');
        session()->setFlashdata('status_text', 'Data Mata kuliah pada Sub Bidang berhasil dihapus');
        return redirect()->to(base_url('sipema/pemetaan_mata_kuliah/'));
    }

    public function getDataFilterPemetaan($id_bidang_filter_pemetaan, $id_sub_bidang_filter_pemetaan = null, $jenis_bobot_filter_pemetaan = null)
    {
        $data = $this->pemetaan_mata_kuliah->getDataFilterPemetaan($id_bidang_filter_pemetaan, $id_sub_bidang_filter_pemetaan, $jenis_bobot_filter_pemetaan);
        return json_encode($data);
    }

    public function getDataFilterPemetaanBidangJenisBobot($id_bidang_filter_pemetaan, $jenis_bobot_filter_pemetaan)
    {
        $data = $this->pemetaan_mata_kuliah->getDataFilterPemetaanBidangJenisBobot($id_bidang_filter_pemetaan, $jenis_bobot_filter_pemetaan);
        return json_encode($data);
    }

    public function getDataFilterPemetaanJenisBobot($jenis_bobot_filter_pemetaan)
    {
        $data = $this->pemetaan_mata_kuliah->getDataFilterPemetaanJenisBobot($jenis_bobot_filter_pemetaan);
        return json_encode($data);
    }

    public function getDetailPemetaanMataKuliah()
    {
        $data = $this->pemetaan_mata_kuliah->getDetailPemetaanMataKuliah();
        return json_encode($data);
    }
}
