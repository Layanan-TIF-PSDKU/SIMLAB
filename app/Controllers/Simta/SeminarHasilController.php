<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\SeminarHasilModel;
use App\Models\Simta\UjianProposalModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use Myth\Auth\Models\UserModel;
use App\Models\Simta\BobotPenilaianModel;
use App\Models\Simta\PenilaianAkhirModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class SeminarHasilController extends BaseController
{
    public function __construct()
    {
        $this->seminarhasil = new SeminarHasilModel();
        $this->ujianproposal = new UjianProposalModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
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
                'title' => 'Data Seminar Hasil Tugas Akhir',
                'activePage' => 'ujianproposal',
            ];
    
            if (!has_permission('admin') && !has_permission('dosen') && !has_permission('koor-simta')) {
                $data['seminarhsl'] = $this->seminarhasil->getseminarhasilByMahasiswa();
            } elseif (!has_permission('mahasiswa') && !has_permission('admin') && !has_permission('koor-simta')) {
                $data['seminarhsl'] = $this->seminarhasil->getseminarhasilByDosen();
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
                $data['seminarhsl'] = $this->seminarhasil->getseminarhasil();
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
            return view('simta/seminarhasil/index', $data);
    }

    public function tambah($id_ujianproposal)
    {
        $data = [
            'title' => 'Tambah Data Seminar Hasil Tugas Akhir',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            'activePage' => 'seminarhasil',
            'validation' => $this->validation,
        ];
        return view('simta/seminarhasil/tambah', $data);
    }

    public function store($id_ujianproposal)
    {
        $validation = \Config\Services::validation();
        $uuid = Uuid::uuid4();
        $id_seminarhasil = $uuid->toString();
        $id_ujianproposal = $this->request->getVar('id_ujianproposal');
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_judul = $this->request->getVar('nama_judul');
        $abstrak = $this->request->getVar('abstrak');
        $tgl = $this->request->getVar('jadwal_semhas');
        $jadwal_semhas = round(strtotime($tgl)*1000);
        $proposal_seminarhasil = $this->request->getFile('proposal_seminarhasil');
        $proposal_seminarhasilName = $proposal_seminarhasil->getRandomName();
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
                'label' => "Nama Judul",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'abstrak' => [
                'label' => "Abstrak",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jadwal_semhas' => [
                'label' => "Jadwal Semhas",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'proposal_seminarhasil' => [
                'rules' => "uploaded[proposal_seminarhasil]|ext_in[proposal_seminarhasil,pdf]|max_size[proposal_seminarhasil,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        //dd($rules);

        if ($this->validate($rules)) {
            $data = [
                'id_seminarhasil' => $uuid,
                'id_ujianproposal' => $id_ujianproposal,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_judul' => $nama_judul,
                'abstrak' => $abstrak,
                'jadwal_semhas' => $jadwal_semhas,
                'proposal_seminarhasil' => $proposal_seminarhasilName,
                'created_at' => $created_at,
            ];
        //    dd($data);
            $this->seminarhasil->insert($data);
            $proposal_seminarhasil->move('simta_assets/seminarhasil/proposal_seminarhasil/', $proposal_seminarhasilName);
            session()->setFlashdata('success', 'Data Seminar Hasil Berhasil Ditambah');
            return redirect()->to(base_url('simta/seminarhasil'));
        } else {
            return view('simta/seminarhasil/tambah', [
                'title' => 'Tambah Data Seminar Hasil Tugas Akhir',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'seminarhasil',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_seminarhasil)
    {
        $data = [
            'title' => 'Tambah Data Pengaturan Jadwal Ujian Seminar Hasil Tugas Akhir',
            'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'seminarhasil',
            'validation' => $this->validation,
        ];
        return view('simta/seminarhasil/edit', $data);
    }
    public function update($id_seminarhasil)
    {
        $data = [
            $ruang_semhas = $this->request->getVar('ruang_semhas'),
            $tgl = $this->request->getVar('jadwal_semhas'),
            $jadwal_semhas = round(strtotime($tgl)*1000),
            $jamulai = $this->request->getVar('jam_mulai'),
            $jam_mulai = round(strtotime($jamulai)*1000),
            $jamselesai = $this->request->getVar('jam_selesai'),
            $jam_selesai = round(strtotime($jamselesai)*1000),
            $status_ajuan = $this->request->getVar('status_ajuan'),
            $updated_at = round(microtime(true) * 1000),

        ];
        //dd($data);
        $rules = [
            'ruang_semhas' => [
                'label' => "ruang_semhas",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jadwal_semhas' => [
                'label' => "jadwal_semhas",
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
        // dd($rules);
        if ($this->validate($rules)) {
            $data = [
                'ruang_semhas' => $ruang_semhas,
                'jadwal_semhas' => $jadwal_semhas,
                'jam_mulai' => $jam_mulai,
                'jam_selesai' => $jam_selesai,
                'status_ajuan' => $status_ajuan,
                'updated_at' => $updated_at,
            ];
            // return dd($data);
            $this->seminarhasil->update($id_seminarhasil, $data);
            session()->setFlashdata('success', 'Data Pengaturan Jadwal Seminar Hasil Berhasil Ditambah');
            return redirect()->to('simta/seminarhasil');
            //$this->seminarhasil->update($id_seminarhasil, $data2);
            //session()->setFlashdata('success', 'Data Pengaturan Jadwal Seminar Hasil Berhasil Ditambah');
            // return redirect()->to('simta/seminarhasil');
        } else {
            return view('simta/seminarhasil/edit', [
                'title' => 'Tambah Data Pengaturan Jadwal Seminar Hasil Tugas Akhir ',
                'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'seminarhasil',
                'validation' => $this->validation,
            ]);
        }
    }

    public function editstatus($id_seminarhasil)
    {
        $data = [
            'title' => 'Tambah Data Penilaian Seminar Hasil Tugas Akhir',
            'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'seminarhasil',
            'validation' => $this->validation,
        ];
        // dd($data);
        return view('simta/seminarhasil/editstatus', $data);
    }

    public function updatestatus($id_seminarhasil)
    {
        $data = [
            $id_ujianproposal = $this->request->getVar('id_ujianproposal'),
            $nilai_total = $this->request->getVar('nilai_total'),
            $status_sh = $this->request->getVar('status_sh'),
            $catatan = $this->request->getVar('catatan'),
            $updated_at = round(microtime(true) * 1000),
        ];
        // dd($data);
        
        $rules = [
            'nilai_total' => [
                'label' => "Nilai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'status_sh' => [
                'label' => "Status",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'catatan' => [
                'label' => "Catatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];
        // dd($rules);
        if ($this->validate($rules)) {
            // // Mendapatkan Bobot Penilaian
            $bobotpenilaian = $this->bobotpenilaian->getBobot();
            $bobot_seminarhasil = ($bobotpenilaian->bobot_seminarhasil) / 100;

            // // Menghitung Total Penilaian 
            $nilai_total = $nilai_total * $bobot_seminarhasil;
            // dd($nilai_total);
            $data = [
                'nilai_total' => $nilai_total,
                'status_sh' => $status_sh,
                'catatan' => $catatan,
                'updated_at' => $updated_at,
            ];
            $this->seminarhasil->update($id_seminarhasil, $data);

            $penilaianakhir = $this->penilaianakhir->getTotalNilai($id_ujianproposal);
            $id_hasilakhir = $penilaianakhir->id_hasilakhir;
            $nilai_seminarhasil = $this->seminarhasil->find($id_ujianproposal);

            $data2 = [
                'id_hasilakhir' => $id_hasilakhir,
                'nilai_seminarhasil' => $nilai_seminarhasil,
            ];
            // dd($data2);
            $this->penilaianakhir->save($data2);
            session()->setFlashdata('success', 'Data Penilaian Seminar Hasil Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/seminarhasil');
        } else {
            return view('simta/seminarhasil/editstatus', [
                'title' => 'Tambah Data Penilaian Seminar Hasil Tugas Akhir',
                'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'seminarhasil',
                'validation' => $this->validation,
            ]);
        }
    }
    public function delete($id_seminarhasil)
    {
        $file = $this->ujianproposal->find($id_ujianproposal);
        $proposalawal = $file->proposalawal;
        $revisi_proposal = $file->revisi_proposal;
        $transkrip_nilai = $file->transkrip_nilai;
        
        if(file_exists('simta_assets/ujianproposal/proposalawal' . $proposalawal)){
            unlink('simta_assets/ujianproposal/proposalawal' . $proposalawal);
        }
        if($revisi_proposal != null) {
            if(file_exists('simta_assets/ujianproposal/revisi_proposal/' . $revisi_proposal)){
                unlink('simta_assets/ujianproposal/revisi_proposal/' . $revisi_proposal);
            }
        }
        if(file_exists('simta_assets/ujianproposal/transkrip_nilai' . $transkrip_nilai)){
            unlink('simta_assets/ujianproposal/transkrip_nilai' . $transkrip_nilai);
        }
        $this->ujianproposal->delete($id_ujianproposal);
        session()->setFlashdata('success', 'Data Seminar Hasil Berhasil Dihapus');
        return redirect()->to('simta/ujianproposal');
    }

    public function download_proposal_seminarhasil($id_seminarhasil)
    {
        $seminarhasil = $this->seminarhasil->find($id_seminarhasil);       
        return $this->response->download('simta_assets/seminarhasil/proposal_seminarhasil/' . $seminarhasil->proposal_seminarhasil, null);
    }

    public function download_persetujuan_dosen($id_seminarhasil)
    {
        $seminarhasil = $this->seminarhasil->find($id_seminarhasil);       
        return $this->response->download('simta_assets/seminarhasil/persetujuan_dosen/' . $seminarhasil->persetujuan_dosen, null);
    }

    public function download_berita_acara($id_seminarhasil)
    {
        $seminarhasil = $this->seminarhasil->find($id_seminarhasil);       
        return $this->response->download('simta_assets/seminarhasil/berita_acara/' . $seminarhasil->berita_acara, null);
    }

    public function download_revisi_proposal($id_seminarhasil)
    {
        $seminarhasil = $this->seminarhasil->find($id_seminarhasil);       
        return $this->response->download('simta_assets/seminarhasil/revisi_proposal/' . $seminarhasil->revisi_proposal, null);
    }

    public function detail($id_seminarhasil)
    {
        $data = [
            'title' => 'Detail Data Ujian Proposal ',
            'seminarhasil' => $this->seminarhasil->select('simta_seminarhasil.*, mahasiswa.*, staf.*, mahasiswa.nama as nama_mhs, staf.nama as nama_dosen, 
            mahasiswa.no_telp as no_telp_mhs, staf.no_telp as no_telp_dosen')->join('mahasiswa', 'mahasiswa.id_mhs=simta_seminarhasil.id_mhs')->join('staf', 
            'staf.id_staf=simta_seminarhasil.id_staf')->where('simta_seminarhasil.id_seminarhasil', $id_seminarhasil)->find(),
            // 'penilaianakhir' => $this->penilaianakhir->join('simta_ujianproposal', 'simta_ujianproposal.id_ujianproposal=simta_hasilakhir.id_ujianproposal')->where('simta_hasilakhir.id_seminarhasil', $id_seminarhasil)->findAll(),
                // 'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            // 'ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            // 'mahasiswa' => $this->mahasiswa->findAll(),
            // 'ujianproposal' => $this->staf->findAll(),
            // 'id_ujianproposal' => $this->ujianproposal->find($id_ujianproposal),
            // 'pengujiujianproposal' => $this->pengujiujianproposal->getDataByIdUjianProposal($id_ujianproposal),
            'activePage' => 'seminarhasil',
            'validation' => $this->validation,
        ];
        // dd($data);
        // var_dump($data);
        // die;
        return view('simta/seminarhasil/detail', $data);
    }

    public function revisi($id_seminarhasil)
    {
        $data = [
            'title' => 'Tambah Data Revisi Seminar Hasil Tugas Akhir',
            'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'seminarhasil',
            'validation' => $this->validation,
        ];
        return view('simta/seminarhasil/revisi', $data);
    }
    public function updaterevisi($id_seminarhasil)
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
            $this->seminarhasil->update($id_seminarhasil, $data);
            $revisi_proposal->move('simta_assets/seminarhasil/revisi_proposal/', $revisi_proposalName);
            session()->setFlashdata('success', 'Data Revisi Seminar Hasil Tugas Akhir');
            return redirect()->to(base_url('simta/seminarhasil'));
        } else {
            return view('simta/seminarhasil/revisi', [
                'title' => 'Tambah Data Revisi Seminar Hasil Tugas Akhir',
                'seminarhasil' => $this->seminarhasil->find($id_seminarhasil),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'seminarhasil',
                'validation' => $this->validation,
            ]);
        }
    }
}
?>