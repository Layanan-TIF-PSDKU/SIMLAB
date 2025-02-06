<?php

namespace App\Controllers;
use App\Models\Sipema\RekomendasiMahasiswaModel;
use App\Models\Sipema\HasilPemetaanKeterampilanModel;
use App\Models\Mbkm\BerkasModel;
use App\Models\Kmm\BerkasModel as BerkasKmmModel;
use App\Models\Simta\BerkasTAModel;
use App\Models\Simta\TaTerdahuluModel;
use App\Models\Simta\BobotPenilaianModel;
use App\Models\Simta\PenilaianAkhirModel;
use App\Models\Simta\PengajuanJudulModel;
use App\Models\Simta\SeminarHasilModel;
use App\Models\Simta\UjianTAModel;
use App\Models\Simta\UjianProposalModel;
use Myth\Auth\Models\GroupModel;
use App\Models\Master\StafModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\MitraModel;
use App\Models\Master\MataKuliahModel;
use App\Models\Tracer\AgendaModel;
use Myth\Auth\Models\PermissionModel;
use Myth\Auth\Models\UserModel;
use App\Controllers\BaseController;
use Myth\Auth\Password;

class DashboardController extends BaseController
{
    public function __construct()
    {
        $this->rekomendasi_mahasiswa = new RekomendasiMahasiswaModel();
        $this->group = new GroupModel();
        $this->permission = new PermissionModel();
        $this->users = new UserModel();
        $this->hasil_pemetaan_keterampilan = new HasilPemetaanKeterampilanModel();
        $this->berkas = new BerkasModel(); //berkas mbkm
        $this->berkas1 = new BerkasTAModel();
        $this->taterdahulu = new TaTerdahuluModel();
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->penilaianakhir = new PenilaianAkhirModel();
        $this->pengajuanjudul = new PengajuanJudulModel();
        $this->ujianproposal = new UjianProposalModel();
        $this->seminarhasil = new SeminarHasilModel();
        $this->ujianta = new UjianTAModel();
        $this->berkas2 = new BerkasKmmModel();
        $this->staf = new StafModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->mitra = new MitraModel();
        $this->mata_kuliah = new MataKuliahModel();
        $this->agenda = new AgendaModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard | Sistem Terintegrasi D3 TI',
            'activePage' => 'dashboard'
        ];
        return view('dashboard', $data);
    }

    public function profil()
    {
        $data = [
            'title' => 'Profil | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'activePage' => 'profil'
        ];
        return view('master/profil', $data);
    }
    
    /* Fungsi untuk menampilkan halaman admin */
    public function admin()
    {
        $data = [
            'title' => 'Admin | Sistem Informasi Prodi D3 TI Madiun',
            'activePage' => 'dashboard',
            'jumlah_staf' => $this->staf->countAll(),
            'jumlah_mahasiswa' => $this->mahasiswa->countAll(),
            'jumlah_mitra' => $this->mitra->countAll(),
            'jumlah_mata_kuliah' => $this->mata_kuliah->countAll(),
        ];
        return view('master/admin_dashboard', $data);
    }
    
    public function mitra()
    {
        $data = [
            'title' => 'Mitra | Sistem Informasi Prodi D3 TI Madiun',
            'activePage' => 'dashboard',
        ];
        return view('mitra/mitra_dashboard', $data);
    }

    public function sipema()
    {
        /* Memunculkan data grafik berdasarkan mahasiswa yang sedang login*/
        if ($this->group->inGroup('mahasiswa', $this->auth->user()->id)) {
            $rekomendasi_sub_bidang = $this->rekomendasi_mahasiswa->getRekomendasiMahasiswaById($this->auth->user()->id);
            $results = $this->hasil_pemetaan_keterampilan->getChartDataByUsersLogin($this->auth->user()->id);
            
            $data2 = [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => 'Nilai Akhir',
                        'data' => [],
                        'backgroundColor' => []
                    ]
                ]
            ];

            foreach ($results as $result) {
                array_push($data2['labels'], $result->nama_bidang . ' - ' . $result->nama_sub_bidang);
                array_push($data2['datasets'][0]['data'], $result->nilai_akhir);
                array_push($data2['datasets'][0]['backgroundColor'], 'rgba(54, 162, 235, 0.2)');
            }

            $dataChart = $this->hasil_pemetaan_keterampilan->getChartDataByUsersLogin($this->auth->user()->id);

            $namaMahasiswa = '';
            $nilaiTertinggi = '';

            $no = 1;

            $tableHtml = '';

            foreach ($dataChart as $dpm) {
                $tableHtml .= '<tr>';
                $tableHtml .= '<td>' . $no++ . '</td>';
                $tableHtml .= '<td>' . $dpm->nama_bidang . '</td>';
                $tableHtml .= '<td>' . $dpm->nama_sub_bidang . '</td>';
                $tableHtml .= '<td>' . $dpm->nilai_akhir . '</td>';
                $tableHtml .= '</tr>';

                if ($dpm->nilai_akhir > $nilaiTertinggi) {
                    $nilaiTertinggi = $dpm->nilai_akhir;
                    $namaMahasiswa = $dpm->nama_mahasiswa;
                }
            }

            $keteranganHtml = '<h6 class="mt-2">Keterangan nilai dari :</h6>';
            $keteranganHtml .= '<span id="namaMahasiswa">' . $namaMahasiswa . '</span>';
            $keteranganHtml .= '<p>Nilai Tertinggi: <span id="nilaiTertinggi">' . $nilaiTertinggi . '</span></p>';

            $hasilDataChart = array(
                'tableHtml' => $tableHtml,
                'keteranganHtml' => $keteranganHtml
            );

            return view('sipema/sipema_dashboard', ['data2' => $data2, 'hasilDataChart' => $hasilDataChart, 'rekomendasi_sub_bidang' => $rekomendasi_sub_bidang]);
        /* Memunculkan data grafik untuk dosen, dan pimppinan */
        } else {
            $data = [
                'title' => 'SIPEMA | Sistem Informasi Prodi D3 TI Madiun',
                'activePage' => 'dashboard',
                'grafik' => $this->rekomendasi_mahasiswa->getCountPerSubBidang()
            ];
            
            $data['labels1'] = array_column($data['grafik'], 'label');
            $data['data1'] = array_column($data['grafik'], 'data');
            
            $backgroundColor = [];
            $borderColor = [];
            
            foreach ($data['grafik'] as $grafik) {
                $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                array_push($backgroundColor, $randomColor);
                array_push($borderColor, $randomColor);
            }
            
            $data['backgroundColor'] = $backgroundColor;
            $data['borderColor'] = $borderColor;            
    
            $results = $this->hasil_pemetaan_keterampilan->getAllChartData();
        
            $data2 = [
                'labels' => [],
                'datasets' => [
                    [
                        'label' => 'Nilai Akhir',
                        'data' => [],
                        'backgroundColor' => [],
                        'borderColor' => [],
                    ]
                ]
            ];

            function randomColor() {
                $letters = '0123456789ABCDEF';
                $color = '#';
                for ($i = 0; $i < 6; $i++) {
                  $color .= $letters[rand(0, 15)];
                }
                return $color;
            }
            
            foreach ($results as $result) {
                array_push($data2['labels'], $result->nama_sub_bidang);
                array_push($data2['datasets'][0]['data'], $result->nilai_akhir);
                array_push($data2['datasets'][0]['backgroundColor'], randomColor());
                array_push($data2['datasets'][0]['borderColor'], randomColor());
            }
            
            return view('sipema/sipema_dashboard', ['data2' => $data2, 'data' => $data]);
        }
    }

    public function simlab()
    {
        $data = [
            'title' => 'SIMLAB | Sistem Informasi Prodi D3 TI Madiun',
            'activePage' => 'dashboard'
        ];
        return view('simlab/simlab_dashboard', $data);
    }
    
    public function simkmm()
    {
        $data = [
            'title' => 'SIMKMM | Sistem Informasi Prodi D3 TI Madiun',
            'activePage' => 'dashboard',
            'berkas'=> $this->berkas2->findAll(),
        ];
        return view('kmm/kmm_dashboard', $data);
    }
    public function mbkm()
    {
        $data = [
            'title' => 'MBKM | Sistem Informasi Prodi D3 TI Madiun',
            'berkasPendaftaran' => $this->berkas->getBerkasPendaftaran(),
            'berkasInfo' => $this->berkas->getBerkasInformasi(),
            'activePage' => 'dashboard'
        ];
        return view('mbkm/mbkm_dashboard', $data);
    }
    public function download_berkas_mbkm($id)
    {
        $berkas = $this->berkas->find($id);       
        return $this->response->download('mbkm_assets/berkas/' . $berkas->file_berkas, null);
    }
    public function simta()
    {
        $data = [
            'title' => 'TA | Sistem Informasi Prodi D3 TI Madiun',
            'berkas' => $this->berkas1->findAll(),
            'jumlah_berkas' => $this->berkas1->countAll(),
            'jumlah_taterdahulu' => $this->taterdahulu->countAll(),
            'jumlah_bobotpenilaian' => $this->bobotpenilaian->countAll(),
            'jumlah_penilaianakhir' => $this->penilaianakhir->countAll(),
            'jumlah_pengajuanjudul' => $this->pengajuanjudul->countPengajuanJudul(),
            'jumlah_ujianproposal' => $this->ujianproposal->countUjianProposal(),
            'jumlah_seminarhasil' => $this->seminarhasil->countSeminarHasil(),
            'jumlah_ujianta' => $this->ujianta->countUjianTA(),
            'activePage' => 'dashboard'
        ];
        return view('simta/simta_dashboard', $data);
    }
    public function download_berkas_simta($id_berkas)
    {
        $berkas = $this->berkas->find($id_berkas);       
        return $this->response->download('simta_assets/berkas/' . $berkas->file_berkas, null);
    }

    public function tracer()
    {
        $data = [
            'title' => 'TRACER | Sistem Informasi Prodi D3 TI Madiun',
            'agenda' => $this->agenda->findAll(),
            'activePage' => 'dashboard'
        ];
        return view('tracer/tracer_dashboard', $data);
    }

    public function bot()
    {
        $data = [
            'title' => 'Chatbot | Sistem Informasi Prodi D3 TI Madiun',
            'activePage' => 'dashboard'
        ];
        return view('bot/dashboard_chatbot', $data);
    }

    public function update_profil($id){        
        $email = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        
        $rules = [
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                ]
            ],
            'username' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Username harus diisi",
                ]
            ],
            'old_password' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Password harus diisi",
                ]
            ],
            'new_password' => [
                'rules' => "required|strong_password",
                'errors' => [
                    'required' => "Password harus diisi",
                ]
            ],
            'confirm_new_password' => [
                'rules' => "required|matches[new_password]",
                'errors' => [
                    'required' => "Password harus diisi",
                    'matches' => "Password tidak cocok",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            if(Password::verify($old_password, $password)){
                if($old_password == $konfirmasi_pencocokan_password){
                    session()->setFlashdata('error', 'Password tidak boleh sama');
                    return redirect()->to('user/ubah-password/'. $id);
                } else{
                    $data = [
                        'id' => $id,
                        'email' => $email,
                        'username' => $username,
                        'password_hash' => $password_hash,
                    ];
                    $this->users->save($data);
                    session()->setFlashdata('success', 'Data Profil Berhasil diupdate');
                    return redirect()->to('profil');             
                }
            } else {
                session()->setFlashdata('error', 'Data Profil Gagal diubah');
                return redirect()->to('master/profil'. $id);
            } 
        } else {
            return view('master/profil', [
                'title' => 'Ubah Password',
                'validation' => $this->validation,
            ]);
        }
    }
}