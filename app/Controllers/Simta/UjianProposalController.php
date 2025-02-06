<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Simta\PengujiUjianProposalModel;
use App\Models\Simta\PengajuanJudulModel;
use App\Models\Simta\UjianProposalModel;
use App\Models\Simta\BobotPenilaianModel;
use App\Models\Simta\TotalNilaiModel;
use App\Models\Simta\PenilaianAkhirModel;
use Ramsey\Uuid\Uuid;
use \DateTime;
use \DateTimeZone;

class UjianProposalController extends BaseController
{
    public function __construct()
    {
        $this->ujianproposal = new UjianProposalModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->pengajuanjudul = new PengajuanJudulModel();
        $this->totalnilai = new TotalNilaiModel();
        $this->pengujiujianproposal = new PengujiUjianProposalModel();
        $this->penilaianakhir = new PenilaianAkhirModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        // $userlog = $_SESSION["logged_in"];
        // $cek_mhs = $this->mahasiswa->where('id_user', $userlog)->first();
        // $cek_dosen = $this->staf->where('id_user', $userlog)->first();

        $data = [
            'title' => 'Ujian Proposal',
            'activePage' => 'ujianproposal',
        ];

        if (!has_permission('admin') && !has_permission('dosen') && !has_permission('koor-simta')) {
            $data['ujianpropsal'] = $this->ujianproposal->getujianproposalByMahasiswa();
        } elseif (!has_permission('mahasiswa') && !has_permission('admin') && !has_permission('koor-simta')) {
            $data['ujianpropsal'] = $this->ujianproposal->getujianproposalByDosen();
            // dd($data);
            // var_dump('testajadu');
            // die;
        } else {
            // $data = [
            //     'title' => 'Ujian Proposal',
            //     'ujianproposal' => $this->ujianproposal->findAll(),
            //     'ujianproposal2' => $this->ujianproposal->getujianproposalByUser(),
            //     'ujianproposal3' => $this->ujianproposal->getujianproposalByUser1(),
            //     'mahasiswa' => $this->mahasiswa->findAll(),
            //     'staf' => $this->staf->findAll(),
            //     'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            //     'activePage' => 'ujianproposal',
            // ];
            $data['ujianpropsal'] = $this->ujianproposal->getujianproposal();
            // dd($data);
        }
        // var_dump($user);
        // die;
        // $data = [
        //     'title' => 'Ujian Proposal',
        //     'ujianproposal' => $this->ujianproposal->findAll(),
        //     'ujianproposal2' => $this->ujianproposal->getujianproposalByUser(),
        //     'ujianproposal3' => $this->ujianproposal->getujianproposalByUser1(),
        //     'mahasiswa' => $this->mahasiswa->findAll(),
        //     'staf' => $this->staf->findAll(),
        //     'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
        //     'activePage' => 'ujianproposal',
        // ];
        // dd($data);
        return view('simta/ujianproposal/index', $data);
    }

    public function tambah($id_pengajuanjudul)
    {
        $data = [
            'title' => 'Tambah Ujian Proposal Tugas Akhir',
            'pengajuanjudul' => $this->pengajuanjudul->find($id_pengajuanjudul),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
        ];

        return view('simta/ujianproposal/tambah', $data);
    }

