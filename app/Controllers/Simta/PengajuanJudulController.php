<?php

namespace App\Controllers\Simta;

use App\Models\Simta\PengajuanJudulModel;
use App\Models\Simta\RekomendasiModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;

class PengajuanJudulController extends BaseController
{   
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->pengajuanjudul = new PengajuanJudulModel();
        $this->rekomendasi = new RekomendasiModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        
        helper('form');
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Pengajuan Judul Tugas Akhir',
            'pengajuanjudul' => $this->pengajuanjudul->findAll(),
            'pengajuanjudul2' => $this->pengajuanjudul->getPengajuanJudulByUser(),
            'pengajuanjudul3' => $this->pengajuanjudul->getPengajuanJudulByUser1(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanjudul'
        ];
        return view('simta/pengajuanjudul/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Pengajuan Judul Tugas Akhir',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'pengajuanjudul',
            'validation' => $this->validation,

        ];
        return view('simta/pengajuanjudul/tambah', $data);
    }

    public function store()
    {
        $uuid = Uuid::uuid4();
        $id_pengajuanjudul = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $nama_judul1 = $this->request->getVar('nama_judul1');
        $deskripsi_sistem1 = $this->request->getVar('deskripsi_sistem1');
        $nama_judul2 = $this->request->getVar('nama_judul2');
        $deskripsi_sistem2 = $this->request->getVar('deskripsi_sistem2');
        $nama_judul3 = $this->request->getVar('nama_judul3');
        $deskripsi_sistem3 = $this->request->getVar('deskripsi_sistem3');
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
            'nama_judul1' => [
                'label' => "Nama Judul 1",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'deskripsi_sistem1' => [
                'label' => "Deskripsi Sistem 1 ",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_judul2' => [
                'label' => "Nama Judul 2",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'deskripsi_sistem2' => [
                'label' => "Deskripsi Sistem 2",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_judul3' => [
                'label' => "Nama Judul 3",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'deskripsi_sistem3' => [
                'label' => "Deskripsi Sistem 3",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_pengajuanjudul' => $uuid,
                'id_mhs' => $id_mhs,
                'nama_judul1' => $nama_judul1,
                'deskripsi_sistem1' => $deskripsi_sistem1,
                'nama_judul2' => $nama_judul2,
                'deskripsi_sistem2' => $deskripsi_sistem2,
                'nama_judul3' => $nama_judul3,
                'deskripsi_sistem3' => $deskripsi_sistem3,
                'created_at' => $created_at,
            ];
            //return dd($data);
            $this->pengajuanjudul->insert($data);
            
            session()->setFlashdata('success', 'Data Pengajuan Judul Berhasil Ditambah');
            return redirect()->to('simta/pengajuanjudul');
        } else {
            return view('simta/pengajuanjudul/tambah', [
                'title' => 'Tambah Data Pengajuan Judul',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'activePage' => 'pengajuanjudul',
                'validation' => $this->validation,
            ]);
        }
    }

    // public function edit($id_pengajuanjudul)
    // {
    //     $data = [
    //         'title' => 'Edit Data Pengajuan Judul Tugas Akhir ',
    //         'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
    //         'mahasiswa' => $this->mahasiswa->findAll(),
    //         'staf' => $this->staf->findAll(),
    //         'activePage' => 'pengajuanjudul',
    //         'validation' => $this->validation,
    //     ];
    //     return view('simta/pengajuanjudul/edit', $data);
    // }

    // public function update($id_pengajuanjudul)
    // {
    //     $id_mhs = $this->request->getVar('id_mhs');
    //     $nama_judul1 = $this->request->getVar('nama_judul1');
    //     $deskripsi_sistem1 = $this->request->getVar('deskripsi_sistem1');
    //     $nama_judul2 = $this->request->getVar('nama_judul2');
    //     $deskripsi_sistem2 = $this->request->getVar('deskripsi_sistem2');
    //     $nama_judul3 = $this->request->getVar('nama_judul3');
    //     $deskripsi_sistem3 = $this->request->getVar('deskripsi_sistem3');
    //     $updated_at = round(microtime(true) * 1000);
        
    //     $rules = [
    //         'id_mhs' => [
    //             'label' => "Nama Mahasiswa",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus diisi",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'nama_judul1' => [
    //             'label' => "Nama Judul 1",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'deskripsi_sistem1' => [
    //             'label' => "Deskripsi Sistem 1 ",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'nama_judul2' => [
    //             'label' => "Nama Judul 2",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'deskripsi_sistem2' => [
    //             'label' => "Deskripsi Sistem 2",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'nama_judul3' => [
    //             'label' => "Nama Judul 3",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'deskripsi_sistem3' => [
    //             'label' => "Deskripsi Sistem 3",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
            
    //     ];

    //     if ($this->validate($rules)) {
    //     $data = [
    //         'id_mhs' => $id_mhs,
    //         'nama_judul1' => $nama_judul1,
    //         'deskripsi_sistem1' => $deskripsi_sistem1,
    //         'nama_judul2' => $nama_judul2,
    //         'deskripsi_sistem2' => $deskripsi_sistem2,
    //         'nama_judul3' => $nama_judul3,
    //         'deskripsi_sistem3' => $deskripsi_sistem3,
    //         'updated_at' => $updated_at,
    //     ];
    //     //dd($data);
    //     $this->pengajuanjudul->update($id_pengajuanjudul, $data);
    //     //dd($data);
    //     session()->setFlashdata('success', 'Data Pengajuan Judul berhasil diubah');
    //     return redirect()->to('simta/pengajuanjudul');

    //     } else {
    //         return view('simta/pengajuanjudul/edit', [
    //             'title' => 'Edit Data Pengajuan Judul',
    //             'mahasiswa' => $this->mahasiswa->findAll(),
    //             'staf' => $this->staf->findAll(),
    //             'activePage' => 'pengajuanjudul',
    //             'validation' => $this->validation,
    //         ]);
    //     }
    // }
    
    public function editstatus($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Tambah Data Hasil Pengajuan Judul Tugas Akhir ',
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanjudul',
            'validation' => $this->validation,
        ];
        return view('simta/pengajuanjudul/editstatus', $data);
    }

    public function updatestatus($id_pengajuanjudul)
    {
        $catatan = $this->request->getVar('catatan');
        $status_pj = $this->request->getVar('status_pj');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'catatan' => [
                'label' => "Catatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'status_pj' => [
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
            'catatan' => $catatan,
            'status_pj' => $status_pj,
            'updated_at' => $updated_at,
        ];
        //dd($data);
        $this->pengajuanjudul->update($id_pengajuanjudul, $data);
        //dd($data);
        session()->setFlashdata('success', 'Data Hasil Pengajuan Judul Tugas Akhir Berhasil Ditambah');
        return redirect()->to('simta/pengajuanjudul');
        } else {
            return view('simta/pengajuanjudul/editstatus', [
                'title' => 'Tambah Data Hasil Pengajuan Judul Tugas Akhir',
                'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengajuanjudul',
                'validation' => $this->validation,
            ]);
        }
    }

    public function delete($id_pengajuanjudul)
    {
        $data = $this->pengajuanjudul->find($id_pengajuanjudul);
        $this->pengajuanjudul->delete($id_pengajuanjudul);
        session()->setFlashdata('success', 'Data Pengajuan Judul Berhasil Dihapus');
        return redirect()->to('simta/pengajuanjudul');
    }

    public function detail($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Detail Data Pengajuan Judul Tugas Akhir ',
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'rekomendasi' => $this->rekomendasi->getDataByIdPengajuanJudul($id_pengajuanjudul),
            'activePage' => 'pengajuanjudul',
            'validation' => $this->validation,
        ];
        return view('simta/pengajuanjudul/detail', $data);
    }

    public function editpembimbing($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Tambah Data Dosen Pembimbing Tugas Akhir ',
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengajuanjudul',
            'validation' => $this->validation,
        ];
        return view('simta/pengajuanjudul/editpembimbing', $data);
    }

    public function updatepembimbing($id_pengajuanjudul)
    {
        $id_staf = $this->request->getVar('id_staf');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'id_staf' => [
                'label' => "Nama Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],    
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_staf' => $id_staf,
                'updated_at' => $updated_at,
            ];
            //dd($data);
            $this->pengajuanjudul->update($id_pengajuanjudul, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Dosen Pembimbing Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/pengajuanjudul');
        } else {
            return view('simta/pengajuanjudul/editstatus', [
                'title' => 'Tambah Data Dosen Pembimbing Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengajuanjudul',
                'validation' => $this->validation,
            ]);
        }
    }

    public function tambahrekomendasi($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Tambah Data Rekomendasi Dosen Pembimbing Tugas Akhir',
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'rekomendasi' => $this->rekomendasi->findAll(),
            'activePage' => 'rekomendasi',
            'validation' => $this->validation,
        ];

        return view('simta/pengajuanjudul/tambahrekomendasi', $data);
    }

    public function storerekomendasi($id_pengajuanjudul)
    {
        $validation = \Config\Services::validation();
        $uuids = [];
        $id_pengajuanjudul = $this->request->getVar('id_pengajuanjudul');
        $id_staf = $this->request->getVar('id_staf');
        $nama_rekomendasi = $this->request->getVar('nama_rekomendasi');
        $created_at = round(microtime(true) * 1000);
    
        $rules = [
            'id_pengajuanjudul.*' => [
                'label' => "Nama Ujian Proposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ],
            ],
            'id_staf.*' => [
                'label' => "Nama Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ],
            ],
            'nama_rekomendasi.*' => [
                'label' => "Nama Rekomendasi Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ],
            ],
        ];
    
        if ($this->validate($rules)) {
            foreach ($id_pengajuanjudul as $key => $value) {
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_rekomendasi' => $uuid,
                    'id_pengajuanjudul' => $value,
                    'id_staf' => $id_staf[$key],
                    'nama_rekomendasi' => $nama_rekomendasi[$key],
                    'created_at' => $created_at,
                ];
                $this->rekomendasi->insert($data);
                $uuids[] = $uuid;     
                //return dd($data);
            }
            
            session()->setFlashdata('success', 'Data Rekomendasi Dosen Pembimbing Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/pengajuanjudul');
        } else {
            return view('simta/pengajuanjudul/tambahrekomendasi', [
                'title' => 'Tambah Data Rekomendasi',
                'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'rekomendasi' => $this->rekomendasi->findAll(),
                'activePage' => 'rekomendasi',
                'validation' => $this->validation,
            ]);
        }
    }

    // public function editrekomendasi($id_rekomendasi)
    // {
    //     $data = [
    //         'title' => 'Edit Data Rekomendasi Tugas Akhir ',
    //         'rekomendasi' => $this->rekomendasi->find($id_rekomendasi),
    //         'mahasiswa' => $this->mahasiswa->findAll(),
    //         'staf' => $this->staf->findAll(),
    //         'activePage' => 'rekomendasi',
    //         'validation' => $this->validation,
    //     ];
    //     return view('simta/pengajuanjudul/editrekomendasi', $data);
    // }

    // public function updaterekomendasi($id_rekomendasi)
    // {
    //     $nama_rekomendasi = $this->request->getVar('nama_rekomendasi');
    //     $id_staf = $this->request->getVar('id_staf');
    //     $updated_at = round(microtime(true) * 1000);
        
    //     $rules = [
    //         'nama_rekomendasi' => [
    //             'label' => "Nama Rekomendasi",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //         'id_staf' => [
    //             'label' => "Nama Dosen",
    //             'rules' => "required",
    //             'errors' => [
    //                 'required' => "{field} harus dipilih",
    //                 'is_unique' => "{field} yang dimasukan Sudah ada",
    //             ],
    //         ],
    //     ];

    //     if ($this->validate($rules)) {
    //     $data = [
    //         'id_staf' => $id_staf,
    //         'nama_rekomendasi' => $nama_rekomendasi,
    //         'updated_at' => $updated_at,
    //     ];
    //     //dd($data);
    //     $this->rekomendasi->update($id_rekomendasi, $data);
    //     //dd($data);
    //     session()->setFlashdata('success', 'Data Pengajuan Judul berhasil diupdate');
    //     return redirect()->to('simta/pengajuanjudul')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');

    //     } else {
    //         return view('simta/pengajuanjudul/editrekomendasi', [
    //             'title' => 'Edit Data Pengajuan Judul',
    //             'mahasiswa' => $this->mahasiswa->findAll(),
    //             'staf' => $this->staf->findAll(),
    //             'activePage' => 'rekomendasi',
    //             'validation' => $this->validation,
    //         ]);
    //     }
    // }

    // public function deleterekomendasi($id_rekomendasi)
    // {
    //     $data = $this->rekomendasi->find($id_rekomendasi);
    //     $this->rekomendasi->delete($id_rekomendasi);
    //     session()->setFlashdata('success', 'Data berhasil dihapus');
    //     return redirect()->to('simta/pengajuanjudul');
    // }
}