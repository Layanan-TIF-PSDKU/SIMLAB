<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Mbkm\MbkmProdiModel;
use App\Models\Mbkm\MbkmFixModel;
use Myth\Auth\Models\GroupModel;
use Ramsey\Uuid\Uuid;

class MbkmProdiController extends BaseController
{

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mbkmProdi = new MbkmProdiModel();
        $this->mbkmFix = new MbkmFixModel();
        $this->group = new GroupModel();
        helper('form');
    }

    public function index()
    {
        $data = [
        'title' => 'MBKM Prodi',
        'mbkmProdi' => $this->mbkmProdi->findAll(),
        'mbkmProdi2' => $this->mbkmProdi->getMbkmProdiByMhs(),
        'mbkmProdi3' => $this->mbkmProdi->getMbkmProdiByDosen(),
        'mahasiswa' => $this->mahasiswa->findAll(),
        'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
        'mhs2' => $this->mahasiswa->getAngkatanMahasiswa(),
        'staf' => $this->staf->findAll(),
        'activePage' => 'mbkmProdi',
        ];
        
        return view('mbkm/mbkm_prodi/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Pendaftaran MBKM Prodi',
            'mbkmProdi' => $this->mbkmProdi->findAll(),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'validation' => $this->validation,
            'activePage' => 'mbkmProdi',
        ];
            return view('mbkm/mbkm_prodi/tambah', $data);
        
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_mprodi = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_instansi = $this->request->getVar('nama_instansi');
        // $lap_akhir = $this->request->getFile('lap_akhir');
        // $lap_akhirName = $lap_akhir->getRandomName();
        // $LoA = $this->request->getFile('LoA');
        // $LoAName = $LoA->getRandomName();
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
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'nama_instansi' => [
                'label' => "Nama Instansi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_mprodi' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_instansi' => $nama_instansi,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->mbkmProdi->insert($data);
            // $lap_akhir->move('mbkm_assets/prodi-LapAkhir/', $lap_akhirName);
            // $LoA->move('mbkm_assets/prodi-LoA/', $LoAName);
            session()->setFlashdata('success', 'Pendaftaran Berhasil!');
            return redirect()->to('mbkm/mbkmProdi')->with('status_icon', 'success')->with('status_text', 'Pendaftaran Berhasil!');
        } else {
            return view('mbkm/mbkm_prodi/tambah', [
                'title' => 'Pendaftaran MBKM Prodi',
                'mbkmProdi' => $this->mbkmProdi->findAll(),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),                
                'staf' => $this->staf->findAll(),
                'activePage' => 'mbkmProdi',
                'validation' => $this->validation,
            ]);
        }
    }
    public function edit($id_mprodi)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM Prodi ',
            'mbkmProdi' => $this->mbkmProdi->find($id_mprodi),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'mbkmProdi',
            'validation' => $this->validation,
        ];
        return view('mbkm/mbkm_prodi/edit', $data);
    }
    public function update($id_mprodi)
    {
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $surat_rekom = $this->request->getFile('surat_rekom');
        $surat_rekomName = $surat_rekom->getRandomName();
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'id_mhs' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Mahasiswa harus diisi",
                ],
            ],
            'id_staf' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Dosen Pembimbing harus diisi",
                ],
            ],
            'nama_instansi' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Instansi harus diisi",
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
        $surat = $this->mbkmProdi->find($id_mprodi);
        if ($this->validate($rules)) {
            if($surat_rekom->isValid() && !$surat_rekom->hasMoved())
            {
                if(file_exists('mbkm_assets/prodi-sr/' . $old_sr)){
                    unlink('mbkm_assets/prodi-sr/' . $old_sr);
                }
                   $surat_rekomName = $surat_rekom->getRandomName();
                   $surat_rekom->move('mbkm_assets/prodi-sr/', $surat_rekomName);
            } else {
                    $surat_rekomName = $surat->surat_rekom;
            }
                $data = [
                    'id_mhs' => $id_mhs,
                    'id_staf' => $id_staf,
                    'nama_instansi' => $nama_instansi,
                    'surat_rekom' => $surat_rekomName,
                    'updated_at' => $updated_at,
                ];
    
            $this->mbkmProdi->update($id_mprodi, $data);
            session()->setFlashdata('success', 'Pendaftaran Berhasil Diubah!');
            return redirect()->to('mbkm/mbkmProdi')->with('status_icon', 'success')->with('status_text', 'Pendaftaran Berhasil Diubah!');
           
        } else {
            return view('mbkm/msib/edit', [
                'title' => 'Edit Pendaftaran MBKM Prodi',
                'validation' => $this->validation,
                'mbkmProdi' => $this->mbkmProdi->find($id_mprodi),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }
    }
    

     // upload berkas
     public function upload_sr($id_mprodi)
     {
         $data = [
            'title' => 'Upload Berkas ',
            'mbkmProdi' => $this->mbkmProdi->find($id_mprodi),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'mbkmProdi',
            'validation' => $this->validation,
             
         ];
         return view('mbkm/mbkm_prodi/upload_sr', $data);
     }
 
     public function proses_upload_sr($id_mprodi)
     {
         $surat_rekom = $this->request->getFile('surat_rekom');
         $SRName = $surat_rekom->getRandomName();
         $rules = [
             'surat_rekom' => [
                 'rules' => "ext_in[surat_rekom,pdf]|max_size[surat_rekom,5120]",
                 'errors' => [
                     'ext_in' => 'File berupa pdf',
                     'max_size' => 'Size maks 5 MB',
                 ],
             ],
             
         ];
 
         if ($this->validate($rules)) {
 
             $data = [
                 // 'sptjm' => $SPTJMName,
                 'surat_rekom' => $SRName,
             ];
 
             $this->mbkmProdi->update($id_mprodi, $data);
             $surat_rekom->move('mbkm_assets/prodi-sr/', $SRName);
             session()->setFlashdata('success', 'File berhasil diupload');
             return redirect()->to('mbkm/mbkmProdi')->with('status', 'File berhasil diupload');
         } else {
             return view('mbkm/mbkm_prodi/upload_sr', [
                 'title' => 'Upload Berkas',
                 'validation' => $this->validation,
                 'mbkmProdi' => $this->msib->find($id_mprodi),
                 'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                 'mahasiswa' => $this->mahasiswa->findAll(),
                 'staf' => $this->staf->findAll(),
             ]);
         }
 
     }
    
     public function detail($id_mprodi)
    {
        $data = [
            'title' => 'MBKM MSIB',
            'mbkmProdi' => $this->mbkmProdi->getDetail($id_mprodi),
            'mahasiswa' => $this->mahasiswa->findAll(),
            // 'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'mbkmProdi',
        ];
        return view('mbkm/mbkm_prodi/detail', $data);
    }
    
    public function hapus($id)
    {
        $data = $this->mbkmProdi->find($id);
        $this->mbkmProdi->delete($id);
        session()->setFlashdata('success', 'Data Pendaftaran MBKM Prodi berhasil dihapus');
        return redirect()->to(base_url('mbkm/mbkmProdi'))->with('status_icon', 'success')->with('status_text', 'Data Pendaftaran MBKM Prodi Berhasil dihapus');
    }
  

    public function download_sr($id_mprodi)
    {
        $mbkmProdi = $this->mbkmProdi->find($id_mprodi);
        return $this->response->download('mbkm_assets/prodi-sr/' . $mbkmProdi->surat_rekom, null);
    }


    // status dosen
    public function verif_disetujui_dosen($id_mprodi){
        $data = [
            'status_dosen' => 'disetujui',
        ];
        $this->mbkmProdi->update($id_mprodi, $data);
        return redirect()->to('mbkm/mbkmProdi');
    }
    
    public function verif_tidak_disetujui_dosen($id_mprodi){
        $data = [
            'status_dosen' => 'tidak disetujui',
        ];
        $this->mbkmProdi->update($id_mprodi, $data);
        return redirect()->to('mbkm/mbkmProdi');
    }

   
    public function edit_status_mhs($id)
    {
        $data = [
            'title' => 'Edit Status Mahasiswa',
            'mbkmProdi' => $this->mbkmProdi->find($id),
            'validation' => $this->validation,
            'activePage' => 'mbkmProdi',
            'mahasiswa' => $this->mahasiswa->findAll(),
        ];
        return view('mbkm/mbkm_prodi/edit_status_mhs', $data);
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
            $this->mbkmProdi->update($id, $data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/mbkmProdi')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diedit');
        } else {
            return view('mbkm/mbkm_prodi/edit_status_mahasiswa', [
                'title' => 'Edit kegiatan monitoring',
                'mbkmProdi' => $this->mbkmProdi->find($id),
                'activePage' => 'mbkmProdi',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'mbkmFix' => $this->mbkmFix->updateAllMbkm($id_mhs, $id_staf, $nama_instansi),

            ]);
        }
    }
    
    public function filterProdiAdm($th_masuk)
    {
        $filterMahasiswa = $this->mbkmProdi->getFilterProdiAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterProdiDosen($th_masuk)
    {
        $filterDosen = $this->mbkmProdi->getFilterProdiDosen($th_masuk);
        return json_encode($filterDosen);
    }



}
    