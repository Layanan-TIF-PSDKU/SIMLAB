<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\PengajuanBimbinganModel;
use App\Models\Simta\PengajuanJudulModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PengajuanBimbinganController extends BaseController
{
    public function __construct()
    {
        $this->pengajuanbimbingan = new PengajuanBimbinganModel();
        $this->pengajuanjudul = new PengajuanJudulModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pengajuan Bimbingan Tugas Akhir',
            'pengajuanbimbingan' => $this->pengajuanbimbingan->findAll(),
            'pengajuanbimbingan2' => $this->pengajuanbimbingan->getPengajuanBimbinganByUser(),
            'pengajuanbimbingan3' => $this->pengajuanbimbingan->getPengajuanBimbinganByUser1(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanbimbingan',
        ];
        return view('simta/pengajuanbimbingan/index', $data);
    }

    public function tambah($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Tambah Data Pengajuan Bimbingan Tugas Akhir',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'activePage' => 'pengajuanjudul',
            'staf' => $this->staf->findAll(),
            'validation' => $this->validation,

        ];

        return view('simta/pengajuanbimbingan/tambah', $data);
    }

    public function store($id_pengajuanjudul)
    {
        $uuid = Uuid::uuid4();
        $id_bimbingan = $uuid->toString();
        // $id_pengajuanjudul = $this->request->getVar('id_pengajuanjudul');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $tgl = $this->request->getVar('jadwal_bimbingan');
        $jadwal_bimbingan = round(strtotime($tgl)*1000);
        $created_at = round(microtime(true) * 1000);

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
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'jadwal_bimbingan' => [
                'label' => "Jadwal Bimbingan ",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_bimbingan' => $uuid,
                // 'id_pengajuanjudul' => $id_pengajuanjudul,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'jadwal_bimbingan' => $jadwal_bimbingan,
                'created_at' => $created_at,
            ];
            //dd($data);
            $this->pengajuanbimbingan->insert($data);
            
            session()->setFlashdata('success', 'Data Pengajuan Bimbingan Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/pengajuanbimbingan');
        } else {
            return view('simta/pengajuanbimbingan/tambah', [
                'title' => 'Tambah Data Pengajuan Bimbingan Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
                'activePage' => 'pengajuanbimbingan',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_bimbingan)
    {
        $data = [
            'title' => 'Tambah Data Hasil Pengajuan Bimbingan Tugas Akhir ',
            'pengajuanbimbingan' => $this->pengajuanbimbingan->find($id_bimbingan),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanbimbingan',
            'validation' => $this->validation,
        ];
        return view('simta/pengajuanbimbingan/edit', $data);
    }

    public function update($id_bimbingan)
    {
        $hasil_bimbingan = $this->request->getVar('hasil_bimbingan');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'hasil_bimbingan' => [
                'label' => "Hasil Bimbingan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'hasil_bimbingan' => $hasil_bimbingan,
                'updated_at' => $updated_at,
            ];
            //dd($data);
            $this->pengajuanbimbingan->update($id_bimbingan, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Hasil Pengajuan Bimbingan Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/pengajuanbimbingan');

        } else {
            return view('simta/pengajuanbimbingan/edit', [
                'title' => 'Tambah Data Hasil Pengajuan bimbingan Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengajuanbimbingan',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function verifikasi($id_bimbingan)
    {
        $data = [
            'title' => 'Tambah Data Verifikasi Pengajuan Bimbingan Tugas Akhir',
            'pengajuanbimbingan' => $this->pengajuanbimbingan->find($id_bimbingan),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanbimbingan',
            'validation' => $this->validation,
        ];
        return view('simta/pengajuanbimbingan/verifikasi', $data);
    }

    public function updateverifikasi($id_bimbingan)
    {
        $tgl = $this->request->getVar('jadwal_bimbingan');
        $jadwal_bimbingan = round(strtotime($tgl)*1000);
        $ruang_bimbingan = $this->request->getVar('ruang_bimbingan');
        $jamulai = $this->request->getVar('jam_mulai');
        $jam_mulai = round(strtotime($jamulai)*1000);
        $status_ajuan = $this->request->getVar('status_ajuan');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'jadwal_bimbingan' => [
                'label' => "Jadwal Bimbingan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'ruang_bimbingan' => [
                'label' => "Ruang Bimbingan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'jam_mulai' => [
                'label' => "Jam Mulai Bimbingan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'status_ajuan' => [
                'label' => "Status",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'jadwal_bimbingan' => $jadwal_bimbingan,
                'ruang_bimbingan' => $ruang_bimbingan,
                'jam_mulai' => $jam_mulai,
                'status_ajuan' => $status_ajuan,
                'updated_at' => $updated_at,
            ];
            // dd($data);
            $this->pengajuanbimbingan->update($id_bimbingan, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Verifikasi Pengajuan Bimbingan Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/pengajuanbimbingan');

        } else {
            return view('simta/pengajuanbimbingan/verifikasi', [
                'title' => 'Tambah Data Verifikasi Pengajuan Bimbingan Tugas Akhir',
                'pengajuanbimbingan' => $this->pengajuanbimbingan->find($id_bimbingan),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengajuanbimbingan',
                'validation' => $this->validation,
        ]);
    }
    }
    public function detail($id_bimbingan)
    {
        $data = [
            'title' => 'Detail Data Pengajuan Bimbingan Tugas Akhir ',
            'pengajuanbimbingan' => $this->pengajuanbimbingan->find($id_bimbingan),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanbimbingan',
            'validation' => $this->validation,
        ];

        return view('simta/pengajuanbimbingan/detail', $data);
    }
}
?>