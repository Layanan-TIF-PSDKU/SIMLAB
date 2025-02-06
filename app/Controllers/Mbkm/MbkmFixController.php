<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MitraModel;
use App\Models\Master\StafModel;
use App\Models\Mbkm\HibahModel;
use App\Models\Mbkm\MbkmFixModel;
use App\Models\Mbkm\MbkmProdiModel;
use App\Models\Mbkm\MsibModel;
use App\Models\Mbkm\TotalNilaiUtsModel;
use App\Models\Mbkm\TotalNilaiUasModel;
use App\Models\Mbkm\NilaiKonversiModel;
use Ramsey\Uuid\Uuid;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MbkmFixController extends BaseController
{
    public function __construct()
    {
        $this->mbkmFix = new MbkmFixModel();
        $this->mbkmMsib = new MsibModel();
        $this->mbkmHibah = new HibahModel();
        $this->mbkmProdi = new MbkmProdiModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->mitra = new MitraModel();
        $this->totalUts = new TotalNilaiUtsModel();
        $this->totalUas = new TotalNilaiUasModel();
        $this->konv = new NilaiKonversiModel();
        $this->validation = \Config\Services::validation();
        $this->spreadsheet = new Spreadsheet();

    }
    public function index()
    {
        $this->mbkmFix->getMbkmFixByMhs2();
        $data = [
            'title' => 'MBKM yang berjalan',
            'mbkmFix' => $this->mbkmFix->findAll(),
            'mbkmFix2' => $this->mbkmFix->getMbkmFixByMhs(),
            'mbkmFix4' => $this->mbkmFix->getMbkmFixByMhs2(),
            'mbkmFix3' => $this->mbkmFix->getMbkmFixByDosen(),
            'mbkmFix5' => $this->mbkmFix->getMbkmFixByDosen2(),
            'mbkmFix6' => $this->mbkmFix->getMbkmFixByMhsMonitoring(), // userby mahasiswa untuk monitoring

            // 'mbkmFix6' => $this->mbkmFix->getMbkmFixByDosenMonitoring(),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'mitra' => $this->mitra->findAll(),
            'activePage' => 'mbkmFix',
            'validation' => $this->validation,

        ];

        return view('mbkm/mbkm_fix/index', $data);
    }

    public function edit($id_mbkm_fix)
    {
        $data = [
            'title' => 'Edit Data MBKM',
            'validation' => $this->validation,
            'activePage' => 'mbkmFix',
            'mbkmFix' => $this->mbkmFix->find($id_mbkm_fix),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
            'staf' => $this->staf->findAll(),
            'mitra' => $this->mitra->findAll(),
        ];
        return view('mbkm/mbkm_fix/edit', $data);
    }

    public function update($id_mbkm_fix)
    {
        $id_mhs = $this->request->getVar('id_mhs');
        $id_staf = $this->request->getVar('id_staf');
        $id_mitra = $this->request->getVar('id_mitra');
        $lap_akhir = $this->request->getFile('lap_akhir');
        $lap_akhirName = $lap_akhir->getRandomName();

        $bukti = $this->request->getFile('bukti');
        $buktiName = $bukti->getRandomName();

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
            'id_mitra' => [
                'label' => "tanggal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'bukti' => [
                'rules' => "ext_in[bukti,pdf]|max_size[bukti,2048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
            'lap_akhir' => [
                'rules' => "ext_in[lap_akhir,pdf]|max_size[lap_akhir,2048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $bkt = $this->mbkmFix->find($id_mbkm_fix);
            $old_bkt = $bkt->bukti;
            
            if ($bukti->isValid() && !$bukti->hasMoved()) 
            {
                if (file_exists('mbkm_assets/mbkmFix-bukti/' . $old_bkt)) {
                    unlink('mbkm_assets/mbkmFix-bukti/' . $old_bkt);
                }
                $buktiName = $bukti->getRandomName();
                $bukti->move('mbkm_assets/mbkmFix-bukti/', $buktiName);
            } else {
                $buktiName = $bkt->bukti;
            }
            
            $lap = $this->mbkmFix->find($id_mbkm_fix);
            $old_lap = $lap->lap_akhir;
            
            if ($lap_akhir->isValid() && !$lap_akhir->hasMoved()) 
            {
                if (file_exists('mbkm_assets/mbkmFix-lap_akhir/' . $old_lap)) {
                    unlink('mbkm_assets/mbkmFix-lap_akhir/' . $old_lap);
                }
                $lap_akhirName = $lap_akhir->getRandomName();
                $lap_akhir->move('mbkm_assets/mbkmFix-lap_akhir/', $lap_akhirName);
            } else {
                $lap_akhirName = $lap->lap_akhir;
            }
            
            $data = [
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'id_mitra' => $id_mitra,
                'bukti' => $buktiName,
                'lap_akhir' => $lap_akhirName,
            ];
            $this->mbkmFix->update($id_mbkm_fix, $data);
            // $lap_akhir->move('mbkm_assets/mmbkmFix-LapAkhir/', $lap_akhirName);
            // $bukti->move('mbkm_assets/mmbkmFix-bukti/', $buktiName);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('mbkm/mbkmFix')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diubah');
        } else {
            return view('mbkm/mbkm_fix/edit', [
                'title' => 'Upload Laporan Akhir',
                'validation' => $this->validation,
                'mbkmFix' => $this->mbkmFix->find($id_mbkm_fix),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'mitra' => $this->mitra->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }
    }
    
    public function hapus($id_mbkm_fix)
    {
        $this->mbkmFix->delete($id_mbkm_fix);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('mbkm/mbkmFix');
    }


    
    // UPDATE MITRA
    public function update_mitra($id)
    {
        $id_mitra = $this->request->getVar('id_mitra');
        $rules = [
            'id_mitra' => [
                'label' => "mitra",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_mitra' => $id_mitra,
            ];
            $this->mbkmFix->update($id, $data);
            session()->setFlashdata('success', 'Mitra berhasil diupdate');
            return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Mitra Berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Format file tidak sesuai');
        }
    }
    
    // UPLOAD LOA/BUKTI
    public function proses_upload_bukti($id_mbkm_fix)
    {   
        
        // $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $bukti = $this->request->getFile('bukti');
        $buktiName = $bukti->getRandomName();
        $rules = [
            'bukti' => [
                'rules' => "ext_in[bukti,pdf]|max_size[bukti,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
       
        if ($this->validate($rules)) {
            $data = [
                'bukti' => $buktiName,
            ];
            $this->mbkmFix->update($id_mbkm_fix, $data);
            $bukti->move('mbkm_assets/mbkmFix-bukti/', $buktiName);
            
            $data2 = [
                'id_total_uts' => Uuid::uuid4()->toString(),
                'id_mbkm_fix' => $id_mbkm_fix,
            ];
            $this->totalUts->insert($data2);
            $data3 = [
                'id_total_uas' => Uuid::uuid4()->toString(),
                'id_mbkm_fix' => $id_mbkm_fix,
            ];
            $this->totalUas->insert($data3);
            $data4 = [
                'id_nilai_konversi' => Uuid::uuid4()->toString(),
                'id_mbkm_fix' => $id_mbkm_fix,
            ];
            $this->konv->insert($data4);
                        
            session()->setFlashdata('success', 'Bukti berhasil diupload');
            return redirect()->to('mbkm/mbkmFix')->with('status', 'Bukti berhasil diupload');
        } else {
            return view('mbkm/mbkmFix');
        }
    }

    // UPLOAD LAPORAN AKHIR
    public function proses_upload_lap($id_mbkm_fix)
    {   
        
        // $id_mbkm_fix = $this->request->getVar('id_mbkm_fix');
        $lap_akhir = $this->request->getFile('lap_akhir');
        
        $lap_akhirName = $lap_akhir->getRandomName();
        $rules = [
            'lap_akhir' => [
                'rules' => "ext_in[lap_akhir,pdf]|max_size[lap_akhir,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
       
        if ($this->validate($rules)) {
            $data = [
                'lap_akhir' => $lap_akhirName,
            ];
            $this->mbkmFix->update($id_mbkm_fix, $data);
            $lap_akhir->move('mbkm_assets/mbkmFix-LapAkhir/', $lap_akhirName);
            session()->setFlashdata('success', 'Laporan Akhir berhasil diupload');
            return redirect()->to('mbkm/mbkmFix')->with('status', 'Laporan Akhir berhasil diupload');
        } else {
            return view('mbkm/mbkm_hibah/edit', [
                'title' => 'Upload Laporan Akhir',
                'validation' => $this->validation,
                'hibah' => $this->hibah->find($id_mbkm_fix),
                'mhs' => $this->mahasiswa->getMahasiswabyUserId(),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'staf' => $this->staf->findAll(),
            ]);
        }

    }

    public function download_bukti($id)
    {
        $mbkmFix = $this->mbkmFix->find($id);
        return $this->response->download('mbkm_assets/mbkmFix-bukti/' . $mbkmFix->bukti, null);
    }
    public function download_lap_akhir($id)
    {
        $mbkmFix = $this->mbkmFix->find($id);
        return $this->response->download('mbkm_assets/mbkmFix-LapAkhir/' . $mbkmFix->lap_akhir, null);
    }

    public function detail($id_mbkm_fix)
    {
        $data = [
            'title' => 'Detail Kegiatan MBKM Aktif',
            'mbkmFix' => $this->mbkmFix->getDetail($id_mbkm_fix),
            'mahasiswa' => $this->mahasiswa->findAll(),
            // 'mhs' => $this->mahasiswa->getAngkatanMahasiswa(),
            'staf' => $this->staf->findAll(),
            'activePage' => 'mbkmFix',
        ];
        return view('mbkm/mbkm_fix/detail', $data);
    }
    
    /* 
    PROSES INSERT UPDATE MBKM PRODI
    */
    public function update_insert($id_mhs)
    {
        $uuid = Uuid::uuid4();
        // data yang akan diinsert ke table mbkm_fix
        $id_mbkm_fix = $uuid->toString();
        $id_staf = $this->request->getVar('id_staf');
        $id_mprodi = $this->request->getVar('id_mprodi');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $status_mahasiswa = $this->request->getVar('status_mahasiswa');
        $jenis_mbkm = $this->request->getVar('jenis_mbkm');
        // logic jika status diambil dan dilakukan komparasi pada nama_instansi dan jenis_mbkm
        if ($status_mahasiswa == 'diambil') {
            $this->mbkmMsib->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmHibah->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmProdi->mbkmProdigetMbkmFixProdiDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa);
            $this->mbkmProdi->mbkmProdigetMbkmFixProdiTidakDiambil($id_mprodi,$id_mhs);
            $data = [
                'id_mbkm_fix' => $id_mbkm_fix,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'jenis_mbkm' => $jenis_mbkm,
                'nama_instansi' => $nama_instansi,
                'status_mahasiswa' => $status_mahasiswa,

            ];
            $this->mbkmFix->insert($data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/mbkmProdi')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diupdate');
            
            // selain status "diambil" akan melakukan insert biasa 
        } else {
            $this->mbkmMsib->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmHibah->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmProdi->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/mbkmProdi')->with('status_icon', 'success')->with('status_text', 'Status berhasil diupdate');
        }
    }
    /* 
    PROSES INSERT UPDATE MBKM MSIB
    */
    public function update_insert_msib($id_mhs)
    {
        $uuid = Uuid::uuid4();
        $id_mbkm_fix = $uuid->toString();
        $id_staf = $this->request->getVar('id_staf');
        $id_msib = $this->request->getVar('id_msib');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $status_mahasiswa = $this->request->getVar('status_mahasiswa');
        $jenis_mbkm = $this->request->getVar('jenis_mbkm');
        // logic jika status diambil dan dilakukan komparasi pada nama_instansi dan jenis_mbkm
        if ($status_mahasiswa == 'diambil') {
            $this->mbkmProdi->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmHibah->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmMsib->mbkmMsibgetMbkmFixMsibDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa);
            $this->mbkmMsib->mbkmMsibgetMbkmFixMsibTidakDiambil($id_msib, $id_mhs);

            $data = [
                'id_mbkm_fix' => $id_mbkm_fix,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'jenis_mbkm' => $jenis_mbkm,
                'nama_instansi' => $nama_instansi,
                'status_mahasiswa' => $status_mahasiswa,

            ];

            $this->mbkmFix->insert($data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/msib')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diupdate');
        } else {
            // selain status "diambil" akan melakukan insert biasa 
            $this->mbkmMsib->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmHibah->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmProdi->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/msib')->with('status_icon', 'success')->with('status_text', 'Status berhasil diupdate');
        }
    }
    /* 
    PROSES INSERT UPDATE MBKM MSIB
    */
    public function update_insert_hibah($id_mhs)
    {
        $uuid = Uuid::uuid4();
        $id_mbkm_fix = $uuid->toString();
        $id_staf = $this->request->getVar('id_staf');
        $id_hibah = $this->request->getVar('id_hibah');
        $nama_instansi = $this->request->getVar('nama_instansi');
        $status_mahasiswa = $this->request->getVar('status_mahasiswa');
        $jenis_mbkm = $this->request->getVar('jenis_mbkm');
        // logic jika status diambil dan dilakukan komparasi pada nama_instansi dan jenis_mbkm
        if ($status_mahasiswa == 'diambil') {
            $this->mbkmProdi->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmMsib->where(['id_mhs' => $id_mhs, 'jenis_mbkm !=' => $jenis_mbkm, 'nama_instansi !=' => $nama_instansi])->set('status_mahasiswa', 'tidak diambil')->update();
            $this->mbkmHibah->mbkmHibahgetMbkmFixHibahDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa);
            $this->mbkmHibah->mbkmHibahgetMbkmFixHibahTidakDiambil($id_hibah,$id_mhs);

            $data = [
                'id_mbkm_fix' => $id_mbkm_fix,
                'id_mhs' => $id_mhs,
                'id_staf' => $id_staf,
                'jenis_mbkm' => $jenis_mbkm,
                'nama_instansi' => $nama_instansi,
                'status_mahasiswa' => $status_mahasiswa,

            ];

            $this->mbkmFix->insert($data);
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/hibah')->with('status_icon', 'success')->with('status_text', 'Status Berhasil diupdate');
        } else {
            // selain status "diambil" akan melakukan insert biasa 
            $this->mbkmMsib->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmHibah->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            $this->mbkmProdi->where(['id_mhs' => $id_mhs, 'id_staf' => $id_staf, 'jenis_mbkm' => $jenis_mbkm, 'nama_instansi' => $nama_instansi])->set('status_mahasiswa', $status_mahasiswa)->update();
            session()->setFlashdata('success', 'Status berhasil diupdate');
            return redirect()->to('mbkm/hibah')->with('status_icon', 'success')->with('status_text', 'Status berhasil diupdate');
        }
    }
    
    public function filterAdm($th_masuk)
    {
        $filterMahasiswa = $this->mbkmFix->getFilterAdm($th_masuk);
        return json_encode($filterMahasiswa);
    }
    
    public function filterDosen($th_masuk)
    {
        $filterDosen = $this->mbkmFix->getFilterDsn($th_masuk);
        return json_encode($filterDosen);
    }

    public function cetak_pdf($th_masuk)
    {
        $data = [
            'mbkm' => $this->mbkmFix->getFilterAdm($th_masuk),
        ];
        // dd($data);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('mbkm/mbkm_fix/export_pdf', $data);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Data-MBKM-Aktif-' . $th_masuk . '.pdf');
    }

    public function cetak_excel($th_masuk)
    {
        $mbkm = $this->mbkmFix->getFilterAdm($th_masuk);
        // $mbkm = $this->totalUts->getFilterDataNilai($th_masuk);
        $sheet = $this->spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Mahasiswa');
        $sheet->setCellValue('C1', 'Dosen Pembimbing');
        $sheet->setCellValue('D1', 'Instansi');
        $sheet->setCellValue('E1', 'NIM');
        $sheet->setCellValue('F1', 'kelas');
        $sheet->setCellValue('G1', 'Jenis MBKM');
        // $sheet->setCellValue('F1', 'Total Nilai Dosen');
        // $sheet->setCellValue('G1', 'Total Nilai Mitra');
        // $sheet->setCellValue('H1', 'Nilai UTS');
        
        $no = 1;
        $baris = 2;

        foreach ($mbkm as $k) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $k->nm_mhs);
            $sheet->setCellValue('C' . $baris, $k->nm_staf);
            $sheet->setCellValue('D' . $baris, $k->nm_mitra);
            $sheet->setCellValue('E' . $baris, $k->nim);
            $sheet->setCellValue('F' . $baris, $k->kelas);
            $sheet->setCellValue('G' . $baris, $k->jenis_mbkm);
            
            $no++;
            $baris++;
        }

        $filename = 'data-mbkm-aktif-'.$th_masuk;

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $kriter = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $kriter->save('php://output');
        exit();
    }

}