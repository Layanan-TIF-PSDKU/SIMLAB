<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\UjianProposalModel;
use App\Models\Simta\UjianTAModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Simta\PengujiUjianTAModel;
use App\Models\Simta\BobotPenilaianModel;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class UjianTAController extends BaseController
{
    public function __construct()
    {
        $this->ujianproposal = new UjianProposalModel();
        $this->ujianta = new UjianTAModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->pengujiujianta = new PengujiUjianTAModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
       // $userlog = $_SESSION["logged_in"];
        // $cek_mhs = $this->mahasiswa->where('id_user', $userlog)->first();
        // $cek_dosen = $this->staf->where('id_user', $userlog)->first();

        $data = [
            'title' => 'Ujian Tugas Akhir',
            'activePage' => 'ujianta',
        ];

        if (!has_permission('admin') && !has_permission('dosen') && !has_permission('koor-simta')) {
            $data['ujianta'] = $this->ujianta->getujiantaByMahasiswa();
        } elseif (!has_permission('mahasiswa') && !has_permission('admin') && !has_permission('koor-simta')) {
            $data['ujianta'] = $this->ujianta->getujiantaByDosen();
            // dd($data);
            // var_dump('testajadu');
            // die;
        } else {
            // $data = [
            //     'title' => 'Ujian ta',
            //     'ujianta' => $this->ujianta->findAll(),
            //     'ujianta2' => $this->ujianta->getujiantaByUser(),
            //     'ujianta3' => $this->ujianta->getujiantaByUser1(),
            //     'mahasiswa' => $this->mahasiswa->findAll(),
            //     'staf' => $this->staf->findAll(),
            //     'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            //     'activePage' => 'ujianta',
            // ];
            $data['ujianta'] = $this->ujianta->getujianta();
            // dd($data);
        }
        // var_dump($user);
        // die;
        // $data = [
        //     'title' => 'Ujian ta',
        //     'ujianta' => $this->ujianta->findAll(),
        //     'ujianta2' => $this->ujianta->getujiantaByUser(),
        //     'ujianta3' => $this->ujianta->getujiantaByUser1(),
        //     'mahasiswa' => $this->mahasiswa->findAll(),
        //     'staf' => $this->staf->findAll(),
        //     'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
        //     'activePage' => 'ujianta',
        // ];
        // dd($data);
        return view('simta/ujianta/index', $data);
    }

    public function tambah($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Ujian Tugas Akhir',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/tambah', $data);
    }

    public function store($id_ujianproposal)
    {
        $validation = \Config\Services::validation();
        $uuid = Uuid::uuid4();
        $id_ujianta = $uuid->toString();
        $id_ujianproposal = $this->request->getVar('id_ujianproposal');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_judul = $this->request->getVar('nama_judul');
        $abstrak = $this->request->getVar('abstrak');
        $tgl = $this->request->getVar('tanggal');
        $tanggal = round(strtotime($tgl)*1000);
        $proposalakhir = $this->request->getFile('proposalakhir');
        $proposalakhirName = $proposalakhir->getRandomName();
        $berita_acarakmm = $this->request->getFile('berita_acarakmm');
        $berita_acarakmmName = $berita_acarakmm->getRandomName();
        $krs = $this->request->getFile('krs');
        $krsName = $krs->getRandomName();
        $transkrip_nilai = $this->request->getFile('transkrip_nilai');
        $transkrip_nilaiName = $transkrip_nilai->getRandomName();
        $rekomendasi_dospem = $this->request->getFile('rekomendasi_dospem');
        $rekomendasi_dospemName = $rekomendasi_dospem->getRandomName();
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
            'proposalakhir' => [
                'rules' => "uploaded[proposalakhir]|ext_in[proposalakhir,pdf]|max_size[proposalakhir,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'berita_acarakmm' => [
                'rules' => "uploaded[berita_acarakmm]|ext_in[berita_acarakmm,pdf]|max_size[berita_acarakmm,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'krs' => [
                'rules' => "uploaded[krs]|ext_in[krs,pdf]|max_size[krs,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'transkrip_nilai' => [
                'rules' => "uploaded[transkrip_nilai]|ext_in[transkrip_nilai,pdf]|max_size[transkrip_nilai,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'rekomendasi_dospem' => [
                'rules' => "uploaded[rekomendasi_dospem]|ext_in[rekomendasi_dospem,pdf]|max_size[rekomendasi_dospem,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_ujianta' => $uuid,
                'id_ujianproposal' => $id_ujianproposal,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_judul' => $nama_judul,
                'abstrak' => $abstrak,
                'tanggal' => $tanggal,
                'proposalakhir' => $proposalakhirName,
                'berita_acarakmm' => $berita_acarakmmName,
                'krs' => $krsName,
                'transkrip_nilai' => $transkrip_nilaiName,
                'rekomendasi_dospem' => $rekomendasi_dospemName,
                'created_at' => $created_at,
            ];
            // dd($data);
            $this->ujianta->insert($data);
            $proposalakhir->move('simta_assets/ujianta/proposalakhir/', $proposalakhirName);
            $berita_acarakmm->move('simta_assets/ujianta/berita_acarakmm/', $berita_acarakmmName);
            $krs->move('simta_assets/ujianta/krs/', $krsName);
            $transkrip_nilai->move('simta_assets/ujianta/transkrip_nilai/', $transkrip_nilaiName);
            $rekomendasi_dospem->move('simta_assets/ujianta/rekomendasi_dospem/', $rekomendasi_dospemName);
            session()->setFlashdata('success', 'Data Ujian Tugas Akhir Berhasil Ditambah');
            return redirect()->to(base_url('simta/ujianta'));
        } else {
            return view('simta/ujianta/tambah', [
                'title' => 'Tambah Ujian Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianta',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_ujianta)
    {
        $data = [
            'title' => 'Tambah Data Pengaturan Jadwal Ujian Tugas Akhir ',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/edit', $data);
    }
    public function update($id_ujianta)
    {
        $data = [
            $ruangan = $this->request->getVar('ruangan'),
            $tgl = $this->request->getVar('tanggal'),
            $tanggal = round(strtotime($tgl)*1000),
            $jamulai = $this->request->getVar('jam_mulai'),
            $jam_mulai = round(strtotime($jamulai)*1000),
            $jamselesai = $this->request->getVar('jam_selesai'),
            $jam_selesai = round(strtotime($jamselesai)*1000),
            $status_ajuan = $this->request->getVar('status_ajuan'),
            $updated_at = round(microtime(true) * 1000),
        ];
        // dd($data);
        $rules = [
            'ruangan' => [
                'label' => "ruangan",
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
                'label' => "jam_mulai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jam_selesai' => [
                'label' => "jam_selesai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'status_ajuan' => [
                'label' => "status_ajuan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];
        
        if ($this->validate($rules)) {
            $data = [
                'ruangan' => $ruangan,
                'tanggal' => $tanggal,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'status_ajuan' => $status_ajuan,
                'updated_at' => $updated_at,
            ];
            $this->ujianta->update($id_ujianta, $data);
            session()->setFlashdata('success', 'Data Pengaturan Jadwal Ujian Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianta');
        } else {
            return view('simta/ujianta/edit', [
                'title' => 'Pengaturan Jadwal Ujian Tugas Akhir',
                'ujianta' => $this->ujianta->find($id_ujianta),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianta',
                'validation' => $this->validation,
            ]);
        }
    }

    public function editstatus($id_penguji_ujianta)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Ujian ta Tugas Akhir',
            'pengujiujianta' => $this->pengujiujianta->find($id_penguji_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengujiujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/editstatus', $data);
    }

    public function updatestatus($id_penguji_ujianta)
    {
        $id_ujianta = $this->request->getVar('id_ujianta');
        $nilai_ujianta = $this->request->getVar('nilai_ujianta');
        $status_ut = $this->request->getVar('status_ut');
        $catatan = $this->request->getVar('catatan');
        $updated_at = round(microtime(true) * 1000);
        // dd($data);

        $rules = [
            'nilai_ujianta' => [
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
                // 'id_ujianta' => $id_ujianta,
                'nilai_ujianta' => $nilai_ujianta,
                'catatan' => $catatan,
                'status_ut' => $status_ut,
            );
            // dd($data);
            $this->pengujiujianta->update($id_penguji_ujianta, $data);

            // // Mendapatkan Bobot Penilaian
            $bobotpenilaian = $this->bobotpenilaian->getBobot();
            $bobot_ujianta = ($bobotpenilaian->bobot_ujianta) / 100;

            // // Menghitung Total Penilaian 
            $nilai = $this->pengujiujianta->getTotalNilaiUjianTA($id_ujianta);
            $nilai = $nilai->nilai_ujianta; // Mengakses nilai dari objek $nilai
            $nilai_total = $nilai * $bobot_ujianta;
            // dd($nilai);

            // // Memasukkan / Mengupdate Total Penilaian Mitra dalam database
            $data2 = array(
                'id_ujianta' => $id_ujianta,
                'nilai_totalujian' => $nilai_total,
                'status_ut' => $status_ut,
            );
            // dd($data2);
            $this->ujianta->save($data2);

            session()->setFlashdata('success', 'Penilaian berhasil');
            return redirect()->to('simta/ujianta');
        } else {
            return view('simta/ujianta/editstatus', [
                'title' => 'Tambah Data Penilaian Ujian ta Tugas Akhir',
                'pengujiujianta' => $this->pengujiujianta->find($id_penguji_ujianta),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengujiujianta',
                'validation' => $this->validation,
            ]);
        }
    }

    // public function delete($id_ujianta)
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
    //     session()->setFlashdata('success', 'Data berhasil dihapus');
    //     return redirect()->to('simta/ujianproposal');

    // }

    public function download_proposalakhir($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/proposalakhir/' . $ujianta->proposalakhir, null);
        //dd($ujianta);
    }

    public function download_berita_acarakmm($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/berita_acarakmm/' . $ujianta->berita_acarakmm, null);
        //dd($ujianta);
    }

    public function download_krs($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/krs/' . $ujianta->krs, null);
        //dd($ujianta);
    }

    public function download_transkrip_nilai($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/transkrip_nilai/' . $ujianta->transkrip_nilai, null);
        //dd($ujianta);
    }

    public function download_rekomendasi_dospem($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/rekomendasi_dospem/' . $ujianta->rekomendasi_dospem, null);
        //dd($ujianta);
    }

    public function download_revisi_proposal($id_ujianta)
    {
        $ujianta = $this->ujianta->find($id_ujianta);       
        return $this->response->download('simta_assets/ujianta/revisi_proposal/' . $ujianta->revisi_proposal, null);
        //dd($ujianta);
    }

    public function detail($id_ujianta)
    {
        $data = [
            'title' => 'Detail Data Ujian Tugas Akhir ',
            'ujianta' => $this->ujianta->select('simta_ujianta.*, mahasiswa.*, staf.*, mahasiswa.nama as nama_mhs, staf.nama as nama_dosen, mahasiswa.no_telp as no_telp_mhs, staf.no_telp as no_telp_dosen')->join('mahasiswa', 'mahasiswa.id_mhs=simta_ujianta.id_mhs')->join('staf', 'staf.id_staf=simta_ujianta.id_staf')->where('simta_ujianta.id_ujianta', $id_ujianta)->find(),
            'penguji' => $this->pengujiujianta->join('staf', 'staf.id_staf=simta_penguji_ujianta.id_staf')->where('simta_penguji_ujianta.id_ujianta', $id_ujianta)->findAll(),
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
        return view('simta/ujianta/detail', $data);
    }

    public function penilaian()
    {
        $faker = \Faker\Factory::create('id_ujinta');
        for ($i = 0; $i < 100; $i++) {
            $ujianta[] = [
                'nama_judul' => $faker->nama_judul(),
                'abstak' => $faker->abstak(),
                'ruangan' => $faker->ruangan(),
                'tanggal' => $faker->tanggal(),
            ];
        }
        $data['ujianta'] = $ujianta;
        return view('penilaian', $data);
    }
    public function editpenguji($id_ujianta)
    {
        $data = [
            'title' => 'Edit Data Dosen Penguji Ujian Tugas Akhir',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/editpenguji', $data);
    }

    public function tambahpengujiujianta($id_ujianta)
    {
        $data = [
            'title' => 'Tambah Data Dosen Penguji Ujian Tugas Akhir',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'pengujiujianta' => $this->pengujiujianta->findAll(),
            'activePage' => 'pengujiujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/tambahpengujiujianta', $data);
    }
    public function storepengujiujianta($id_ujianta)
    {
        $validation = \Config\Services::validation();
        $uuids = [];
        $id_ujianta = $this->request->getVar('id_ujianta');
        $id_staf = $this->request->getVar('id_staf');
        $nama_penguji = $this->request->getVar('nama_penguji');
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'id_ujianta.*' => [
                'label' => "Nama Ujian ta",
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
            foreach ($id_ujianta as $key => $value) {
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_penguji_ujianta' => $uuid,
                    'id_ujianta' => $value,
                    'id_staf' => $id_staf[$key],
                    'nama_penguji' => $nama_penguji[$key],
                    'created_at' => $created_at,
                ];
                $this->pengujiujianta->insert($data);
                $uuids[] = $uuid;     
            }
            // dd($data);
            session()->setFlashdata('success', 'Data Dosen Penguji Ujian ta Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianta');
        } else {
            return view('simta/ujianta/tambahpengujiujianta', [
                'title' => 'Tambah Data Dosen Penguji Ujian ta ',
                'ujianta' => $this->ujianta->find($id_ujianta),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'pengujiujianta' => $this->pengujiujianta->findAll(),
                'activePage' => 'pengujiujianta',
                'validation' => $this->validation,
            ]);
        }
    }

    public function editpengujiujianta($id_penguji_ujianta)
    {
        $data = [
            'title' => 'Edit Data Dosen Penguji Ujian Tugas Akhir ',
            'pengujiujianta' => $this->pengujiujianta->find($id_penguji_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'pengujiujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/editpengujiujianta', $data);
    }

    public function updatepengujiujianta($id_penguji_ujianta)
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
            $this->pengujiujianta->update($id_penguji_ujianta, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Dosen Penguji Ujian Tugas Akhir Berhasil Diubah');
            return redirect()->to('simta/ujianta');
        } else {
            return view('simta/ujianta/editpengujiujianta', [
                'title' => 'Edit Data Dosen Penguji Ujian Tugas Akhir',
                'pengujiujianta' => $this->pengujiujianta->find($id_penguji_ujianta),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'pengujiujianta',
                'validation' => $this->validation,
            ]);
        }
    }

    public function deletepengujiujianta($id_penguji_ujianta)
    {
        $data = $this->pengujiujianta->find($id_penguji_ujianta);
        $this->pengujiujianta->delete($id_penguji_ujianta);
        session()->setFlashdata('success', 'Data Penguji Ujian Tugas Akhir Berhasil Dihapus');
        return redirect()->to('simta/ujianta');
    }

    public function revisi($id_ujianta)
    {
        $data = [
            'title' => 'Tambah Data Revisi Ujian Tugas Akhir ',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/revisi', $data);
    }
    public function updaterevisi($id_ujianta)
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
            $this->ujianta->update($id_ujianta, $data);
            $revisi_proposal->move('simta_assets/revisi_proposal/', $revisi_proposalName);
            session()->setFlashdata('success', 'Data  Revisi Ujian Tugas Akhir Berhasil Ditambah');
            return redirect()->to(base_url('simta/ujianta'));
        } else {
            return view('simta/ujianta/revisi', [
                'title' => 'Tambah Data Revisi Ujian Proposal ',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
            ]);
        }
    }

    public function edithasil($id_ujianta)
    {
        $data = [
            'title' => 'Tambah Data Hasil Ujian Tugas Akhir',
            'ujianta' => $this->ujianta->find($id_ujianta),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'ujianta',
            'validation' => $this->validation,
        ];
        return view('simta/ujianta/edithasil', $data);
    }

    public function updatehasil($id_ujianta)
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
            $this->ujianta->update($id_ujianta, $data);
            //dd($data);
            session()->setFlashdata('success', 'Data Hasil Ujian Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/ujianta')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');

        } else {
            return view('simta/ujianta/edithasil', [
                'title' => 'Tambah Data Hasil Ujian Tugas Akhir',
                'ujianta' => $this->ujianta->find($id_ujianta),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'ujianta',
                'validation' => $this->validation,
            ]);
        }
    }
}
?>