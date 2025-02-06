<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\PengajuanProposalModel;
use App\Models\Kmm\KmmModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Master\MitraModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class ProposalController extends BaseController
{
    public function __construct()
    {
        $this->proposal = new PengajuanProposalModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->kmm = new KmmModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Proposal KMM',
            'proposal' => $this->proposal->getProposalbyIdMahasiswa(),
            'proposal2' => $this->proposal->getProposalbyIdDosen(),
            'status' => $this->proposal->getStatus(),
            'statuskmm' => $this->kmm->getStatus(),
            'kmm' => $this->kmm->getKMMbyIdMhs(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
        ];

        return view('kmm/pengajuan_proposal/index', $data);
    }
    
    public function create(){
        $data = [
            'title' => 'Proposal KMM',
            'proposal' => $this->proposal->findAll(),
            'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),
            'staf' => $this->staf->getAllDosen(),
            'mitra' => $this->mitra->getMitraKMM(),
            'validation' => $this->validation,
        ];

        return view('kmm/pengajuan_proposal/tambah', $data);
    }

    public function store()
    {
        $uuid =  Uuid::uuid4();
        $id_proposal = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $id_mitra = $this->request->getVar('id_mitra');
        $proposal_awal = $this->request->getFile('proposal_awal');
        $proposalName = $proposal_awal->getRandomName();
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
            'proposal_awal' => [
                'rules' => "uploaded[proposal_awal]|ext_in[proposal_awal,pdf]|max_size[proposal_awal,5120]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
					'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
        ];

        
        if($this->validate($rules)) {
            $data = [
                'id_proposal' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'id_mitra' => $id_mitra,
                'proposal_awal' => $proposalName,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];

            $this->proposal->insert($data);
            $proposal_awal->move('kmm_assets/proposal-awal/', $proposalName);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('kmm/proposal');
        } else {
            return view('kmm/pengajuan_proposal/tambah', [
                'title' => 'Pengajuan Proposal KMM',
                'proposal' => $this->proposal->findAll(),
                'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),
                'staf' => $this->staf->findAll(),
                'mitra' => $this->mitra->getMitraKMM(),
                'validation' => $this->validation
            ]);
        }
    }

    public function update($id_proposal)
    {
        $proposal_awal = $this->request->getFile('proposal_awal');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'proposal_awal' => [
                'rules' => "ext_in[proposal_awal,pdf]|max_size[proposal_awal,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                    ]
                ],
            ];
            
            if($this->validate($rules)){
                $prop = $this->proposal->find($id_proposal);
                $old_prop = $prop->proposal_awal;
                
                if($proposal_awal->isValid() && !$proposal_awal->hasMoved())
                {
                    if(file_exists('kmm_assets/proposal-awal/' . $old_prop)){
                        unlink('kmm_assets/proposal-awal/' . $old_prop);
                    }
                    $proposalName = $proposal_awal->getRandomName(); 
                    $proposal_awal->move('kmm_assets/proposal-awal/', $proposalName); 
                } else {
                    $proposalName = $prop->proposal_awal;
                }
                
                $data = [
                    'proposal_awal' => $proposalName,
                    'status_proposal' => 'pending',
                    'updated_at' => $updated_at,
                ];

                $this->proposal->update($id_proposal, $data);
                session()->setFlashdata('success', 'Data berhasil diupdate');
                return redirect()->to('kmm/proposal');
            } else {
                session()->setFlashdata('error', 'Data gagal diupdate');
                return redirect()->to('kmm/proposal');
            }
    }

    public function delete($id_proposal)
    {
        $file = $this->proposal->find($id_proposal);
        $prop = $file->proposal_awal;
        
        if(file_exists('kmm_assets/proposal-awal/' . $prop)){
            unlink('kmm_assets/proposal-awal/' . $prop);
        }
        
        $this->proposal->delete($id_proposal);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('kmm/proposal');
    }
    
    public function download_proposal($id_proposal)
    {
        $proposal = $this->proposal->find($id_proposal);       
        return $this->response->download('kmm_assets/proposal-awal/' . $proposal->proposal_awal, null);
    }

    public function verif_disetujui($id_proposal){
        $data = [
            'status_proposal' => 'disetujui',
            'catatan' => 'Tidak Ada Catatan',
        ];

        $this->proposal->update($id_proposal, $data);
        session()->setFlashdata('success', 'Update status verifikasi proposal KMM berhasil');
        return redirect()->to('kmm/proposal');
    }
    
    public function verif_tidak_disetujui($id_proposal){
        $status_proposal = 'tidak disetujui';
        $catatan = 'Mitra tidak sesuai. Silahkan ajukan kembali proposal KMM yang baru';

        $data = [
            'status_proposal' => $status_proposal,
            'catatan' => $catatan,
        ];
        $this->proposal->update($id_proposal, $data);
        session()->setFlashdata('success', 'Update status verifikasi proposal KMM berhasil');
        return redirect()->to('kmm/proposal');
    }
    
    public function verif_revisi($id_proposal){
        $status_proposal = 'revisi';
        $catatan = $this->request->getVar('catatan');

        $data = [
            'status_proposal' => $status_proposal,
            'catatan' => $catatan,
        ];
        $this->proposal->update($id_proposal, $data);
        session()->setFlashdata('success', 'Update status verifikasi proposal KMM berhasil');
        return redirect()->to('kmm/proposal');
    }

    public function getFilterProposalByIdDosen($th_masuk)
    {
        $filterDosen = $this->proposal->getFilterProposalByIdDosen($th_masuk);
        return json_encode($filterDosen);
    }

}
?>