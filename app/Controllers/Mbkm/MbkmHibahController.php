<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Mbkm\HibahModel;
use App\Models\Mbkm\MbkmFixModel;
use Myth\Auth\Models\GroupModel;
use Ramsey\Uuid\Uuid;

class MbkmHibahController extends BaseController
{

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->hibah = new HibahModel();
        $this->mbkmFix = new MbkmFixModel();
        // $this->group = new GroupModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'MBKM Hibah',
            'hibah' => $this->hibah->findAll(),
            'hibah2' => $this->hibah->getMbkmHibahByMhs(),
            'hibah3' => $this->hibah->getHibahByDosen(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),            
            'staf' => $this->staf->findAll(),
            'activePage' => 'hibah',
        ];

        return view('mbkm/mbkm_hibah/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Pendaftaran MBKM Hibah',
            'hibah' => $this->hibah->findAll(),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'validation' => $this->validation,
            'activePage' => 'hibah',
        ];

        return view('mbkm/mbkm_hibah/tambah', $data);

    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_hibah = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $judul = $this->request->getVar('judul');
        $nama_instansi = $this->request->getVar('nama_instansi');

        $proposal = $this->request->getFile('proposal');
        $proposalName = $proposal->getRandomName();

        // $status = $this->request->getVar('status');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);

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
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_instansi' => [
                'label' => "Nama Instansi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
           
            'judul' => [
                'label' => "Judul",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'proposal' => [
                'rules' => "uploaded[proposal]|ext_in[proposal,pdf]|max_size[proposal,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],

        ];

        if ($this->validate($rules)) {
            $data = [
                'id_hibah' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_instansi' => $nama_instansi,
                'judul' => $judul,
                'proposal' => $proposalName,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            // dd($data);
            $this->hibah->insert($data);
            
            // $lap_akhir->move('mbkm_assets/hibah-LapAkhir/', $lap_akhirName);
            $proposal->move('mbkm_assets/hibah-proposal/', $proposalName);
            // $bukti->move('mbkm_assets/hibah-bukti/', $buktiName);
            session()->setFlashdata('success', 'Pendaftaran Berhasil!');
            return redirect()->to('mbkm/hibah')->with('status_icon', 'success')->with('status_text', 'Pendaftaran Berhasil!');
        } else {
            return view('mbkm/mbkm_hibah/tambah', [
                'title' => 'Pendaftaran MBKM Hibah',
                'hibah' => $this->hibah->findAll(),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_hibah)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM Prodi ',
            'hibah' => $this->hibah->find($id_hibah),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'hibah',
            'validation' => $this->validation,
        ];
        return view('mbkm/mbkm_hibah/edit', $data);
    }
    public function update($id_hibah)
    {
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $judul = $this->request->getVar('judul');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $proposal = $this->request->getFile('proposal');
        $proposalName = $proposal->getRandomName();
        $surat_rekom = $this->request->getFile('surat_rekom');
        $surat_rekomName = $surat_rekom->getRandomName();
        $updated_at = round(microtime(true) * 1000);

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
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_instansi' => [
                'label' => "Nama Instansi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'judul' => [
                'label' => "judul",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'proposal' => [
                'rules' => "ext_in[proposal,pdf]|max_size[proposal,2048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'surat_rekom' => [
                'rules' => "ext_in[surat_rekom,pdf]|max_size[surat_rekom,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        
        if ($this->validate($rules)) {
            
            $prop = $this->hibah->find($id_hibah);
            $old_prop = $prop->proposal;
            
            if ($proposal->isValid() && !$proposal->hasMoved()) 
            {
                if (file_exists('mbkm_assets/hibah-proposal/' . $old_prop)) {
                    unlink('mbkm_assets/hibah-proposal/' . $old_prop);
                }
                $proposalName = $proposal->getRandomName();
                $proposal->move('mbkm_assets/hibah-proposal/', $proposalName);
            } else {
                $proposalName = $prop->proposal;
            }
            
            $surat = $this->hibah->find($id_hibah);
            $old_sr = $surat->surat_rekom;
            
            if($surat_rekom->isValid() && !$surat_rekom->hasMoved())
            {
                if(file_exists('mbkm_assets/hibah-sr/' . $old_sr)){
                    unlink('mbkm_assets/hibah-sr/' . $old_sr);
                }
                   $surat_rekomName = $surat_rekom->getRandomName();
                   $surat_rekom->move('mbkm_assets/hibah-sr/', $surat_rekomName);
            } else {
                    $surat_rekomName = $surat->surat_rekom;
            }
            $data = [
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_instansi' => $nama_instansi,
                'judul' => $judul,
                'proposal' => $proposalName,
                'surat_rekom' => $surat_rekomName,
                'updated_at' => $updated_at,
            ];
            
            $this->hibah->update($id_hibah, $data);
            session()->setFlashdata('success', 'Pendaftaran berhasil diubah');
            return redirect()->to('mbkm/hibah')->with('status', 'Pendaftaran berhasil diubah');
        } else {
            return view('mbkm/mbkm_hibah/edit', [
                'title' => 'Edit Pendaftaran MBKM Hibah',
                'validation' => $this->validation,
                'hibah' => $this->hibah->find($id_hibah),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }

    }
    
    public function upload_sr($id_hibah)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM Prodi ',
            'hibah' => $this->hibah->find($id_hibah),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'hibah',
            'validation' => $this->validation,
        ];
        return view('mbkm/mbkm_hibah/upload_sr', $data);
    }
    
    public function proses_upload_sr($id_hibah)
    {
        $surat_rekom = $this->request->getFile('surat_rekom');        
        $rules = [
            'surat_rekom' => [
                'rules' => "ext_in[surat_rekom,pdf]|max_size[surat_rekom,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                    ]
            ],
        ];

        if($this->validate($rules)) {
            $SR = $this->hibah->find($id_hibah);
            $old_lap_akhir = $SR->surat_rekom;
            if($SR->surat_rekom != null) {
                if($surat_rekom->isValid() && !$surat_rekom->hasMoved())
                {
                    if(file_exists('mbkm_assets/hibah-SR/' . $old_lap_akhir)){
                        unlink('mbkm_assets/hibah-SR/' . $old_lap_akhir);
                    }
                       $SRName = $surat_rekom->getRandomName();
                       $surat_rekom->move('mbkm_assets/hibah-SR/', $SRName);
                } else {
                        $SRName = $laporan->surat_rekom;
                }
            } else {
                $SRName = $surat_rekom->getRandomName();
                $surat_rekom->move('mbkm_assets/hibah-SR/', $SRName);
            }
            
            $data = [
                'surat_rekom' => $SRName,
            ];

            $this->hibah->update($id_hibah, $data);
            session()->setFlashdata('success', 'Berkas berhasil diupload');
            return redirect()->to('mbkm/hibah')->with('status', 'Berkas berhasil diupload');
        } else {
            return view('mbkm/mbkm_hibah/edit', [
                'title' => 'Edit Pendaftaran MBKM Hibah',
                'validation' => $this->validation,
                'hibah' => $this->hibah->find($id_hibah),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }
        
    }

    public function detail($id_hibah)
    {
        $data = [
            'title' => 'MBKM Hibah UNS',
            'hibah' => $this->hibah->getDetail($id_hibah),
            'mahasiswa' => $this->mahasiswa->findAll(),
            // 'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'hibah',
        ];
        return view('mbkm/mbkm_hibah/detail', $data);
    }
    
    public function hapus($id)
    {
        $data = $this->hibah->find($id);
        $this->hibah->delete($id);
       
        session()->setFlashdata('status', 'Data MBKM Hibah berhasil dihapus');
        return redirect()->to(base_url('mbkm/hibah'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
    
    public function download_proposal($id_hibah)
    {
        $hibah = $this->hibah->find($id_hibah);
        return $this->response->download('mbkm_assets/hibah-proposal/' . $hibah->proposal, null);
    }
    
    public function download_surat_rekom($id_hibah)
    {
        $hibah = $this->hibah->find($id_hibah);
        return $this->response->download('mbkm_assets/hibah-SR/' . $hibah->surat_rekom, null);
    }

    // status dosen
    public function verif_disetujui_dosen($id_hibah)
    {
        $data = [
            'status_dosen' => 'disetujui',
        ];
        $this->hibah->update($id_hibah, $data);
        return redirect()->to('mbkm/hibah');
    }

    public function verif_tidak_disetujui_dosen($id_hibah)
    {
        $data = [
            'status_dosen' => 'tidak disetujui',
        ];
        $this->hibah->update($id_hibah, $data);
        return redirect()->to('mbkm/hibah');
    }

    public function edit_status_mhs($id)
    {
        $data = [
            'title' => 'Edit Status Mahasiswa',
            'hibah' => $this->hibah->find($id),
            'validation' => $this->validation,
            'activePage' => 'hibah',
            'mahasiswa' => $this->mahasiswa->findAll(),
        ];
        return view('mbkm/mbkm_hibah/edit_status_mhs', $data);
    }

    public function update_status_mhs($id = NULL)
    {   
        $status_mahasiswa = $this->request->getVar('status_mahasiswa');
        $updated_at = round(microtime(true) * 1000);
        $rules = [
            'status_mahasiswa' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ]
        ];
        if ($this->validate($rules)) {
            $data1 = [
                'status_mahasiswa' => $status_mahasiswa,
                'updated_at' => $updated_at,
            ];
            $this->hibah->update($id, $data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/hibah')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diupdate');
        } else {
            return view('mbkm/mbkm_prodi/edit_status_mahasiswa', [
                'title' => 'Edit kegiatan monitoring',
                'hibah' => $this->hibah->find($id),
                'activePage' => 'hibah',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'mbkmFix' => $this->mbkmFix->updateAllMbkm($id_mhs, $nama_instansi),

            ]);
        }
    }

    public function filterHibahAdm($th_masuk)
    {
        $filterMahasiswa = $this->hibah->getFilterHibahAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterHibahDosen($th_masuk)
    {
        $filterDosen = $this->hibah->getFilterHibahDosen($th_masuk);
        return json_encode($filterDosen);
    }

}