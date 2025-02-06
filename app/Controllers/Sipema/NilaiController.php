<?php

namespace App\Controllers\Sipema;

use App\Models\Sipema\NilaiModel;
use App\Models\Sipema\HasilPemetaanKeterampilanModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MataKuliahModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class NilaiController extends BaseController
{
    public function __construct()
    {
        $this->nilai = new NilaiModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mata_kuliah = new MataKuliahModel();
        $this->hasil_pemetaan_keterampilan = new HasilPemetaanKeterampilanModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Nilai',
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'NilaiMataKuliahMahasiswa' => $this->nilai->getNilaiMataKuliahMahasiswa(),
            'DetailNilaiMataKuliahMahasiswa' => $this->nilai->getDetailNilaiMataKuliahMahasiswa(),
            'activePage' => 'Nilai'
        ];
        return view('sipema/nilai/index', $data);
    }

    public function tambah_mahasiswa()
    {
        $data = [
            'title' => 'Tambah Data Nilai',
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'nilai',
            'validation' => $this->validation,
        ];
        
        return view('sipema/nilai/tambah', $data);
    }

    public function tambah_nilai_mata_kuliah($id_mhs)
    {
        $data = [
            'title' => 'Tambah Data Nilai Mata Kuliah',
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'mahasiswa' => $this->mahasiswa->find($id_mhs),
            'activePage' => 'nilai',
            'validation' => $this->validation,
        ];
        
        return view('sipema/detail_nilai_mahasiswa/tambah', $data);
    }
    
    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_nilai = $uuid->toString();
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $id_mhs = $this->request->getVar('id_mhs');
        $nilai_uts = $this->request->getVar('nilai_uts');
        $nilai_uas = $this->request->getVar('nilai_uas');
        $created_at = round(microtime(true) * 1000);
        $isDuplicate = $this->nilai
                            ->where('id_mhs', $id_mhs)
                            ->whereIn('id_mata_kuliah', $id_mata_kuliah) 
                            ->get()
                            ->getRow();
        $rules = [
            'id_mhs' => [
                'label' => "Nama Mahasiswa",
                'rules' => 'required',
                'errors' => [
                    'required'  => "{field} harus dipilih",
                ]
            ],
        ];

        if($this->validate($rules)) {
            if($isDuplicate){
                session()->setFlashdata('error', 'Terdapat Nama Mata Kuliah sudah ada pada Nama Mahasiswa tersebut');
                return redirect()->back();
                return true;
            }else{
                $data = array();
                $jumlah_mata_kuliah = count((array)$id_mata_kuliah);
                for ($i = 0; $i < $jumlah_mata_kuliah; $i++) {
                    $data[] = array(
                        'id_nilai' => Uuid::uuid4()->toString(),
                        'id_mhs' => $id_mhs,
                        'id_mata_kuliah' => $id_mata_kuliah[$i],
                        'nilai_uts' => $nilai_uts[$i],
                        'nilai_uas' => $nilai_uas[$i],
                        'created_at' => $created_at,
                    );
                }

                $this->nilai->table('sipema_nilai')->insertBatch($data);
                return redirect()->to(base_url('sipema/nilai'))->with('status_icon', 'success')->with('status_text', 'Data nilai berhasil ditambah');
            }
        } else {
            return view('sipema/nilai/tambah', [
                'title' => 'Tambah Data Nilai',
                'mata_kuliah' => $this->mata_kuliah->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'activePage' => 'nilai',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit_mahasiswa($id_mhs)
    {
        $data = [
            'title' => 'Edit Data Nilai',
            'nilai' => $this->nilai->getByIdMahasiswa($id_mhs),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'nilai',
            'validation' => $this->validation,
        ];
        return view('sipema/nilai/edit', $data);
    }

    public function edit_nilai_mata_kuliah($id_mhs, $id_mata_kuliah)
    {
        $data = [
            'title' => 'Edit Data Nilai',
            'nilai' => $this->nilai->getNilaiById($id_mhs, $id_mata_kuliah),
            'mata_kuliah' => $this->mata_kuliah->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'nilai',
            'validation' => $this->validation,
        ];
        return view('sipema/detail_nilai_mahasiswa/edit', $data);
    }

    public function update_mahasiswa($id_mhs = null)
    {
        $id_mhs_input = $this->request->getVar('id_mhs');
        $updated_at = round(microtime(true) * 1000);

        $data = [
            'id_mhs' => $id_mhs_input,
            'updated_at' => $updated_at,
        ];

        $this->nilai->updateMahasiswa($id_mhs, $data);
        return redirect()->to('sipema/nilai')->with('status_icon', 'success')->with('status_text', 'Data nilai berhasil diupdate');
    }

    public function update_nilai_mata_kuliah($id_mhs = null, $id_mata_kuliah = null)
    {
        $id_mata_kuliah_input = $this->request->getVar('id_mata_kuliah');
        $nilai_uts = $this->request->getVar('nilai_uts');
        $nilai_uas = $this->request->getVar('nilai_uas');
        $updated_at = round(microtime(true) * 1000);
        $existingData = $this->nilai
            ->where('id_mhs', $id_mhs)
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
            session()->setFlashdata('error', 'Nama Mata Kuliah sudah ada pada Nama Mahasiswa tersebut');
            return redirect()->back();
            return true;
        }else{
            $data = [
                'id_mata_kuliah' => $id_mata_kuliah_input,
                'id_mhs' => $id_mhs,
                'nilai_uts' => $nilai_uts,
                'nilai_uas' => $nilai_uas,
                'updated_at' => $updated_at,
            ];
            
            $this->nilai
                ->set($data)
                ->where(['id_mhs' => $id_mhs, 'id_mata_kuliah' => $id_mata_kuliah])
                ->update();

            return redirect()->to('sipema/nilai')->with('status_icon', 'success')->with('status_text', 'Data nilai berhasil diupdate');   
        }
    }

    public function hapus_mahasiswa($id_mhs)
    {
        $data = $this->nilai->find($id_mhs);
        $this->nilai->hapusNilaiMataKuliahMahasiswa($id_mhs);
        session()->setFlashdata('status', 'Data nilai berhasil dihapus');
        return redirect()->to(base_url('sipema/nilai'))->with('status_icon', 'success')->with('status_text', 'Data nilai berhasil dihapus');
    }

    public function hapus_nilai_mata_kuliah($id_mhs)
    {
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $data = $this->nilai->find($id_mhs);
        $this->nilai->hapusDetailNilaiMataKuliahMahasiswa($id_mhs, $id_mata_kuliah);
        session()->setFlashdata('status', 'Data nilai berhasil dihapus');
        return redirect()->to(base_url('sipema/nilai'))->with('status_icon', 'success')->with('status_text', 'Data nilai berhasil dihapus');
    }

    public function getDetailNilaiMataKuliahMahasiswa()
    {
        $DetailNilaiMataKuliahMahasiswa = $this->nilai->getDetailNilaiMataKuliahMahasiswa();
        return json_encode($DetailNilaiMataKuliahMahasiswa);
    }   

    public function getMataKuliahByMahasiswa($id_mhs = null)
    {
        $mahasiswa = $this->mahasiswa->find($id_mhs);
        $semester = ($mahasiswa->th_lulus - $mahasiswa->th_masuk) * 2;
        $mataKuliah = $this->mata_kuliah->where('semester <=', $semester)->findAll();
        return json_encode($mataKuliah);
    }

    public function getFilterDataNilaiByIdMahasiswa($id_mhs_filter)
    {
        $filterMahasiswa= $this->nilai->getFilterDataNilaiByIdMahasiswa($id_mhs_filter);
        return json_encode($filterMahasiswa);
    }

    public function getFilterDataNilaiByIdMataKuliah($id_mata_kuliah_filter)
    {
        $filterMataKuliah = $this->nilai->getFilterDataNilaiByIdMataKuliah($id_mata_kuliah_filter);
        return json_encode($filterMataKuliah);
    }

    public function getFilterDataNilaiByNilaiUtsUasFilter($nilai_uts_uas_filter)
    {
        $filterNilaiUtsUas = $this->nilai->getFilterDataNilaiByNilaiUtsUasFilter($nilai_uts_uas_filter);
        return json_encode($filterNilaiUtsUas);
    }

    public function getFilterDataNilaiByIdMahasiswaAndIdMataKuliah($id_mhs_filter, $id_mata_kuliah_filter)
    {
        $filterNilaiMahasiswaMataKuliah = $this->nilai->getFilterDataNilaiByIdMahasiswaAndIdMataKuliah($id_mhs_filter, $id_mata_kuliah_filter);
        return json_encode($filterNilaiMahasiswaMataKuliah);
    }

    public function getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter($id_mhs_filter, $nilai_uts_uas_filter)
    {
        $filterNilaiMahasiswaNilaiUtsUas = $this->nilai->getFilterDataNilaiByIdMahasiswaAndNilaiUtsUasFilter($id_mhs_filter, $nilai_uts_uas_filter);
        return json_encode($filterNilaiMahasiswaNilaiUtsUas);
    }

    public function getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter($id_mata_kuliah_filter, $nilai_uts_uas_filter)
    {
        $filterNilaiMahasiswaNilaiUtsUas = $this->nilai->getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilter($id_mata_kuliah_filter, $nilai_uts_uas_filter);
        return json_encode($filterNilaiMahasiswaNilaiUtsUas);
    }

    public function getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter($id_mhs_filter, $id_mata_kuliah_filter, $nilai_uts_uas_filter)
    {
        $filterNilai = $this->nilai->getFilterDataNilaiByIdMataKuliahAndNilaiUtsUasFilterAndNilaiUtsUasFilter($id_mhs_filter, $id_mata_kuliah_filter, $nilai_uts_uas_filter);
        return json_encode($filterNilai);
    }
}