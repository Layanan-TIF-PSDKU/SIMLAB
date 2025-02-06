<?php

namespace App\Controllers\Sipema;

use App\Controllers\BaseController;
use App\Models\Sipema\RekomendasiMahasiswaModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Sipema\SubBidangModel;
use App\Models\Master\StafModel;
use App\Models\Sipema\PemetaanMataKuliahModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class RekomendasiController extends BaseController
{
    public function __construct()
    {
        $this->rekomendasi_mahasiswa = new RekomendasiMahasiswaModel();
        $this->pemetaan_mata_kuliah = new PemetaanMataKuliahModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->sub_bidang = new SubBidangModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Rekomendasi Mahasiswa',
            'rekomendasi_mahasiswa' => $this->rekomendasi_mahasiswa->getRekomendasiMahasiswa(),
        ];
        return view('sipema/rekomendasi/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Rekomendasi Mahasiswa',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'sub_bidang' => $this->sub_bidang->findAll(),
            'activePage' => 'rekomendasi mahasiswa',
            'validation' => $this->validation,
        ];
        
        return view('sipema/rekomendasi/tambah', $data);
    }

    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_rekomendasi_m = $uuid->toString();
        $id_staf = $this->request->getVar('id_staf');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_sub_bidang = $this->request->getVar('id_sub_bidang');
        $created_at = round(microtime(true) * 1000);
        
        $rules = [
            'id_mhs' => [
                'label' => "Nama Mahasiswa",
                'rules' => 'required|is_unique[sipema_rekomendasi_m.id_mhs,id_rekomendasi_m,'.$id_rekomendasi_m.']',
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            if($id_staf == null || $id_staf == ''){
                session()->setFlashdata('error', 'Data rekomendasi mahasiswa gagal ditambahkan');
                return redirect()->to(base_url('sipema/rekomendasi'))->with('status_icon', 'error')->with('status_text', 'Dosen yang login tidak sesuai dengan mata kuliah pada sub bidang yang diampu');
            }else{
                $data = [
                    'id_rekomendasi_m' => $uuid,
                    'id_mhs' => $id_mhs,
                    'id_staf' => $id_staf,
                    'id_sub_bidang' => $id_sub_bidang,
                    'created_at' => $created_at,
                ];
                $this->rekomendasi_mahasiswa->insert($data);
                return redirect()->to(base_url('sipema/rekomendasi'))->with('status_icon', 'success')->with('status_text', 'Data rekomendasi mahasiswa berhasil ditambah');
            }
        } else {
            return view('sipema/rekomendasi/tambah', [
                'title' => 'Tambah Data Rekomendasi Mahasiswa',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'sub_bidang' => $this->sub_bidang->findAll(),
                'activePage' => 'rekomendasi mahasiswa',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Rekomendasi Mahasiswa',
            'rekomendasi_mahasiswa' => $this->rekomendasi_mahasiswa->select('sipema_rekomendasi_m.*, staf.nama AS nama_dosen')->join('staf', 'staf.id_staf = sipema_rekomendasi_m.id_staf')->find($id),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'sub_bidang' => $this->sub_bidang->findAll(),
            'activePage' => 'rekomendasi mahasiswa',
            'validation' => $this->validation,
        ];
        return view('sipema/rekomendasi/edit', $data);
    }

    public function update($id = null)
    {
        $id_staf = $this->request->getVar('id_staf');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_sub_bidang = $this->request->getVar('id_sub_bidang');
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'id_mhs' => [
                'label' => 'Nama Mahasiswa',
                'rules' => 'required|is_unique[sipema_rekomendasi_m.id_mhs,id_rekomendasi_m,'.$id.']',
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ]
            ],
        ];

        if($this->validate($rules)) {
            if($this->sub_bidang->getRekomendasiByDosen($id_sub_bidang, $this->auth->user()->id) != null){
                $data = [
                    'id_mhs' => $id_mhs,
                    'id_staf' => $id_staf,
                    'id_sub_bidang' => $id_sub_bidang,
                    'updated_at' => $updated_at,
                ];
    
                $this->rekomendasi_mahasiswa->update($id, $data);
                return redirect()->to('sipema/rekomendasi')->with('status_icon', 'success')->with('status_text', 'Data rekomendasi mahasiswa berhasil diupdate');
            }else{
                return redirect()->back()->with('status_icon', 'error')->with('status_text', 'Data rekomendasi gagal diubah, Anda tidak berhak mengubah');
            }
        }else{
            return view('sipema/rekomendasi/edit', [
                'title' => 'Edit Data Rekomendasi Mahasiswa',
                'rekomendasi_mahasiswa' => $this->rekomendasi_mahasiswa->select('sipema_rekomendasi_m.*, staf.nama AS nama_dosen')->join('staf', 'staf.id_staf = sipema_rekomendasi_m.id_staf')->find($id),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'sub_bidang' => $this->sub_bidang->findAll(),
                'activePage' => 'rekomendasi mahasiswa',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->rekomendasi_mahasiswa->find($id);
        $this->rekomendasi_mahasiswa->delete($id);
        return redirect()->to(base_url('sipema/rekomendasi'))->with('status_icon', 'success')->with('status_text', 'Data rekomendasi mahasiswa berhasil dihapus');
    }

    public function get_dosen_by_sub_bidang_id($id_sub_bidang)
    {
        $id_user = $this->user()->id;
        $data = $this->sub_bidang->getRekomendasiByDosen($id_sub_bidang, $id_user);
        return json_encode($data);
    }

}
