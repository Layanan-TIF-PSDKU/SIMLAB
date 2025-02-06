<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Mbkm\MonitoringModel;
use App\Models\Mbkm\MbkmFixModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class MonitoringController extends BaseController
{
    public function __construct()
    {
        $this->monitoring = new MonitoringModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mbkmFix = new MbkmFixModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Monitoring MBKM',
            // 'monitoring' => $this->monitoring->getMonitoring(),
            // 'monitoring' => $this->monitoring->findAll(),
            'MonByMhs' => $this->mbkmFix->getMonByMhs(),
            // 'monitoring2' => $this->monitoring->getMonitoring(),
            // 'mon' => $this->monitoring->getMonitoringByDosen(),
            'mbkmFix' => $this->mbkmFix->getMbkmFixByAdmin(),
            'mbkmFix2' => $this->mbkmFix->getMbkmFixByDosen(),
            'mbkmFix3' => $this->mbkmFix->getMbkmFixByMhs(),
            'mbkmFix6' => $this->mbkmFix->getMbkmFixByDosenMonitoring(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            // monitoring //
            'mbkmFixMonDsnMsib' => $this -> mbkmFix->getMonitoringProdiByDosen(),
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/index', $data);
    }
    
    public function index_mon_msib()
    {
        $data = [
            'title' => 'Monitoring MBKM MSIB',
            'mhs' => $this ->mahasiswa->findAll(),
            'MonDsnMsib' => $this->mbkmFix->getMbkmFixMonMsibDsn(),
            'MonAdmMsib' => $this->mbkmFix->getMbkmFixMonMsibAdm(),
            'mhs2' => $this->mahasiswa->getAngkatanMahasiswa(),
            'mbkmFixMonDsnMsib' => $this -> mbkmFix->getMonitoringProdiByDosen(), // dosen
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/index_mon_msib', $data);
    }
    
    public function detail_mon_msib($id_mbkm_fix)
    {
        $data = [
            'title' => 'Detail Monitoring MBKM MSIB',
            'MonDetailMsibAdm' => $this->mbkmFix->getDetailMonMsibAdm($id_mbkm_fix),
            'MonDetailMsibDsn' => $this -> mbkmFix->getDetailMonMsibDsn($id_mbkm_fix), // dosen
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/detail_mon_msib', $data);
    }
    
    public function FilterMsib()
    {
    
        $kelas = $this->request->getVar('kelas');
        $tanggal_awal = $this->request->getVar('tanggal_awal');
        $tanggal_akhir = $this->request->getVar('tanggal_akhir');
        $data = $this->alatlab->getFilterAlatMasuk($id_ruang, $tanggal_awal, $tanggal_akhir);
        // dd($data);
        return json_encode($data);
    }
    
     // MONITORING - PRODI
    public function index_mon_prodi()
    {
        $data = [
            'title' => 'Monitoring MBKM Prodi',
            'MonDsnProdi' => $this->mbkmFix->getMbkmFixMonProdiDsn(),
            'MonAdmProdi' => $this->mbkmFix->getMbkmFixMonProdiAdm(),
            'mhs2' => $this->mahasiswa->getAngkatanMahasiswa(),
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/index_mon_prodi', $data);
    }
    public function detail_mon_prodi($id_mbkm_fix)
    {
        $data = [
            'title' => 'Detail Monitoring MBKM Prodi',
            'MonDetailProdiAdm' => $this->mbkmFix->getDetailMonProdiAdm($id_mbkm_fix),
            'MonDetailProdiDsn' => $this -> mbkmFix->getDetailMonProdiDsn($id_mbkm_fix), // dosen
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/detail_mon_prodi', $data);
    }
     
     // MONITORING - PRODI
    public function index_mon_hibah()
    {
        $data = [
            'title' => 'Monitoring MBKM Hibah',
           
            'MonDsnHibah' => $this->mbkmFix->getMbkmFixMonHibahDsn(),
            'MonAdmHibah' => $this->mbkmFix->getMbkmFixMonHibahAdm(),
            'mhs2' => $this->mahasiswa->getAngkatanMahasiswa(),
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/index_mon_hibah', $data);
    }
    public function detail_mon_hibah($id_mbkm_fix)
    {
        $data = [
            'title' => 'Monitoring MBKM Hibah',
           
            'MonDetailHibahDsn' => $this->mbkmFix->getDetailMonHibahDsn($id_mbkm_fix),
            // 'MonDetailHibahAdm' => $this->mbkmFix->getDetailMonHibahAdm($id_mbkm_fix),
            'MonDetailHibahAdm' => $this->mbkmFix->getDetailMonHibahAdm($id_mbkm_fix),
            'activePage' => 'monitoring',
        ];
        return view('mbkm/monitoring/detail_mon_hibah', $data);
    }

    // TAMBAH - MONITORING
    public function tambah($id_mbkm_fix)
    {
        $data = [
            'title' => 'Monitoring MBKM',
            'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
            'activePage' => 'monitoring',
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'validation' => $this->validation,
        ];

        return view('mbkm/monitoring/tambah', $data);
    }

    public function simpan($id_mbkm_fix)
    {
        $uuid = Uuid::uuid4();
        $id_monitoring = $uuid->toString();
        $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $tanggal = $this->request->getVar('tanggal');
        $deskripsi = $this->request->getVar('deskripsi');
       

        $rules = [
            'tanggal' => [
            'label' => "tanggal",
            'rules' => "required",
            'errors' => [
            'required' => "{field} harus diisi",
            ],
                ],
            'deskripsi' => [
            'label' => "deskripsi",
            'rules' => "required",
            'errors' => [
            'required' => "{field} harus diisi",
            ],
                ],
                    
        ];
        if ($this->validate($rules)) {
            $data = [
            'id_monitoring' => $uuid,
            'id_mbkm_fix' => $id_mbkm_fix,
            'tanggal' => $tanggal,
            'deskripsi' => $deskripsi,
            
            ];

            $this->monitoring->insert($data);
            
            session()->setFlashdata('success', 'Monitoring berhasil di tambahkan');
            return redirect()->to('mbkm/monitoring');
        } 
        else {
            return view('mbkm/monitoring/tambah', [
                'title' => 'Monitoring MBKM',
                'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'validation' => $this->validation,
            ]);
        }
    }
 // MBKM Prodi
    public function tambah_dosen($id_monitoring)
    {
        $data = [
           
            'title' => 'Monitoring MBKM',
            'monitoring' => $this->monitoring->find($id_monitoring),
            'mbkm' => $this->mbkmFix->findAll(),
            'activePage' => 'monitoring',
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'validation' => $this->validation,
        ];
        return view('mbkm/monitoring/edit', $data);
    }

    public function simpan_dosen($id_monitoring)
    {   
        $feedback = $this->request->getVar('feedback');
        $rules = [
            'feedback' => [
                'label' => "Feedback",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'feedback' => $feedback,
            ];
           
            $this->monitoring->update($id_monitoring, $data);
            session()->setFlashdata('success', 'Feedback berhasil disimpan!');
            return redirect()->to('mbkm/monitoring/mbkm-prodi')->with('status_icon', 'success')->with('status_text', 'Feedback berhasil disimpan!');
        } else {
            return view('mbkm/monitoring/edit', [
                'title' => 'Edit kegiatan monitoring',
                'monitoring' => $this->monitoring->find($id_monitoring),
                // 'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'activePage' => 'monitoring',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
            ]);
        }
    }
    // MSIB
    public function tambah_dosen_msib($id_monitoring)
    {
        $data = [
           
            'title' => 'Monitoring MBKM',
            'monitoring' => $this->monitoring->find($id_monitoring),
            'mbkm' => $this->mbkmFix->findAll(),
            'activePage' => 'monitoring',
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'validation' => $this->validation,
        ];
        return view('mbkm/monitoring/edit_msib', $data);
    }

    public function simpan_dosen_msib($id_monitoring)
    {   
        $feedback = $this->request->getVar('feedback');
        $rules = [
            'feedback' => [
                'label' => "Feedback",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'feedback' => $feedback,
            ];
           
            $this->monitoring->update($id_monitoring, $data);
            session()->setFlashdata('success', 'Feedback berhasil disimpan!');
            return redirect()->to('mbkm/monitoring/msib')->with('status_icon', 'success')->with('status_text', 'Feedback berhasil disimpan!');
        } else {
            return view('mbkm/monitoring/edit_msib', [
                'title' => 'Edit kegiatan monitoring',
                'monitoring' => $this->monitoring->find($id_monitoring),
                // 'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'activePage' => 'monitoring',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
            ]);
        }
    }
    public function tambah_dosen_hibah($id_monitoring)
    {
        $data = [
           
            'title' => 'Monitoring MBKM',
            'monitoring' => $this->monitoring->find($id_monitoring),
            'mbkm' => $this->mbkmFix->findAll(),
            'activePage' => 'monitoring',
            'staf' => $this->staf->findAll(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'validation' => $this->validation,
        ];
        return view('mbkm/monitoring/edit_hibah', $data);
    }

    public function simpan_dosen_hibah($id_monitoring)
    {   
        $feedback = $this->request->getVar('feedback');
        $rules = [
            'feedback' => [
                'label' => "Feedback",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'feedback' => $feedback,
            ];
           
            $this->monitoring->update($id_monitoring, $data);
            session()->setFlashdata('success', 'Feedback berhasil disimpan!');
            return redirect()->to('mbkm/monitoring/mbkm-hibah')->with('status_icon', 'success')->with('status_text', 'Feedback berhasil disimpan!');
        } else {
            return view('mbkm/monitoring/edit_hibah', [
                'title' => 'Edit kegiatan monitoring',
                'monitoring' => $this->monitoring->find($id_monitoring),
                // 'mbkm' => $this->mbkmFix->find($id_mbkm_fix),
                'activePage' => 'monitoring',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
            ]);
        }
    }

    // public function simpan_dosen($id_monitoring)
    // {   
        
    //     // $id_monitoring = $this->request->getVar('id_mo$id_monitoring');
    //     $feedback = $this->request->getVar('feedback');
    //     d($feedback);
    //         $rules = [
    //             'feedback' => [
    //                 'label' => "feedback",
    //                 'rules' => "required",
    //                 'errors' => [
    //                     'required' => "{field} harus diisi",
    //                     'is_unique' => "{field} yang dimasukan Sudah ada",
    //                 ],
    //             ],
    //         ];
       
    //     if ($this->validate($rules)) {
    //         $data = [
    //             'feedback' => $feedback,
    //         ];
    //         $this->monitoring->update($id_monitoring, $data);
    //         // $bukti->move('mbkm_assets/mbkmFix-bukti/', $buktiName);
    //         session()->setFlashdata('success', 'Bukti berhasil diupload');
    //         return redirect()->to('mbkm/monitoring/msib')->with('status', 'Bukti berhasil diupload');
    //     } else {
    //         return view('mbkm/monitoring/detail_mon_msib');
    //     }
    // }

    public function hapus($id)
    {
        $data = $this->monitoring->find($id);
        $this->monitoring->delete($id);
        session()->setFlashdata('success', 'Kegiatan monitoring berhasil dihapus');
        return redirect()->back()->with('status_text', 'Data Berhasil dihapus');
    }

    public function filterAdm($th_masuk)
    {
        $filterMahasiswa = $this->mbkmFix->getFilterMonMsibAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterDosen($th_masuk)
    {
        $filterDosen = $this->mbkmFix->getFilterMonMsibDsn($th_masuk);
        return json_encode($filterDosen);
    }

    
    public function filterAdmProdi($th_masuk)
    {
        $filterMahasiswa = $this->mbkmFix->getFilterMonProdiAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterDosenProdi($th_masuk)
    {
        $filterDosen = $this->mbkmFix->getFilterMonProdiDsn($th_masuk);
        return json_encode($filterDosen);
    }

    
    public function filterAdmHibah($th_masuk)
    {
        $filterMahasiswa = $this->mbkmFix->getFilterMonHibahAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterDosenHibah($th_masuk)
    {
        $filterDosen = $this->mbkmFix->getFilterMonHibahDsn($th_masuk);
        return json_encode($filterDosen);
    }
}