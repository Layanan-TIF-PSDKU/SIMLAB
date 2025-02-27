<?php
namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Models\Simlab\DetailPeminjamanAlatModel;
use App\Models\Simlab\JadwalRuangModel;
use App\Models\Simlab\PeminjamanAlatModel;
use App\Models\Simlab\PeminjamanRuangModel;
use App\Models\Simlab\RuangLaboratoriumModel;
use CodeIgniter\Config\Services;
use Dompdf\Dompdf;
use Myth\Auth\Models\GroupModel;
use Ramsey\Uuid\Uuid;

class PeminjamanController extends BaseController
{

    protected $alat;
    public function __construct()
    {
        $this->alat = new AlatLaboratoriumModel();
        $this->ruanglab = new RuangLaboratoriumModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->UserMahasiswa = new ChatbotUserMahasiswaModel();
        $this->UserStaff = new ChatbotUserStaffModel();
        $this->group = new GroupModel();
        $this->pinjamalat = new PeminjamanAlatModel();
        $this->detailpinjamalat = new DetailPeminjamanAlatModel();
        $this->pinjamruang = new PeminjamanRuangModel();
        $this->jadwal = new JadwalRuangModel();
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Peminjaman',
            'activePage' => 'peminjaman',
        ];
        // dd($data);
        return view('simlab/peminjaman/index', $data);
    }

    public function pengajuan_peminjaman_alat()
    {
        if ($this->group->inGroup('mahasiswa', $this->auth->user()->id)) {

            $data = [
                'title' => 'Pengajuan Peminjaman Alat Laboratorium',
                'alatlab' => $this->alat->getAlatLabBaikStok(),
                'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),
                'validation' => $this->validation,
                'activePage' => 'pengajuan-peminjaman/alat-laboratorium',
            ];
            return view('simlab/peminjaman/pengajuan_peminjaman_alat', $data);
        } else {
            $data = [
                'title' => 'Pengajuan Peminjaman Alat Laboratorium',
                'alatlab' => $this->alat->getAlatLabBaikStok(),
                'staf' => $this->staf->getStafbyUserId(),
                'validation' => $this->validation,
                'activePage' => 'pengajuan-peminjaman/alat-laboratorium',
            ];
            return view('simlab/peminjaman/pengajuan_peminjaman_alat', $data);
        }
    }
    public function pengajuan_peminjaman_alat_simpan()
    {
        $uuid = Uuid::uuid4();
        $id_pinjam_alat = $uuid->toString();
        $id_mahasiswa = $this->request->getVar('id_mahasiswa');
        $id_staff = $this->request->getVar('id_staff');
        $keperluan = $this->request->getVar('keperluan');
        $tanggal_ajuan = round(microtime(true) * 1000);
        $tanggal_pinjam = $this->request->getVar('tanggal_pinjam');
        $tglkembali = $this->request->getVar('tanggal_kembali');
        $makspinjam = strtotime($tanggal_pinjam) + (7 * 24 * 60 * 60);
    
        if (strtotime($tglkembali) > $makspinjam) {
            return redirect()->back()->with('error', 'Maksimal waktu peminjaman adalah 7 hari!');
        }
    
        $tanggal_kembali = round(strtotime($tglkembali) * 1000);
    
        $rules = [
            'id_alat' => [
                'label' => "Nama alat laboratorium",
                'rules' => "required",
                'errors' => ['required' => "{field} harus diisi"],
            ],
            'keperluan' => [
                'label' => "Keperluan peminjaman",
                'rules' => "required",
                'errors' => ['required' => "{field} harus diisi"],
            ],
            'tanggal_pinjam' => [
                'label' => "Tanggal peminjaman",
                'rules' => "required",
                'errors' => ['required' => "{field} harus diisi"],
            ],
            'tanggal_kembali' => [
                'label' => "Tanggal pengembalian",
                'rules' => "required",
                'errors' => ['required' => "{field} harus diisi"],
            ],
        ];
    
        if ($this->validate($rules)) {
            $AlatTidakTersedia = [];
    
            $id_alat = (array) $this->request->getVar('id_alat');
            $jumlah_pinjam = (array) $this->request->getVar('jumlah_pinjam');
    
            for ($i = 0; $i < count($id_alat); $i++) {
                $alatlab = $this->alat->find($id_alat[$i]);
                if ($alatlab) {
                    if ($alatlab->stok >= $jumlah_pinjam[$i]) {
                        $dataDetailPinjam[] = [
                            'id_pinjam_alat' => $id_pinjam_alat,
                            'id_alat' => $id_alat[$i],
                            'jumlah_pinjam' => $jumlah_pinjam[$i],
                        ];
                    } else {
                        $AlatTidakTersedia[] = $alatlab->nama_alat;
                    }
                }
            }
    
            if (empty($AlatTidakTersedia)) {
                $data = [
                    'id_pinjam_alat' => $id_pinjam_alat,
                    'id_mahasiswa' => $id_mahasiswa,
                    'id_staff' => $id_staff,
                    'keperluan' => $keperluan,
                    'tanggal_ajuan' => $tanggal_ajuan,
                    'tanggal_pinjam' => $tanggal_pinjam,
                    'tanggal_kembali' => $tanggal_kembali,
                ];
    
                $this->pinjamalat->insert($data);
                $this->detailpinjamalat->insertBatch($dataDetailPinjam);
    
                session()->setFlashdata('success', 'Berhasil Mengirim Pengajuan Peminjaman Alat Laboratorium!');
                return redirect()->to('simlab/peminjaman/data-peminjaman/alat-laboratorium')
                    ->with('status_icon', 'success')
                    ->with('status_text', 'Data Berhasil ditambah');
            } else {
                return redirect()->back()->with('error', 'Alat tidak tersedia : ' . implode(', ', $AlatTidakTersedia));
            }
        } else {
            $data = [
                'title' => 'Pengajuan Peminjaman Alat Laboratorium',
                'alatlab' => $this->alatlab->getAlatLabBaikStok(),
                'validation' => $this->validation,
                'activePage' => 'pengajuan-peminjaman/alat-laboratorium',
            ];
    
            if ($this->group->inGroup('mahasiswa', $this->auth->user()->id)) {
                $data['mahasiswa'] = $this->mahasiswa->getMahasiswabyUserId();
            } else {
                $data['staf'] = $this->staf->getStafbyUserId();
            }
    
            return view('simlab/peminjaman/pengajuan_peminjaman_alat', $data);
        }
    }
    

    public function pengajuan_peminjaman_ruang()
    {
        if ($this->group->inGroup('mahasiswa', $this->auth->user()->id)) {

            $data = [
                'title' => 'Pengajuan Peminjaman Ruang Laboratorium',
                'ruanglab' => $this->ruanglab->findAll(),
                'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),
                'validation' => $this->validation,
                'activePage' => 'pengajuan-peminjaman/ruang-laboratorium',
            ];
            return view('simlab/peminjaman/pengajuan_peminjaman_ruang', $data);
        } else {
            $data = [
                'title' => 'Pengajuan Peminjaman Ruang Laboratorium',
                'ruanglab' => $this->ruanglab->findAll(),
                'staf' => $this->staf->getStafbyUserId(),
                'validation' => $this->validation,
                'activePage' => 'pengajuan-peminjaman/ruang-laboratorium',
            ];
            return view('simlab/peminjaman/pengajuan_peminjaman_ruang', $data);
        }
    }

    public function pengajuan_peminjaman_ruang_simpan()
    {
        $uuid = Uuid::uuid4();
        $id_pinjam_ruang = $uuid->toString();
        $id_ruang = $this->request->getVar('id_ruang');
        $id_mahasiswa = $this->request->getVar('id_mahasiswa');
        $id_staff = $this->request->getVar('id_staff');
        $keperluan = $this->request->getVar('keperluan');
        $tanggal_ajuan = round(microtime(true) * 1000);
        $hari = $this->request->getVar('hari');
        $tanggal_pinjam = $this->request->getVar('tanggal_pinjam');
        $waktu_mulai = $this->request->getVar('waktu_mulai');
        $waktu_selesai = $this->request->getVar('waktu_selesai');
        $status_peminjaman = '';
        $tahun_ajaran = date('Y', strtotime($tanggal_pinjam)); // Mendapatkan tahun dari tanggal pinjam
        $rules = [
            'id_ruang' => [
                'label' => "Ruang laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'keperluan' => [
                'label' => "Keperluan peminjaman",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'hari' => [
                'label' => "Hari peminjaman",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'tanggal_pinjam' => [
                'label' => "Tanggal peminjaman",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'waktu_mulai' => [
                'label' => "Waktu mulai peminjaman",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'waktu_selesai' => [
                'label' => "Waktu selesai peminjaman",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        $cekKetersediaanRuangByJadwalPraktikum = $this->jadwal->cekKetersediaanRuangByJadwalPraktikum($id_ruang, $hari, $tahun_ajaran, $waktu_mulai, $waktu_selesai);
        if ($cekKetersediaanRuangByJadwalPraktikum > 0) {
            session()->setFlashdata('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
            return redirect()->to('simlab/pengajuan-peminjaman/ruang-laboratorium/')->with('status_icon', 'error');
        }
 
        $cekKetersediaanRuangByPeminjaman = $this->pinjamruang->cekKetersediaanRuangByPeminjaman($id_ruang, $hari, $tanggal_pinjam, $waktu_mulai, $waktu_selesai, $status_peminjaman = 'Sedang Digunakan');
        if ($cekKetersediaanRuangByPeminjaman > 0) {
            session()->setFlashdata('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
            return redirect()->to('simlab/pengajuan-peminjaman/ruang-laboratorium/')->with('status_icon', 'error');
        }


        if ($this->validate($rules)) {
            $data = [
                'id_pinjam_ruang' => $uuid,
                'id_ruang' => $id_ruang,
                'id_mahasiswa' => $id_mahasiswa,
                'id_staff' => $id_staff,
                'keperluan' => $keperluan,
                'tanggal_ajuan' => $tanggal_ajuan,
                'hari' => $hari,
                'tanggal_pinjam' => $tanggal_pinjam,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
            ];

            $this->pinjamruang->insert($data);
            session()->setFlashdata('success', 'Berhasil Mengirim Pengajuan Peminjaman Ruang Laboratorium!');

            // $url = 'http://localhost:8080/bot/api/publish';

            // $laboranRecipient = $this->staf->getLaboran();
            // foreach ($laboranRecipient as $laboran) {
            //     $recipient = $laboran->id_staf;
            //     $pesan = 'Notifikasi : '
            //         . 'Terdapat ajuan peminjaman ruang laboratorium. '
            //         . 'Mohon untuk melakukan konfirmasi permintaan peminjaman tersebut. '
            //         . 'Terima kasih';
            //     $pesan_email = $this->request->getVar('pesan_email') ?? '';
            //     $subject_email = $this->request->getVar('email_subject') ?? '';
            //     $platform = ['telegram'];
            //     $platformdata = array(
            //         'whatsapp' => false,
            //         'telegram' => in_array('telegram', $platform),
            //         'email' => in_array('email', $platform),
            //     );

            //     $datapesan = array(
            //         'receiver' => $recipient,
            //         'message' => $pesan,
            //         'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
            //         'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
            //         'platform' => $platformdata,
            //     );

            //     $jsonData = json_encode($datapesan);

            //     $request = Services::curlrequest();
            //     $response = $request->setBody($jsonData)
            //         ->setHeader('Content-Type', 'application/json')
            //         ->setHeader('x-api-key', '12345678')
            //         ->setHeader('App-auth', 'simlabd3tipsdku001-1')
            //         ->post($url);
            // }
            return redirect()->to('simlab/peminjaman/data-peminjaman/ruang-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            if ($this->group->inGroup('mahasiswa', $this->auth->user()->id)) {

                $data = [
                    'title' => 'Pengajuan Peminjaman Ruang Laboratorium',
                    'ruanglab' => $this->ruanglab->findAll(),
                    'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),
                    'validation' => $this->validation,
                    'activePage' => 'pengajuan-peminjaman/ruang-laboratorium',
                ];
                return view('simlab/peminjaman/pengajuan_peminjaman_ruang', $data);
            } else {
                $data = [
                    'title' => 'Pengajuan Peminjaman Ruang Laboratorium',
                    'ruanglab' => $this->ruanglab->findAll(),
                    'staf' => $this->staf->getStafbyUserId(),
                    'validation' => $this->validation,
                    'activePage' => 'pengajuan-peminjaman/ruang-laboratorium',
                ];
                return view('simlab/peminjaman/pengajuan_peminjaman_ruang', $data);
            }
        }
    }
    
    public function data_peminjaman_alat()
    {
        $data = [
            'title' => 'Data Peminjaman Alat Laboratorium',
            'peminjamanalat' => $this->pinjamalat->getAlatDipinjamById(),
            'activePage' => 'peminjaman/data-peminjaman/alat-laboratorium',
        ];
        return view('simlab/peminjaman/data_peminjaman_alat', $data);

    }
    public function data_peminjaman_ruang()
    {
        $data = [
            'title' => 'Data Peminjaman Ruang Laboratorium',
            'peminjamanruang' => $this->pinjamruang->getRuangDipinjamById(),
            'activePage' => 'peminjaman/data-peminjaman/ruang-laboratorium',
        ];
        return view('simlab/peminjaman/data_peminjaman_ruang', $data);

    }
    public function detail_peminjaman_alat($id)
    {
        $pinjamalat = $this->pinjamalat->getAlatDipinjamForDetail($id);
        $detailpinjamalat = $this->detailpinjamalat->getDetailAlatDipinjam($id);
        $data = array(
            'pinjamalat' => $pinjamalat,
            'detailpinjamalat' => $detailpinjamalat,
        );
        // dd($data);
        return json_encode($data);
    }

    public function detail_peminjaman_ruang($id = null)
    {
        $data = $this->pinjamruang->getRuangDipinjamAll($id);
        return json_encode($data);
    }
    public function riwayat_peminjaman_alat()
    {
        $data = [
            'title' => 'Riwayat Peminjaman Alat Laboratorium',
            'peminjamanalat' => $this->pinjamalat->getAlatDipinjamById(),
            'activePage' => 'peminjaman/riwayat-peminjaman/alat-laboratorium',
        ];
        return view('simlab/peminjaman/riwayat_peminjaman_alat', $data);
    }
    public function riwayat_peminjaman_ruang()
    {
        $data = [
            'title' => 'Riwayat Peminjaman Ruang Laboratorium',
            'peminjamanruang' => $this->pinjamruang->getRuangDipinjamById(),
            'activePage' => 'peminjaman/riwayat-peminjaman/ruang-laboratorium',
        ];
        return view('simlab/peminjaman/riwayat_peminjaman_ruang', $data);
    }

    public function generate_surat_pinjam_alat($id)
    {
        $peminjaman = $this->pinjamalat->getAlatDipinjamForDetail($id);
        $detail_peminjaman_alat = $this->detailpinjamalat->getDetailAlatDipinjam($id);
        $html = view('simlab/peminjaman/surat_peminjaman_alat', [
            'peminjaman' => $peminjaman,
            'detail_peminjaman_alat' => $detail_peminjaman_alat,
        ]);
        $pdf = new Dompdf(array('enable_remote' => true));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream(date('Ymd') . '-Surat Peminjaman Alat Laboratorium.pdf');
    }
    
    public function generate_surat_pinjam_ruang($id)
    {
        $pinjamruang = $this->pinjamruang->getRuangDipinjamAll($id);
        $html = view('simlab/peminjaman/surat_peminjaman_ruang', [
            'pinjamruang' => $pinjamruang,
        ]);
        $pdf = new Dompdf(array('enable_remote' => true));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream(date('Ymd') . '-Surat Peminjaman Ruang Laboratorium.pdf');
    }
}