    public function store($id_pengajuanjudul)
    {
        $validation = \Config\Services::validation();
        $uuid = Uuid::uuid4();
        $id_ujianproposal = $uuid->toString();
        // $id_pengajuanjudul = $this->request->getVar('id_pengajuanjudul');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_judul = $this->request->getVar('nama_judul');
        $abstrak = $this->request->getVar('abstrak');
        $tgl = $this->request->getVar('tanggal');
        $tanggal = round(strtotime($tgl)*1000);
        $proposalawal = $this->request->getFile('proposalawal');
        $proposalawalName = $proposalawal->getRandomName();
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
                'label' => "Nama Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_judul' => [
                'label' => "nama_judul",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'abstrak' => [
                'label' => "abstrak",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'tanggal' => [
                'label' => "tanggal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'proposalawal' => [
                'rules' => "uploaded[proposalawal]|ext_in[proposalawal,pdf]|max_size[proposalawal,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_ujianproposal' => $uuid,
                // 'id_pengajuanjudul' => $id_pengajuanjudul,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_judul' => $nama_judul,
                'abstrak' => $abstrak,
                'tanggal' => $tanggal,
                'proposalawal' => $proposalawalName,
                'created_at' => $created_at,
            ];
            //dd($data);
            $this->ujianproposal->insert($data);
            $proposalawal->move('simta_assets/ujianproposal/proposalawal/', $proposalawalName);
            session()->setFlashdata('success', 'Data Ujian Proposal Tugas Akhir Berhasil Ditambah');
            return redirect()->to(base_url('simta/ujianproposal'));
        } else {
            return view('simta/ujianproposal/tambah', [
                'title' => 'Tambah Data Ujian Proposal Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'pengajuanjudul' => $this->pengajuanjudul->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Pengaturan Jadwal Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
        ];
        return view('simta/ujianproposal/edit', $data);
    }
    public function update($id_ujianproposal)
    {
        $data = [
            $ruang_sempro = $this->request->getVar('ruang_sempro'),
            $tgl = $this->request->getVar('tanggal'),
            $tanggal = round(strtotime($tgl)*1000),
            $jamulai = $this->request->getVar('jam_mulai'),
            $jam_mulai = round(strtotime($jamulai)*1000),
            $jamselesai = $this->request->getVar('jam_selesai'),
            $jam_selesai = round(strtotime($jamselesai)*1000),
            $status_ajuan = $this->request->getVar('status_ajuan'),
            $updated_at = round(microtime(true) * 1000),
        ];
        //dd($data);
        $rules = [
            'ruang_sempro' => [
                'label' => "ruang_sempro",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'tanggal' => [
                'label' => "tanggal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jam_mulai' => [
                'label' => "Jam Mulai Ujian Proposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jam_selesai' => [
                'label' => "Jam Selesai Ujian Proposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
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
        //dd($rules);
        if ($this->validate($rules)) {
            $data = [
                'ruang_sempro' => $ruang_sempro,
                'tanggal' => $tanggal,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'status_ajuan' => $status_ajuan,
                'updated_at' => $updated_at,
            ];
            //return dd($data);
            $this->ujianproposal->update($id_ujianproposal, $data);
            session()->setFlashdata('success', 'Data Pengaturan Jadwal Ujian Proposal Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianproposal')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simta/ujianproposal/edit', [
                'title' => 'Edit Data Pengaturan Jadwal ',
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    public function editstatus($id_penguji_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Ujian Proposal Tugas Akhir',
            'pengujiujianproposal' => $this->pengujiujianproposal->find($id_penguji_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengujiujianproposal',
            'validation' => $this->validation,
        ];
        return view('simta/ujianproposal/editstatus', $data);
    }

    public function updatestatus($id_penguji_ujianproposal)
    {
        // $validation = \Config\Services::validation();
        // $uuid = Uuid::uuid4();
        // $id_hasilakhir = $uuid->toString();
        $id_ujianproposal = $this->request->getVar('id_ujianproposal');
        $nilai_ujianproposal = $this->request->getVar('nilai_ujianproposal');
        $status_up = $this->request->getVar('status_up');
        $catatan = $this->request->getVar('catatan');
        $updated_at = round(microtime(true) * 1000);
        // dd($data);

        $rules = [
            'nilai_ujianproposal' => [
                'label' => "Nilai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];
        // dd($rules);
        if ($this->validate($rules)) {
            $data = array(
                'id_ujianproposal' => $id_ujianproposal,
                'nilai_ujianproposal' => $nilai_ujianproposal,
                'catatan' => $catatan,
                'status_up' => $status_up,
            );
            // dd($data);
            $this->pengujiujianproposal->update($id_penguji_ujianproposal, $data);

            // // Mendapatkan Bobot Penilaian
            $bobotpenilaian = $this->bobotpenilaian->getBobot();
            $bobot_ujianproposal = ($bobotpenilaian->bobot_ujianproposal) / 100;

            // // Menghitung Total Penilaian 
            $nilai = $this->pengujiujianproposal->getTotalNilaiUjianProposal($id_ujianproposal);
            $nilai = $nilai->nilai_ujianproposal; // Mengakses nilai dari objek $nilai
            $nilai_total = $nilai * $bobot_ujianproposal;
            // dd($nilai_total);
            
            // // Memasukkan / Mengupdate Total Penilaian  dalam database
            $data2 = array(
                // 'id_hasilakhir' => $uuid,
                'id_ujianproposal' => $id_ujianproposal,
                'nilai_totalujian' => $nilai_total,
                'status_up' => $status_up,
            );
            // dd($data2);
            $this->ujianproposal->save($data2);

            // $nilai = $this->ujianproposal->find($id_ujianproposal);
            // // // dd($nilai);
            // $nilai_total = $nilai->nilai_totalujian;
            // $data3 = array(
            //         'id_hasilakhir' => $uuid,
            //         'id_ujianproposal' => $id_ujianproposal,
            //         'nilai_ujianproposal' => $nilai_total,
            //     );
            // // dd($data3);
            // $this->penilaianakhir->insert($data3);
            
            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('simta/ujianproposal');
        } else {
            return view('simta/ujianproposal/editstatus', [
                'title' => 'Tambah Data Penilaian Ujian Proposal Tugas Akhir',
                'pengujiujianproposal' => $this->pengujiujianproposal->find($id_penguji_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengujiujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    // public function delete($id_ujianproposal)
    // {
    //     $file = $this->ujianproposal->find($id_ujianproposal);
    //     $proposalawal = $file->proposalawal;
    //     $revisi_proposal = $file->revisi_proposal;
    //     $transkrip_nilai = $file->transkrip_nilai;
        
    //         if(file_exists('simta_assets/ujianproposal/proposalawal' . $proposalawal)){
    //             unlink('simta_assets/ujianproposal/proposalawal' . $proposalawal);
    //         }
    //     if($revisi_proposal != null) {
    //         if(file_exists('simta_assets/ujianproposal/revisi_proposal/' . $revisi_proposal)){
    //             unlink('simta_assets/ujianproposal/revisi_proposal/' . $revisi_proposal);
    //         }
    //     }

    //         if(file_exists('simta_assets/ujianproposal/transkrip_nilai' . $transkrip_nilai)){
    //             unlink('simta_assets/ujianproposal/transkrip_nilai' . $transkrip_nilai);
    //         }

    //     $this->ujianproposal->delete($id_ujianproposal);
    //     session()->setFlashdata('success', 'Data Ujian Proposal Berhasil Dihapus');
    //     return redirect()->to('simta/ujianproposal');

    // }

    public function download_proposalawal($id_ujianproposal)
    {
        $ujianproposal = $this->ujianproposal->find($id_ujianproposal);
        return $this->response->download('simta_assets/ujianproposal/proposalawal/' . $ujianproposal->proposalawal, null);
    }

    public function download_transkripnilai($id_ujianproposal)
    {
        $ujianproposal = $this->ujianproposal->find($id_ujianproposal);
        return $this->response->download('simta_assets/ujianproposal/transkrip_nilai/' . $ujianproposal->transkrip_nilai, null);
    }

    public function download_revisi_proposal($id_ujianproposal)
    {
        $ujianproposal = $this->ujianproposal->find($id_ujianproposal);
        return $this->response->download('simta_assets/ujianproposal/revisi_proposal/' . $ujianproposal->revisi_proposal, null);
    }

    public function detail($id_ujianproposal)
    {
        $data = [
            'title' => 'Detail Data Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->select('simta_ujianproposal.*, mahasiswa.*, staf.*, mahasiswa.nama as nama_mhs, staf.nama as nama_dosen, mahasiswa.no_telp as no_telp_mhs, staf.no_telp as no_telp_dosen')->join('mahasiswa', 'mahasiswa.id_mhs=simta_ujianproposal.id_mhs')->join('staf', 'staf.id_staf=simta_ujianproposal.id_staf')->where('simta_ujianproposal.id_ujianproposal', $id_ujianproposal)->find(),
            'penguji' => $this->pengujiujianproposal->join('staf', 'staf.id_staf=simta_penguji_ujianproposal.id_staf')->where('simta_penguji_ujianproposal.id_ujianproposal', $id_ujianproposal)->findAll(),
            // 'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            // 'mahasiswa' => $this->mahasiswa->findAll(),
            // 'staf' => $this->staf->findAll(),
            // 'id_ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            // 'pengujiujianproposal' => $this->pengujiujianproposal->getDataByIdUjianProposal($id_ujianproposal),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
        ];
        // dd($data);
        // var_dump($data);
        // die;
        return view('simta/ujianproposal/detail', $data);
    }

    public function edithasil($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Hasil Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
        ];
        return view('simta/ujianproposal/edithasil', $data);
    }

    public function updatehasil($id_ujianproposal)
    {
        $status_up = $this->request->getVar('status_up');
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'status_up' => [
                'label' => "Nama Penguji",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'status_up' => $status_up,
                'updated_at' => $updated_at,
            ];
            //dd($data);
            $this->ujianproposal->update($id_ujianproposal, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Hasil Ujian Proposal Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianproposal');

        } else {
            return view('simta/ujianproposal/edithasil', [
                'title' => 'Tambah Data Hasil Ujian Proposal Tugas Akhir',
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    public function tambahpengujiujianproposal($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Dosen Penguji Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'pengujiujianproposal' => $this->pengujiujianproposal->findAll(),
            'activePage' => 'pengujiujianproposal',
            'validation' => $this->validation,
        ];

        return view('simta/ujianproposal/tambahpengujiujianproposal', $data);
    }
    public function storepengujiujianproposal($id_ujianproposal)
    {
        $validation = \Config\Services::validation();
        $uuids = [];
        $id_ujianproposal = $this->request->getVar('id_ujianproposal');
        $id_staf = $this->request->getVar('id_staf');
        $nama_penguji = $this->request->getVar('nama_penguji');
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'id_ujianproposal.*' => [
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
            'nama_penguji.*' => [
                'label' => "Nama penguji Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            foreach ($id_ujianproposal as $key => $value) {
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_penguji_ujianproposal' => $uuid,
                    'id_ujianproposal' => $value,
                    'id_staf' => $id_staf[$key],
                    'nama_penguji' => $nama_penguji[$key],
                    'created_at' => $created_at,
                ];
                $this->pengujiujianproposal->insert($data);
                $uuids[] = $uuid;     
            }
            // dd($data);
            session()->setFlashdata('success', 'Data Dosen Penguji Ujian Proposal Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianproposal');
        } else {
            return view('simta/ujianproposal/tambahpengujiujianproposal', [
                'title' => 'Tambah Data Dosen Penguji Ujian Proposal ',
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'pengujiujianproposal' => $this->pengujiujianproposal->findAll(),
                'activePage' => 'pengujiujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    public function editpengujiujianproposal($id_penguji_ujianproposal)
    {
        $data = [
            'title' => 'Edit Data Dosen Penguji Tugas Akhir',
            'pengujiujianproposal' => $this->pengujiujianproposal->find($id_penguji_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengujiujianproposal',
            'validation' => $this->validation,
        ];
        return view('simta/ujianproposal/editpengujiujianproposal', $data);
    }

    public function updatepengujiujianproposal($id_penguji_ujianproposal)
    {
        $nama_penguji = $this->request->getVar('nama_penguji');
        $id_staf = $this->request->getVar('id_staf');
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'nama_penguji' => [
                'label' => "Nama Penguji",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'id_staf' => [
                'label' => "Nama Dosen",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_staf' => $id_staf,
                'nama_penguji' => $nama_penguji,
                'updated_at' => $updated_at,
            ];
            //dd($data);
            $this->pengujiujianproposal->update($id_penguji_ujianproposal, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Dosen Penguji Ujian Proposal Berhasil diubah');
            return redirect()->to('simta/ujianproposal');

        } else {
            return view('simta/ujianproposal/editpengujiujianproposal', [
                'title' => 'Edit Data Dosen Penguji Ujian Proposal Tugas Akhir',
                'pengujiujianproposal' => $this->pengujiujianproposal->find($id_penguji_ujianproposal),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengujiujianproposal',
                'validation' => $this->validation,
            ]);
        }
    }

    public function deletepengujiujianproposal($id_penguji_ujianproposal)
    {
        $data = $this->pengujiujianproposal->find($id_penguji_ujianproposal);
        $this->pengujiujianproposal->delete($id_penguji_ujianproposal);
        session()->setFlashdata('success', 'Data Dosen Penguji Ujian Proposal Tugas Akhir Berhasil Dihapus');
        return redirect()->to('simta/ujianproposal');
    }

    public function revisi($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Revisi Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
        ];
        return view('simta/ujianproposal/revisi', $data);
    }
    public function updaterevisi($id_ujianproposal)
    {
        $revisi_proposal = $this->request->getFile('revisi_proposal');
        $revisi_proposalName = $revisi_proposal->getRandomName();
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'revisi_proposal' => [
                'rules' => "uploaded[revisi_proposal]|ext_in[revisi_proposal,pdf]|max_size[revisi_proposal,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'revisi_proposal' => $revisi_proposalName,
                'updated_at' => $updated_at,
            ];
            $this->ujianproposal->update($id_ujianproposal, $data);
            $revisi_proposal->move('simta_assets/ujianproposal/revisi_proposal/', $revisi_proposalName);
            session()->setFlashdata('success', 'Data  Revisi Ujian Proposal Tugas Akhir Berhasil Ditambah');
            return redirect()->to(base_url('simta/ujianproposal'));
        } else {
            return view('simta/ujianproposal/revisi', [
                'title' => 'Tambah Data Revisi Ujian Proposal Tugas Akhir',
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianproposal',
            'validation' => $this->validation,
            ]);
        }
    }
}
?>