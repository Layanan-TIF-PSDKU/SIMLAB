<?php

namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Master\MataKuliahModel;
use App\Models\Simlab\JadwalRuangModel;
use App\Models\Simlab\RuangLaboratoriumModel;
use App\Models\Simlab\PeminjamanRuangModel;
use Ramsey\Uuid\Uuid;

class JadwalRuangController extends BaseController
{
    public function __construct()
    {
        $this->jadwal = new JadwalRuangModel();
        $this->ruanglab = new RuangLaboratoriumModel();
        $this->pinjamruang = new PeminjamanRuangModel();
        $this->matakuliah = new MataKuliahModel();
        $this->validation = \Config\Services::validation();
    }

    public function pilih_kondisi()
    {
        $data = [
            'title' => 'Penggunaan Ruang Laboratorium',
            // 'ruanglab' => $this->ruanglab->find($id_ruang),
            'activePage' => 'penggunaan-ruang-laboratorium/pilih_kondisi',
        ];

        return view('simlab/jadwalruang/pilih_kondisi', $data);
    }
    public function pilih_ruang_praktikum()
    {
        $data = [
            'title' => 'Data Ruang Laboratorium',
            'dataruanglab' => $this->ruanglab->orderBy('nama_ruang', 'ASC')->findAll(),
            'activePage' => 'penggunaan-ruang-laboratorium/pilih_ruang/praktikum',
        ];

        return view('simlab/jadwalruang/pilih_ruang_praktikum', $data);
    }
    public function pilih_ruang_peminjaman()
    {
        $data = [
            'title' => 'Data Ruang Laboratorium',
            'dataruanglab' => $this->ruanglab->orderBy('nama_ruang', 'ASC')->findAll(),
            'activePage' => 'penggunaan-ruang-laboratorium/pilih_ruang/peminjaman',
        ];

        return view('simlab/jadwalruang/pilih_ruang_peminjaman', $data);
    }
    
    public function lihat($id_ruang)
    {
        $data = [
            'title' => 'Data Jadwal Mata Kuliah Praktikum',
            'ruanglab' => $this->ruanglab->find($id_ruang),
            'jadwal' => $this->jadwal->getJadwalRuang($id_ruang),
            'validation' => $this->validation,
            'matakuliah' => $this->matakuliah->findAll(),
            'activePage' => 'penggunaan-ruang-laboratorium',
        ];

        return view('simlab/jadwalruang/index', $data);
    }

    public function lihat_ruang_dipinjam($id_ruang)
    {
        $data = [
            'title' => 'Data Penggunaan Ruang Diluar Mata Kuliah Praktikum',
            'ruanglab' => $this->ruanglab->find($id_ruang),
            'ruangdipinjam' => $this->pinjamruang->getRuangDipinjam($id_ruang),
            'validation' => $this->validation,
            'activePage' => 'penggunaan-ruang-laboratorium',
        ];
    
        return view('simlab/jadwalruang/lihat_ruang_dipinjam', $data);
    }

    public function tambah($id_ruang)
    {
        $data = [
            'title' => 'Tambah Data Jadwal Mata Kuliah Praktikum',
            'ruanglab' => $this->ruanglab->find($id_ruang),
            'matakuliah' => $this->matakuliah->findAll(),
            'validation' => $this->validation,
            'activePage' => 'penggunaan-ruang-laboratorium',
        ];
        return view('simlab/jadwalruang/tambah', $data);
    }

