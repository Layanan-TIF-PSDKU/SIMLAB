<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Mbkm\MbkmFixModel;
use App\Models\Mbkm\MsibModel;
use Ramsey\Uuid\Uuid;
// Excel Export
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MsibController extends BaseController
{

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->msib = new MsibModel();
        $this->mbkmFix = new MbkmFixModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'MBKM MSIB',
            'msib' => $this->msib->findAll(),
            'msib2' => $this->msib->getMsibByUser(),
            'msib3' => $this->msib->getMsibByDosen(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'msib',
        ];
        return view('mbkm/msib/index', $data);
    }


    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data MSIB',
            'staf' => $this->staf->findAll(),
            'msib' => $this->msib->findAll(),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'msib',
            'validation' => $this->validation,

        ];

        return view('mbkm/msib/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_msib = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $link_msib = $this->request->getVar('link_msib');
        // $LoA = $this->request->getVar('LoA');
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
            'link_msib' => [
                'label' => "Link MSIB",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_msib' => $uuid,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_instansi' => $nama_instansi,
                'link_msib' => $link_msib,
                // 'lap_akhir' => $lap_akhirName,
                // 'LoA' => $LoAName,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->msib->insert($data);
            // $lap_akhir->move('mbkm_assets/msib-LapAkhir/', $lap_akhirName);
            // $LoA->move('mbkm_assets/msib-LoA/', $LoAName);
            session()->setFlashdata('success', 'Pendaftaran Berhasil!');
            return redirect()->to('mbkm/msib')->with('status_icon', 'success')->with('status_text', 'Pendaftaran Berhasil!');
        } else {
            return view('mbkm/msib/tambah', [
                'title' => 'Pendaftaran MBKM MSIB',
                'msib' => $this->msib->findAll(),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'msib',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_msib)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM MSIB ',
            'msib' => $this->msib->find($id_msib),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'msib',
            'validation' => $this->validation,
        ];
        return view('mbkm/msib/edit', $data);
    }
    public function update($id_msib)
    {
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $link_msib = $this->request->getVar('link_msib');

        $sptjm = $this->request->getFile('sptjm');
        $sptjmName = $sptjm->getRandomName();

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
            'sptjm' => [
                'rules' => "ext_in[sptjm,pdf]|max_size[sptjm,5048]",
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
        
        if($this->validate($rules)) {
            $msibSptjm = $this->msib->find($id_msib);
            $old_sptjm = $msibSptjm->sptjm;
            
            if($sptjm->isValid() && !$sptjm->hasMoved())
            {
                if(file_exists('mbkm_assets/msib-sptjm/' . $old_sptjm)){
                    unlink('mbkm_assets/msib-sptjm/' . $old_sptjm);
                }
                   $sptjmName = $sptjm->getRandomName();
                   $sptjm->move('mbkm_assets/msib-sptjm/', $sptjmName);
            } else {
                $sptjmName = $msibSptjm->sptjm;
            }
            
            $surat = $this->msib->find($id_msib);
            $old_sr = $surat->surat_rekom;
            
            if($surat_rekom->isValid() && !$surat_rekom->hasMoved())
            {
                if(file_exists('mbkm_assets/msib-sr/' . $old_sr)){
                    unlink('mbkm_assets/msib-sr/' . $old_sr);
                }
                   $surat_rekomName = $surat_rekom->getRandomName();
                   $surat_rekom->move('mbkm_assets/msib-sr/', $surat_rekomName);
            } else {
                    $surat_rekomName = $surat->surat_rekom;
            }
            $data = [
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'nama_instansi' => $nama_instansi,
                'link_msib' => $link_msib,
                'sptjm' => $sptjmName,
                'surat_rekom' => $surat_rekomName,
                'updated_at' => $updated_at,
            ];
            $this->msib->update($id_msib, $data);
            session()->setFlashdata('success', 'Pendaftaran Berhasil Diubah!');
            return redirect()->to('mbkm/msib')->with('status_icon', 'success')->with('status_text', 'Pendaftaran Berhasil Diubah!');
        // if ($this->validate($rules)) {
        //     $data = [
        //         'id_mhs' => $id_mhs,
        //         'id_staf' => $id_staf,
        //         'nama_instansi' => $nama_instansi,
        //         'link_msib' => $link_msib,
        //         'sptjm' => $sptjmName,
        //         'surat_rekom' => $surat_rekomName,
        //         'updated_at' => $updated_at,
        //     ];
        } else {
            return view('mbkm/msib/edit', [
                'title' => 'Edit Pendaftaran MBKM Prodi',
                'validation' => $this->validation,
                'msib' => $this->mbkmProdi->find($id_msib),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }
    }
    public function hapus($id)
    {
        $data = $this->msib->find($id);
        $this->msib->delete($id);
        session()->setFlashdata('success', 'Data MBKM MSIB berhasil dihapus');
        return redirect()->to(base_url('mbkm/msib'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
    public function detail($id_msib)
    {
        $data = [
            'title' => 'MBKM MSIB',
            // 'msib' => $this->msib->findAll($id_msib),
            'msib2' => $this->msib->getDetail($id_msib),
            'msib3' => $this->msib->getMsibByDosen(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'msib',
        ];
        return view('mbkm/msib/detail', $data);
    }

    // upload berkas
    public function upload_berkas($id_msib)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM Prodi ',
            'msib' => $this->msib->find($id_msib),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'msib',
            'validation' => $this->validation,
            
        ];
        return view('mbkm/msib/upload_berkas', $data);
    }

    public function proses_upload_berkas($id_msib)
    {
        $surat_rekom = $this->request->getFile('surat_rekom');
        $SRName = $surat_rekom->getRandomName();
        // $sptjm = $this->request->getFile('sptjm');
        // $SPTJMName = $sptjm->getRandomName();
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

            $this->msib->update($id_msib, $data);
            $surat_rekom->move('mbkm_assets/msib-sr/', $SRName);
            session()->setFlashdata('success', 'File berhasil diupload');
            return redirect()->to('mbkm/msib')->with('status', 'File berhasil diupload');
        } else {
            return view('mbkm/mbkm_msib/upload_berkas', [
                'title' => 'Upload Berkas',
                'validation' => $this->validation,
                'msib' => $this->msib->find($id_msib),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }

    }
    // upload berkas
    public function upload_sptjm($id_msib)
    {
        $data = [
            'title' => 'Edit Pendaftaran MBKM Prodi ',
            'msib' => $this->msib->find($id_msib),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'msib',
            'validation' => $this->validation,
        ];
        return view('mbkm/msib/upload_sptjm', $data);
    }
    public function proses_upload_sptjm($id_msib)
    {
       
        $sptjm = $this->request->getFile('sptjm');
        $SPTJMName = $sptjm->getRandomName();

        $rules = [
            
            'sptjm' => [
                'rules' => "ext_in[sptjm,pdf]|max_size[sptjm,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {

            $data = [
                'sptjm' => $SPTJMName,
                
            ];

            $this->msib->update($id_msib, $data);
            $sptjm->move('mbkm_assets/msib-sptjm/', $SPTJMName);
            session()->setFlashdata('success', 'File berhasil diupload');
            return redirect()->to('mbkm/msib')->with('status', 'File berhasil diupload');
        } else {
            return view('mbkm/mbkm_msib/upload_sptjm', [
                'title' => 'Upload Berkas',
                'validation' => $this->validation,
                'msib' => $this->msib->find($id_msib),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }

    }

    public function download_sr($id_msib)
    {
        $msib = $this->msib->find($id_msib);
        return $this->response->download('mbkm_assets/msib-sr/' . $msib->surat_rekom, null);
    }

    public function download_sptjm($id_msib)
    {
        $msib = $this->msib->find($id_msib);
        return $this->response->download('mbkm_assets/msib-sptjm/' . $msib->sptjm, null);
    }

    // status dosen
    public function verif_disetujui_dosen($id_msib)
    {
        $data = [
            'status_dosen' => 'disetujui',
        ];
        $this->msib->update($id_msib, $data);
        return redirect()->to('mbkm/msib');
    }

    public function verif_tidak_disetujui_dosen($id_msib)
    {
        $data = [
            'status_dosen' => 'tidak disetujui',
        ];
        $this->msib->update($id_msib, $data);
        return redirect()->to('mbkm/msib');
    }

    public function edit_status_mhs($id)
    {
        $data = [
            'title' => 'Edit Status Mahasiswa',
            'msib' => $this->msib->find($id),
            'validation' => $this->validation,
            'activePage' => 'msib',
            'mahasiswa' => $this->mahasiswa->findAll(),
        ];
        return view('mbkm/msib/edit_status_mhs', $data);
    }

    public function update_status_mhs($id = null)
    {
        $status_mahasiswa = $this->request->getVar('status_mahasiswa');
        $updated_at = round(microtime(true) * 1000);
        $rules = [
            'status_mahasiswa' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi",
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $data1 = [
                'status_mahasiswa' => $status_mahasiswa,
                'updated_at' => $updated_at,
            ];
            $this->msib->update($id, $data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/msib')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diupdate');
        } else {
            return view('mbkm/mbkm_prodi/edit_status_mahasiswa', [
                'title' => 'Edit kegiatan monitoring',
                'msib' => $this->msib->find($id),
                'activePage' => 'msib',
                'validation' => $this->validation,
                'staf' => $this->staf->findAll(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'mbkmFix' => $this->mbkmFix->updateAllMbkm($id_mhs, $nama_instansi),

            ]);
        }
    }
    public function filterMsibAdm($th_masuk)
    {
        $filterMahasiswa = $this->msib->getFilterMsibAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }

    public function filterMsibDosen($th_masuk)
    {
        $filterDosen = $this->msib->getFilterMsibDosen($th_masuk);
        return json_encode($filterDosen);
    }

}