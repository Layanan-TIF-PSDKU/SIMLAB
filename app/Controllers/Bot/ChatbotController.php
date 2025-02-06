<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;
use App\Models\Bot\ChatbotRegisterModel;
use App\Models\Bot\MahasiswaForBotModel;
use App\Models\Bot\StafForBotModel;

class ChatbotController extends BaseController
{
    public function __construct()
    {
        $this->UserMahasiswa = new ChatbotUserMahasiswaModel();
        $this->UserStaff = new ChatbotUserStaffModel();
        $this->Register = new ChatbotRegisterModel();
        $this->Stafmodel = new StafForBotModel();
        $this->Mahasiswamodel = new MahasiswaForBotModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Register Chatbot',
        ];
        return view('bot/register_chatbot/register', $data);
    }

    public function akses_chatbot()
    {
        $email = $this->user()->email;
        if ($this->UserMahasiswa->checkUserMahasiswaExists($email)) {
            $data_user = $this->UserMahasiswa->GetUserMahasiswa($email);
            $nama = $this->UserMahasiswa->findNamaMahasiswa($email);
            $data = [
                'nama' => $nama,
                'data_user' => $data_user,
                'title' => 'Akses Chatbot',
            ];
            return view('bot/akses_chatbot/akses_chatbot', $data);
        } else if ($this->UserStaff->checkUserStaffExists($email)){
            $data_user = $this->UserStaff->GetUserStaf($email);
            $nama = $this->UserStaff->findNamaStaf($email);
            $data = [
                'nama' => $nama,
                'data_user' => $data_user,
                'title' => 'Akses Chatbot',
            ];
            return view('bot/akses_chatbot/akses_chatbot', $data);
        }else{
            return $this->register();
        }
    }

    public function register()
    {
        $email = $this->user()->email;
        $id = $this->user()->id_user;
        if ($this->UserMahasiswa->checkUserMahasiswaExists($email)) {
            $data = [
                'title' => 'Chatbot',
            ];
            return view('bot/register_chatbot/registered', $data);
        } else if ($this->UserStaff->checkUserStaffExists($email)){
            $data = [
                'title' => 'Chatbot',
            ];
            return view('bot/register_chatbot/registered', $data);
        } else if ($this->Register->checkRegisStatus($email)){
            $pesan_aktivasi = $this->Register->GetPesanAktivasi($email);
            $data = [
                'title' => 'Register Chatbot',
                'pesan_aktivasi' => $pesan_aktivasi
            ];
            return view('bot/register_chatbot/aktivasi', $data);
        }else{
            if ($this->Mahasiswamodel->checkMahasiswaExists()){
                $nama = $this->Mahasiswamodel->getNamaMhs();
                $data = [
                    'nama' => $nama,
                    'title' => 'Register Chatbot',
                ];
                return view('bot/register_chatbot/register', $data);
            } else{
                $nama = $this->Stafmodel->getNamaStaf();
                $data = [
                    'nama' => $nama,
                    'title' => 'Register Chatbot',
                ];
                return view('bot/register_chatbot/register', $data);
            }

        }
    }

    public function aktivasi()
    {

        $data = [
            'title' => 'Register Chatbot',
        ];
        return view('bot/register_chatbot/aktivasi', $data);
    }

    public function update_nomor_wa($id_user_bot)
    {
        $email = $this->user()->email;
        $whatsapp = $this->request->getVar('whatsapp');

        $rules = [
            'whatsapp' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                ],
            ],
        ];
        if ($this->validate($rules)){
            if ($this->UserMahasiswa->checkUserMahasiswaExists($email)) {
                $data = [
                    'no_wa' => $whatsapp,
                ];
                $this->UserMahasiswa->update($id_user_bot, $data);
                session()->setFlashdata('success', 'Berhasil Mengubah Nomor Whatsapp');
                return redirect()->back();
            } else {
                $data = [
                    'no_wa' => $whatsapp,
                ];
                $this->UserStaff->update($id_user_bot, $data);
                session()->setFlashdata('success', 'Berhasil Mengubah Nomor Whatsapp');
                return redirect()->back();
            }
        }else{
            session()->setFlashdata('error', 'Gagal Mengubah Nomor Whatsapp');
            return redirect()->back();
        }   

    }

    public function status_notifikasi($id_user_bot)
    {
        $status_notification = $this->request->getVar('status_notification');
        $data = [
            'status_notification' => $status_notification,
        ];
        $this->UserStaff->updateStatus($id_user_bot, $data);
        session()->setFlashdata('success', 'Berhasil Mengubah Status Notifikasi');
        return redirect()->back();
    }

    public function submit_register()
    {

        $url = 'http://localhost:8080/bot/api/registerbot'; // Ganti dengan URL API yang sesuai
        $email = $this->request->getVar('email');
        $nama = $this->request->getVar('nama');
        $nomor = $this->request->getVar('no_wa');

        $rules = [
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                ],
            ],
            'nama' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama harus diisi",
                ],
            ],
            'no_wa' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nomor harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)){
            $data = array(
                'email' => $email,
                'nama_lengkap' => $nama,
                'no_hp' => $nomor,
            );
        
            $jsonData = json_encode($data);
        
            $request = Services::curlrequest();
            $response = $request->setBody($jsonData)
                ->setHeader('Content-Type', 'application/json')
                ->setHeader('x-api-key', '12345678')
                ->post($url);
        
            $httpStatus = $response->getStatusCode();
        
            if ($httpStatus == 200) {
                $dataresponse = json_decode($response->getBody(), true);
                $pesan_aktivasi = $this->Register->GetPesanAktivasi($email);
                $data = [
                    'title' => 'Register Chatbot',
                    'pesan_aktivasi' => $pesan_aktivasi
                ];
                return view('bot/register_chatbot/aktivasi', $data);
            } else {
                session()->setFlashdata('error', 'Terjadi Kesalahan, Coba Lagi');
                return view('bot', [
                    'title' => 'Chatbot | Sistem Informasi Prodi D3 TI PSDKU',
                    'validation' => 'Terjadi Kesalahan',        
                ]);
            }
        }else{
            session()->setFlashdata('error', 'Terjadi Kesalahan, Coba Lagi');
            return view('bot', [
                'title' => 'Chatbot | Sistem Informasi Prodi D3 TI PSDKU',
                'validation' => 'Terjadi Kesalahan',        
            ]);
        }

    }
}