    public function simpan()
    {

        $uuid = Uuid::uuid4();
        $id_jadwal = $uuid->toString();
        $id_ruang = $this->request->getVar('id_ruang');
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $kelas = $this->request->getVar('kelas');
        $hari = $this->request->getVar('hari');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $semester = $this->request->getVar('semester');
        $waktu_mulai = $this->request->getVar('waktu_mulai');
        $waktu_selesai = $this->request->getVar('waktu_selesai');

        $rules = [
            'kelas' => [
                'label' => "Kelas",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'hari' => [
                'label' => "Hari",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        $cekKetersediaanRuangByJadwalPraktikum = $this->jadwal->cekKetersediaanRuangByJadwalPraktikum($id_ruang, $hari, $tahun_ajaran, $waktu_mulai, $waktu_selesai);
        if ($cekKetersediaanRuangByJadwalPraktikum > 0) {
            session()->setFlashdata('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
            return redirect()->to('simlab/penggunaan-ruang-laboratorium/tambah/'. $id_ruang)->with('status_icon', 'error');
            // echo 'Ruang laboratorium tersedia pada tanggal dan waktu tersebut.';
        } else {

        }

        if ($this->validate($rules)) {
            $data = [
                'id_jadwal' => $uuid,
                'id_ruang' => $id_ruang,
                'id_mata_kuliah' => $id_mata_kuliah,
                'kelas' => $kelas,
                'hari' => $hari,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
            ];
            $this->jadwal->insert($data);
            session()->setFlashdata('success', 'Data Jadwal Mata Kuliah Praktikum Berhasil Ditambahkan!');
            return redirect()->to('simlab/penggunaan-ruang-laboratorium/lihat/'. $id_ruang)->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simlab/jadwalruang/tambah', [
                'title' => 'Tambah Data Jadwal Mata Kuliah Praktikum',
                'ruanglab' => $this->ruanglab->findAll(),
                'matakuliah' => $this->matakuliah->findAll(),
                'activePage' => 'penggunaan-ruang-laboratorium',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_ruang, $id_jadwal)
    {
        $data = [
            'title' => 'Edit Data Jadwal Mata Kuliah Praktikum',
            'jadwal' => $this->jadwal->getJadwalByRuang($id_ruang, $id_jadwal),
            'ruanglab' => $this->ruanglab->findAll(),
            'matakuliah' => $this->matakuliah->findAll(),
            'validation' => $this->validation,
            'activePage' => 'penggunaan-ruang-laboratorium',
        ];
        return view('simlab/jadwalruang/edit', $data);
    }

    public function update($id_ruang = null, $id_jadwal = null)
    {
        $id_ruang = $this->request->getVar('id_ruang');
        $id_mata_kuliah = $this->request->getVar('id_mata_kuliah');
        $kelas = $this->request->getVar('kelas');
        $hari = $this->request->getVar('hari');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $semester = $this->request->getVar('semester');
        $waktu_mulai = $this->request->getVar('waktu_mulai');
        $waktu_selesai = $this->request->getVar('waktu_selesai');
        $rules = [
            'kelas' => [
                'label' => "Kelas",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'hari' => [
                'label' => "Hari",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];
        $cekKetersediaanRuangByJadwalPraktikum = $this->jadwal->cekKetersediaanRuangByJadwalPraktikum($id_ruang, $hari, $tahun_ajaran,$waktu_mulai, $waktu_selesai);
        if ($cekKetersediaanRuangByJadwalPraktikum > 0) {
            session()->setFlashdata('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
            return redirect()->to('simlab/penggunaan-ruang-laboratorium/tambah/'. $id_ruang)->with('status_icon', 'error');
        } else {
            
        }

        if ($this->validate($rules)) {
            $data = [
                'id_ruang' => $id_ruang,
                'id_mata_kuliah' => $id_mata_kuliah,
                'kelas' => $kelas,
                'hari' => $hari,
                'tahun_ajaran' => $tahun_ajaran,
                'semester' => $semester,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
            ];
            $this->jadwal->updateJadwal($id_ruang, $id_jadwal, $data);
            session()->setFlashdata('success', 'Data Jadwal Mata Kuliah Praktikum Berhasil Diupdate');
            return redirect()->to('simlab/penggunaan-ruang-laboratorium/lihat/'.$id_ruang)->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('simlab/jadwalruang/edit', [
                'title' => 'Edit Data Jadwal Mata Kuliah Praktikum',
                'jadwal' => $this->jadwal->find($id),
                'ruanglab' => $this->ruanglab->findAll(),
                'matakuliah' => $this->matakuliah->findAll(),
                'activePage' => 'penggunaan-ruang-laboratorium',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id_ruang)
    {
        $id_jadwal = $this->request->getVar('id_jadwal');
        $data = $this->jadwal->find($id_ruang);
        $this->jadwal->deleteJadwal($id_ruang, $id_jadwal);
        session()->setFlashdata('success', 'Data Jadwal Mata Kuliah Praktikum Berhasil Dihapus!');
        return redirect()->to('simlab/penggunaan-ruang-laboratorium/lihat/'.$id_ruang)->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

}
