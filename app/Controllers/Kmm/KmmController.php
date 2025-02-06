<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\KmmModel;
use App\Models\Kmm\PengajuanProposalModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Master\MitraModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class KmmController extends BaseController
{
    public function __construct()
    {
        $this->kmm = new KmmModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->proposal = new PengajuanProposalModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Data KMM',
            'kmm' => $this->kmm->getAllKMM(),
            'kmm2' => $this->kmm->getKMMbyIdMhs(),
            'kmm3' => $this->kmm->getKMMbyIdDosen(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'statuskmm' => $this->kmm->getStatus(),
            'proposal' => $this->proposal->getStatus(),
        ];

        return view('kmm/kmm/index', $data);
    }

    public function detail($id_kmm)
    {
        $data = [
            'title' => 'Detail KMM',
            'kmm' => $this->kmm->getKMMById($id_kmm),
        ];
        return view('kmm/kmm/detail', $data);
    }
    
    public function create(){
        $data = [
            'title' => 'Pendaftaran KMM',
            'kmm' => $this->kmm->findAll(),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->kmm->getMahasiswaByProposal(),
            'staf' => $this->staf->getAllDosen(),
            'mitra' => $this->mitra->getMitraKMM(),
            'validation' => $this->validation,
        ];

        return view('kmm/kmm/tambah', $data);
    }

    public function store()
    {
        $uuid =  Uuid::uuid4();
        $id_kmm = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $id_mitra = $this->request->getVar('id_mitra');
        $tanggal_mulai = $this->request->getVar('tgl_mulai');
        $tanggal_selesai = $this->request->getVar('tgl_selesai');
        $proposal = $this->request->getFile('proposal');
        $proposalName = $proposal->getRandomName();
        $surat_pengantar = $this->request->getFile('surat_pengantar');
        $suratName = $surat_pengantar->getRandomName();
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'id_mhs' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Mahasiswa harus diisi",
                ]
            ],
            'id_staf' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Dosen Pembimbing harus diisi",
                ]
            ],
            'id_mitra' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ]
            ],
            'tgl_mulai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Tanggal harus diisi",
                ]
            ],
            'tgl_selesai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Tanggal harus diisi",
                ]
            ],
            'proposal' => [
                'rules' => "uploaded[proposal]|ext_in[proposal,pdf]|max_size[proposal,5048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
					'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
            'surat_pengantar' => [
                'rules' => "uploaded[surat_pengantar]|ext_in[surat_pengantar,pdf]|max_size[surat_pengantar,5048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
					'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
        ];

        if($this->validate($rules)) {
            $data = [
                'id_kmm' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'id_mitra' => $id_mitra,
                'tgl_mulai' => $tanggal_mulai,
                'tgl_selesai' => $tanggal_selesai,
                'proposal' => $proposalName,
                'surat_pengantar' => $suratName,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            
            $this->kmm->insert($data);
            $proposal->move('kmm_assets/proposal-akhir/', $proposalName);
            $surat_pengantar->move('kmm_assets/surat-pengantar/', $suratName);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('kmm/kmm');
        } else {
            return view('kmm/kmm/tambah', [
                'title' => 'Pendaftaran KMM',
                'kmm' => $this->kmm->findAll(),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->kmm->getMahasiswaByProposal(),
                'staf' => $this->staf->findAll(),
                'mitra' => $this->mitra->getMitraKMM(),
                'validation' => $this->validation
            ]);
        }
    }
    
    public function edit($id_kmm)
    {
        $data = [
            'title' => 'Edit Pendaftaran KMM',
            'validation' => $this->validation,
            'kmm' => $this->kmm->find($id_kmm),
            'mahasiswa' => $this->kmm->getMahasiswaByProposal(),
            'staf' => $this->staf->getAllDosen(),
            'mitra' => $this->mitra->getMitraKMM(),
        ];
        return view('kmm/kmm/edit', $data);
    }

    public function update($id_kmm)
    {
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $id_mitra = $this->request->getVar('id_mitra');
        $tanggal_mulai = $this->request->getVar('tgl_mulai');
        $tanggal_selesai = $this->request->getVar('tgl_selesai');
        $proposal = $this->request->getFile('proposal');
        $proposalName = $proposal->getRandomName();
        $surat_pengantar = $this->request->getFile('surat_pengantar');
        $suratName = $surat_pengantar->getRandomName();
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'id_staf' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Dosen Pembimbing harus diisi",
                ]
            ],
            'id_mitra' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
                ]
            ],
            'proposal' => [
                'rules' => "ext_in[proposal,pdf]|max_size[proposal,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
            'surat_pengantar' => [
                'rules' => "ext_in[surat_pengantar,pdf]|max_size[surat_pengantar,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
        ];
            
        if($this->validate($rules)) {
            $prop = $this->kmm->find($id_kmm);
            $old_prop = $prop->proposal;
            
            if($proposal->isValid() && !$proposal->hasMoved())
            {
                if(file_exists('kmm_assets/proposal-akhir/' . $old_prop)){
                    unlink('kmm_assets/proposal-akhir/' . $old_prop);
                }
                   $proposalName = $proposal->getRandomName();
                   $proposal->move('kmm_assets/proposal-akhir/', $proposalName);
            } else {
                $proposalName = $prop->proposal;
            }
            
            $surat = $this->kmm->find($id_kmm);
            $old_surat = $surat->surat_pengantar;
            
            if($surat_pengantar->isValid() && !$surat_pengantar->hasMoved())
            {
                if(file_exists('kmm_assets/surat-pengantar/' . $old_surat)){
                    unlink('kmm_assets/surat-pengantar/' . $old_surat);
                }
                   $suratName = $surat_pengantar->getRandomName();
                   $surat_pengantar->move('kmm_assets/surat-pengantar/', $suratName);
            } else {
                    $suratName = $surat->surat_pengantar;
            }
            $data = [
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'id_mitra' => $id_mitra,
                'tgl_mulai' => $tanggal_mulai,
                'tgl_selesai' => $tanggal_selesai,
                'proposal' => $proposalName,
                'surat_pengantar' => $suratName,
                'updated_at' => $updated_at,
            ];
            $this->kmm->update($id_kmm, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('kmm/kmm');
        } else {
            return view('kmm/kmm/edit', [
                'title' => 'Edit Pendaftaran KMM',
                'validation' => $this->validation,
                'kmm' => $this->kmm->find($id_kmm),
                'mahasiswa' => $this->kmm->getMahasiswaByProposal(),
                'staf' => $this->staf->getAllDosen(),
                'mitra' => $this->mitra->getMitraKMM(),
            ]);
        }
    }

    public function delete($id_kmm)
    {
        $file = $this->kmm->find($id_kmm);
        $proposal = $file->proposal;
        $surat = $file->surat_pengantar;
        $laporan = $file->laporan_akhir;
        $loa = $file->loa;
        $logbook = $file->logbook;
        
        if(file_exists('kmm_assets/proposal-akhir/' . $proposal)){
            unlink('kmm_assets/proposal-akhir/' . $proposal);
        }
        if(file_exists('kmm_assets/surat-pengantar/' . $surat)){
            unlink('kmm_assets/surat-pengantar/' . $surat);
        }

        if($laporan != null) {
            if(file_exists('kmm_assets/laporan-akhir/' . $laporan)){
                unlink('kmm_assets/laporan-akhir/' . $laporan);
            }
        }

        if($loa != null){
        if(file_exists('kmm_assets/LoA/' . $loa)){
            unlink('kmm_assets/LoA/' . $loa);
        }
        }

        if($logbook != null){
        if(file_exists('kmm_assets/logbook/' . $logbook)){
            unlink('kmm_assets/logbook/' . $logbook);
        }
        }
        
        $this->kmm->delete($id_kmm);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('kmm/kmm');
    }

    public function download_proposal($id_kmm)
    {
        $kmm = $this->kmm->find($id_kmm);       
        return $this->response->download('kmm_assets/proposal-akhir/' . $kmm->proposal, null);
    }

    public function download_surat_pengantar($id_kmm)
    {
        $kmm = $this->kmm->find($id_kmm);       
        return $this->response->download('kmm_assets/surat-pengantar/' . $kmm->surat_pengantar, null);
    }
    
    public function download_loa($id_kmm)
    {
        $kmm = $this->kmm->find($id_kmm);       
        return $this->response->download('kmm_assets/LoA/' . $kmm->loa, null);
    }
    
    public function download_bukti_gagal($id_kmm)
    {
        $kmm = $this->kmm->find($id_kmm);       
        return $this->response->download('kmm_assets/bukti-tidak-lolos/' . $kmm->bukti_gagal, null);
    }

    public function verif_lolos($id_kmm){
        $loa = $this->request->getFile('loa');
        $loaName = $loa->getRandomName();

        $rules = [
            'loa' => [
                'rules' => "uploaded[loa]|ext_in[loa,pdf]|max_size[loa,5120]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB',
                ]
            ],
        ];

        if($this->validate($rules)){
            $data = [
                'status_lolos' => 'lolos',
                'loa' => $loaName,
            ];
            $this->kmm->update($id_kmm, $data);
            $loa->move('kmm_assets/LoA/', $loaName);
            session()->setFlashdata('success', 'Update status KMM berhasil');
            return redirect()->to('kmm/kmm');
        } else {
            session()->setFlashdata('error', 'Gagal update status KMM. Silahkan ulangi lagi');
            return redirect()->to('kmm/kmm');
        }
    }
    
    public function verif_tidak_lolos($id_kmm){
        $bukti = $this->request->getFile('bukti_gagal');
        $buktiName = $bukti->getRandomName();

        $rules = [
            'bukti_gagal' => [
                'rules' => "uploaded[bukti_gagal]|ext_in[bukti_gagal,pdf]|max_size[bukti_gagal,5120]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB',
                ]
            ],
        ];

        if($this->validate($rules)){
            $data = [
                'status_lolos' => 'tidak lolos',
                'bukti_gagal' => $buktiName,
            ];
            $this->kmm->update($id_kmm, $data);
            $bukti->move('kmm_assets/bukti-tidak-lolos/', $buktiName);
            session()->setFlashdata('success', 'Update status KMM berhasil');
            return redirect()->to('kmm/kmm');
        } else {
            session()->setFlashdata('error', 'Gagal update status KMM. Silahkan ulangi lagi');
            return redirect()->to('kmm/kmm');
        }
    }

    public function getFilterDataKMM($th_masuk)
    {
        $filterDosen = $this->kmm->getFilterDataKMM($th_masuk);
        return json_encode($filterDosen);
    }

    public function getFilterDataKMMByIdDosen($th_masuk)
    {
        $filterDosen = $this->kmm->getFilterDataKMMByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }
}
?>