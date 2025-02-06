<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;
use App\Models\Master\StafModel;
use App\Models\Master\MahasiswaModel;

class BlastChatController extends BaseController
{
    public function __construct()
    {
        $this->UserMahasiswa = new ChatbotUserMahasiswaModel();
        $this->UserStaff = new ChatbotUserStaffModel();
        $this->Staff = new StafModel();
        $this->Mahasiswa = new MahasiswaModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Blast Chat',
        ];
        return view('bot/blast_chat/index', $data);
    }

    public function email()
    {
        $data = [
            'title' => 'Chatbot | Kirim Email',
            'validation' => $this->validation,
        ];
        return view('bot/blast_chat/kirim_email', $data);
    }

    public function kirim_email()
    {
        $url = 'http://localhost:8080/bot/api/sendemail';
        $email = $this->request->getVar('email');
        $pesan_email = $this->request->getVar('pesan_email');
        $subject_email = $this->request->getVar('email_subject');
        $file = $this->request->getFile('lampiran_file');

        $rules = [
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Email harus diisi",
                ],
            ],
            'pesan_email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan Email harus diisi",
                ],
            ],
            'email_subject' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Subject harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)){
            if ($file !== null) {
                if ($file->isValid()) {
                    if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                        $file_nama = $file->getRandomName();
                        $file->move('bot_assets/lampiran/', $file_nama);
                        $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                    }else {
                        return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                    }
                } else {
                    $file_lampiran = "";
                }
            } else {
                $file_lampiran = "";
            }

            $senddata = array(
                'subject' => $subject_email,
                'email' => $email,
                'message'    => $pesan_email,
                'attachment' => $file_lampiran
            );
    
        
            $jsonData = json_encode($senddata);
    
            $request = Services::curlrequest();
            $response = $request->setBody($jsonData)
                ->setHeader('Content-Type', 'application/json')
                ->setHeader('x-api-key', '12345678')
                ->setHeader('App-auth', 'selfchatbotaccess-app')
                ->post($url);
        
            $httpStatus = $response->getStatusCode();
        
    
            if ($httpStatus == 200) {
                $dataresponse = json_decode($response->getBody(), true);
                session()->setFlashdata('success', 'Email Berhasil Dikirim');
                return redirect()->to(base_url('bot/blast_chat'));
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan saat kirim email moh coba lagi');
                return view('bot/blast_chat/kirim_email', [
                    'title' => 'Chatbot | Kirim Email',
                    'validation' => 'Terjadi kesalahan saat kirim email',        
                ]);
            }
        }else{
            return view('bot/blast_chat/kirim_email', [
                'title' => 'Chatbot | Kirim Email',
                'validation' => $this->validation,        
            ]);
        }

    
    }

    public function kirimEmailFromExcel()
    {
        $pesan_email = $this->request->getVar('pesan_email');
        $subject_email = $this->request->getVar('email_subject');
        $file = $this->request->getFile('excel_file');
        $file_lampiran = $this->request->getFile('lampiran_file');
        $url = 'http://localhost:8080/bot/api/sendemail';
        $success = false;

        $rules = [
            'pesan_email' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan Email harus diisi",
                ],
            ],
            'email_subject' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Subject harus diisi",
                ],
            ],
        ];
        if ($this->validate($rules)){

            if ($file_lampiran !== null) {
                if ($file_lampiran->isValid()) {
                    if ($file_lampiran->getExtension() === 'pdf' && $file_lampiran->getSize() <= 5000000) {
                        $file_nama = $file_lampiran->getRandomName();
                        $file_lampiran->move('bot_assets/lampiran/', $file_nama);
                        $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                    }else {
                        return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                    }
                } else {
                    $file_lampiran = "";
                }
            } else {
                $file_lampiran = "";
            }

            $extension = $file->getClientExtension();
            if($extension == 'xlsx' || $extension == 'xls'){
                if($extension == 'xls'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }else{
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
            $spreadsheet = $reader->load($file);
            $dataemail =  $spreadsheet->getActiveSheet()->toArray();
            for ($i=1; $i<count($dataemail); $i++) {
                    $senddata = array(
                        'subject' => $subject_email,
                        'email' => $dataemail[$i][0],
                        'message'    => $pesan_email,
                        'attachment' => $file_lampiran
                    );
            
                    $jsonData = json_encode($senddata);
            
                    $request = Services::curlrequest();
                    $response = $request->setBody($jsonData)
                        ->setHeader('Content-Type', 'application/json')
                        ->setHeader('x-api-key', '12345678')
                        ->setHeader('App-auth', 'selfchatbotaccess-app')
                        ->post($url);
                
                    $success = true;
            }
            if ($success){
                session()->setFlashdata('success', 'Email Blast Berhasil Dikirim');
                return redirect()->to(base_url('bot/blast_chat'));
            }else{
                return redirect()->back()->with('error', 'Terjadi Kesalahan Server Saat Kirim Email');
            }
        } else {
            return redirect()->back()->with('error', 'Format file excel tidak sesuai');
        }
        }else{
            return view('bot/blast_chat/kirim_email', [
                'title' => 'Chatbot | Kirim Email',
                'validation' => $this->validation,        
            ]);
        }

  }

    public function terjadwal($recipient)
    {
        if($recipient=='mahasiswa'){
            $recipient_chat = $this->Mahasiswa->findAll();
            $data = [
                'validation' => $this->validation,
                'identitas' => 'mahasiswa',
                'recipient' => $recipient_chat,
                'title' => 'Chatbot | Kirim Pesan Terjadwal',
            ];
            return view('bot/blast_chat/pesan_terjadwal', $data);
        } elseif($recipient=='staff'){
            $recipient_chat = $this->Staff->findAll();
            $data = [
                'validation' => $this->validation,
                'identitas' => 'staff',
                'recipient' => $recipient_chat,
                'title' => 'Chatbot | Kirim Pesan Terjadwal',
            ];
            return view('bot/blast_chat/pesan_terjadwal', $data);
        }else{
            return $this->index();
        }
    }

    

    public function kirim_terjadwal()
    {
        $url = 'http://localhost:8080/bot/api/publishdelay';
        $recipient = $this->request->getVar('id_recipient');
        $pesan = $this->request->getVar('pesan');
        $pesan_email = $this->request->getVar('pesan_email')?? '';
        $subject_email = $this->request->getVar('email_subject')?? '';
        $platform = $this->request->getVar('platform');
        $tanggal = $this->request->getVar('tanggal[]');
        $time = $this->request->getVar('time[]');
        $file = $this->request->getFile('lampiran_file');


        $rules = [
            'id_recipient' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Penerima harus diisi",
                ],
            ],
            'pesan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan harus diisi",
                ],
            ],
            'platform' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Platform harus diisi",
                ],
            ],
            'tanggal' => [
                'rules' => "required",
                'errors' => [
                    'required' => "tanggal harus diisi",
                ],
            ],
            'time' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jam harus diisi",
                ],
            ],
        ];

        if($this->UserMahasiswa->checkUserBotMahasiswaExists($recipient) || $this->UserStaff->checkUserBotStaffExists($recipient)){
            if ($this->validate($rules)){

                if ($file !== null) {
                    if ($file->isValid()) {
                        if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                            $file_nama = $file->getRandomName();
                            $file->move('bot_assets/lampiran/', $file_nama);
                            $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                        }else {
                            return redirect()->to(base_url('bot/blast_chat/terjadwal/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                        }
                    } else {
                        $file_lampiran = "";
                    }
                } else {
                    $file_lampiran = "";
                }

                //menentukan platform
                $platformdata = array(
                    'whatsapp' => in_array('whatsapp', $platform), //true
                    'telegram' => in_array('telegram', $platform),// false
                    'email'    => in_array('email', $platform) //false
                );
                
                foreach ($tanggal as $index => $tgl) {
                    $waktu = $time[$index];
    
                    // Mengambil Array Jadwal
                    $parts = explode('/', $tgl);
                    $bulan = intval($parts[0]);  // Nilai bulan (misalnya "05")
                    $tgl_value = intval($parts[1]);  // Nilai tanggal (misalnya "19")
                    $tahun = intval($parts[2]);  // Nilai tahun (misalnya "2023")
    
                    $timeArray = explode(':', $waktu);
                    $hour = $timeArray[0]; // Jam
                    $minute = $timeArray[1]; // Menit
    
                    //untuk menentukan waktu pengiriman
                    $timedata = array(
                        'year' => $tahun,
                        'month' => $bulan,
                        'day' => $tgl_value,
                        'hour' => $hour,
                        'minute' => $minute,
                    );
            // isi pesan dan informasi penerima
                $datapesan = array(
                    'receiver' => $recipient,
                    'message' => $pesan,
                    'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                    'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                    'attachment' => $file_lampiran,
                    'platform' => $platformdata,
                    'time' => $timedata
                );
            
                $jsonData = json_encode($datapesan);
        
                $request = Services::curlrequest();
                $response = $request->setBody($jsonData)
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('x-api-key', '12345678')
                    ->setHeader('App-auth', 'selfchatbotaccess-app')
                    ->post($url);
            
                $httpStatus = $response->getStatusCode();
                }
                
                if ($httpStatus == 200) {
                    $dataresponse = json_decode($response->getBody(), true);
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Set Pengiriman Pesan Sesuai Jadwal');
                } else {
                    return redirect()->to(base_url('bot/blast_chat/terjadwal/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Kesalahan saat mengirim pesan, Coba Lagi');
                }
            }else{
                return redirect()->to(base_url('bot/blast_chat/terjadwal/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Kesalahan saat mengirim pesan, Coba Lagi');
            }
    
        }else{
            return redirect()->to(base_url('bot/blast_chat/terjadwal/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Penerima Belum Teregister Di Chatbot');
        }

    }

    public function instan($recipient)
    {
        if($recipient=='mahasiswa'){
            $recipient_chat = $this->Mahasiswa->findAll();
            $data = [
                'validation' => $this->validation,
                'identitas' => 'mahasiswa',
                'recipient' => $recipient_chat,
                'title' => 'Chatbot | Kirim Pesan Instan',
            ];
            return view('bot/blast_chat/pesan_instan', $data);
        } elseif($recipient=='staff'){
            $recipient_chat = $this->Staff->findAll();
            $data = [
                'validation' => $this->validation,
                'identitas' => 'staff',
                'recipient' => $recipient_chat,
                'title' => 'Chatbot | Kirim Pesan Instan',
            ];
            return view('bot/blast_chat/pesan_instan', $data);
        }else{
            return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan');
        }

    }

    public function kirim_instan()
    {
        $url = 'http://localhost:8080/bot/api/publish';
        $recipient = $this->request->getVar('id_recipient');
        $pesan = $this->request->getVar('pesan');
        $pesan_email = $this->request->getVar('pesan_email')?? '';
        $subject_email = $this->request->getVar('email_subject')?? '';
        $platform = $this->request->getVar('platform');
        $file = $this->request->getFile('lampiran_file');
        

        $rules = [
            'id_recipient' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Penerima harus diisi",
                ],
            ],
            'pesan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan harus diisi",
                ],
            ],
            'platform' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Platform harus diisi",
                ],
            ],
            // 'lampiran_file' => [
            //     'rules' => "uploaded[file]|ext_in[file,pdf]|max_size[file,5120]",
            //     'errors' => [
            //         'uploaded' => 'File harus diupload',
            //         'ext_in' => 'File berupa pdf',
			// 		'max_size' => 'Size maks 5 MB',
            //     ]
            // ],
        ];

        if($this->UserMahasiswa->checkUserBotMahasiswaExists($recipient) || $this->UserStaff->checkUserBotStaffExists($recipient)){
            
            if ($this->validate($rules)){

                if ($file !== null) {
                    if ($file->isValid()) {
                        if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                            $file_nama = $file->getRandomName();
                            $file->move('bot_assets/lampiran/', $file_nama);
                            $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                        }else {
                            return redirect()->to(base_url('bot/blast_chat/instan/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                        }
                    } else {
                        $file_lampiran = "";
                    }
                } else {
                    $file_lampiran = "";
                }

                $platformdata = array(
                    'whatsapp' => in_array('whatsapp', $platform),
                    'telegram' => in_array('telegram', $platform),
                    'email'    => in_array('email', $platform)
                );
            
                $datapesan = array(
                    'receiver' => $recipient,
                    'message' => $pesan,
                    'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                    'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                    'attachment' => $file_lampiran,
                    'platform' => $platformdata
                );
            
                $jsonData = json_encode($datapesan);
        
                $request = Services::curlrequest();
                $response = $request->setBody($jsonData)
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('x-api-key', '12345678')
                    ->setHeader('App-auth', 'selfchatbotaccess-app')
                    ->post($url);
            
                $httpStatus = $response->getStatusCode();
            
                if ($httpStatus == 200) {
                    $dataresponse = json_decode($response->getBody(), true);
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Mengirim Pesan');
                } else {
                    return redirect()->to(base_url('bot/blast_chat/instan/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan, Coba Lagi');
                }
            }else{
                return redirect()->to(base_url('bot/blast_chat/instan/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan, Coba Lagi');
            }
    
        }else{
            return redirect()->to(base_url('bot/blast_chat/instan/pilih_penerima'))->with('status_icon', 'error')->with('status_text', 'Penerima Belum Teregister Di Chatbot');
        }


 
    }

    public function kirim_broadcast()
    {
        $url = 'http://localhost:8080/bot/api/publish';
        $recipient = $this->request->getVar('penerima');
        $pesan = $this->request->getVar('pesan');
        $pesan_email = $this->request->getVar('pesan_email')?? '';
        $subject_email = $this->request->getVar('email_subject')?? '';
        $platform = $this->request->getVar('platform');
        $file = $this->request->getFile('lampiran_file');
        $success = false;

        $rules = [
            'penerima' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Penerima harus diisi",
                ],
            ],
            'pesan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan harus diisi",
                ],
            ],
            'platform' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Platform harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)){
            if ($file !== null) {
                if ($file->isValid()) {
                    if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                        $file_nama = $file->getRandomName();
                        $file->move('bot_assets/lampiran/', $file_nama);
                        $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                    }else {
                        return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                    }
                } else {
                    $file_lampiran = "";
                }
            } else {
                $file_lampiran = "";
            }

            if ($recipient=='mahasiswa'){
                $penerima = $this->UserMahasiswa->findAll();
                
                $platformdata = array(
                    'whatsapp' => in_array('whatsapp', $platform),
                    'telegram' => in_array('telegram', $platform),
                    'email'    => in_array('email', $platform)
                );
                foreach ($penerima as $p){
                $datapesan = array(
                    'receiver' => $p->id_mahasiswa,
                    'message' => $pesan,
                    'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                    'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                    'attachment' => $file_lampiran,
                    'platform' => $platformdata
                );
            
                $jsonData = json_encode($datapesan);
        
                $request = Services::curlrequest();
                $response = $request->setBody($jsonData)
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('x-api-key', '12345678')
                    ->setHeader('App-auth', 'selfchatbotaccess-app')
                    ->post($url);
    
                    $success = true;
                }
            
                if ($success == true) {
                    $dataresponse = json_decode($response->getBody(), true);
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Mengirim Pesan');
                } else {
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan');
                }
            }elseif($recipient=='staff'){
                $penerima = $this->UserStaff->findAll();
                $platformdata = array(
                    'whatsapp' => in_array('whatsapp', $platform),
                    'telegram' => in_array('telegram', $platform),
                    'email'    => in_array('email', $platform)
                );
                foreach ($penerima as $p){
                $datapesan = array(
                    'receiver' => $p->id_staff,
                    'message' => $pesan,
                    'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                    'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                    'attachment' => $file_lampiran,
                    'platform' => $platformdata
                );
            
                $jsonData = json_encode($datapesan);
        
                $request = Services::curlrequest();
                $response = $request->setBody($jsonData)
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('x-api-key', '12345678')
                    ->setHeader('App-auth', 'selfchatbotaccess-app')
                    ->post($url);
    
                    $success = true;
                }
                if ($success == true) {
                    $dataresponse = json_decode($response->getBody(), true);
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Mengirim Pesan');
                } else {
                    return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan');
                }
            }else{
                return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan');
            }
    
        }else{
            return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan Cek Kembali Data Yang Di Masukkan');
        }

 
    }

    public function kirim_broadcast_spesifik()
    {
        $url = 'http://localhost:8080/bot/api/publish';
        $recipient = $this->request->getVar('penerima');
        $pesan = $this->request->getVar('pesan');
        $pesan_email = $this->request->getVar('pesan_email')?? '';
        $subject_email = $this->request->getVar('email_subject')?? '';
        $platform = $this->request->getVar('platform');
        $angkatan = $this->request->getVar('angkatan')?? '';
        $kelas = $this->request->getVar('kelas')?? '';
        $file = $this->request->getFile('lampiran_file');
        $success = false;

        $rules = [
            'pesan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Pesan harus diisi",
                ],
            ],
            'platform' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Platform harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)){
            $platformdata = array(
                'whatsapp' => in_array('whatsapp', $platform),
                'telegram' => in_array('telegram', $platform),
                'email'    => in_array('email', $platform)
            );

            if ($file !== null) {
                if ($file->isValid()) {
                    if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                        $file_nama = $file->getRandomName();
                        $file->move('bot_assets/lampiran/', $file_nama);
                        $file_lampiran = "https://d3ti.myfin.id/bot_assets/lampiran/" . $file_nama;
                    }else {
                        return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                    }
                } else {
                    $file_lampiran = "";
                }
            } else {
                $file_lampiran = "";
            }

            if ($angkatan != "" && $kelas != ""){
                //Kiirm pesan ke angkatan dan kelas
                $penerima =  $this->UserMahasiswa->findUserAngkatanKelas($angkatan, $kelas);
                if($penerima === []){
                    return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Penerima Tidak Tersedia');
                }
                foreach ($penerima as $p){
                    $datapesan = array(
                        'receiver' => $p->id_mahasiswa,
                        'message' => $pesan,
                        'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                        'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                        'attachment' => $file_lampiran,
                        'platform' => $platformdata
                    );
                
                    $jsonData = json_encode($datapesan);
            
                    $request = Services::curlrequest();
                    $response = $request->setBody($jsonData)
                        ->setHeader('Content-Type', 'application/json')
                        ->setHeader('x-api-key', '12345678')
                        ->setHeader('App-auth', 'selfchatbotaccess-app')
                        ->post($url);
        
                        $success = true;
                    }
                    if ($success == true) {
                        $dataresponse = json_decode($response->getBody(), true);
                        return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Mengirim Pesan');
                    } else {
                        return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan, Coba Lagi');
                    }
            }elseif($angkatan != "" && $kelas === ""){
                //Kirim satu angkatan
                $penerima =  $this->UserMahasiswa->findUserAngkatan($angkatan);
                if($penerima === []){
                    return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Penerima Tidak Tersedia');
                }
                foreach ($penerima as $p){
                    $datapesan = array(
                        'receiver' => $p->id_mahasiswa,
                        'message' => $pesan,
                        'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                        'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
                        'attachment' => $file_lampiran,
                        'platform' => $platformdata
                    );
                
                    $jsonData = json_encode($datapesan);
            
                    $request = Services::curlrequest();
                    $response = $request->setBody($jsonData)
                        ->setHeader('Content-Type', 'application/json')
                        ->setHeader('x-api-key', '12345678')
                        ->setHeader('App-auth', 'selfchatbotaccess-app')
                        ->post($url);
        
                        $success = true;
                    }
                    if ($success == true) {
                        $dataresponse = json_decode($response->getBody(), true);
                        return redirect()->to(base_url('bot/blast_chat'))->with('status_icon', 'success')->with('status_text', 'Berhasil Mengirim Pesan');
                    } else {
                        session()->setFlashdata('error', 'Terjadi Kesalahan Saat Megirim Pesan | Satu Angkatan');
                        return view('bot/blast_chat/index', [
                            'title' => 'Blast Chat',
                            'validation' => 'Terjadi Kesalahan',        
                        ]);
                    }
            }else{
                //Tidak Valid
                return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Tidak valid | Terjadi Kesalahan Saat Megirim Pesan Cek Kembali Data Yang Di Masukkan');
            }

        }else{
            return redirect()->to(base_url('bot/blast_chat/broadcast'))->with('status_icon', 'error')->with('status_text', 'Terjadi Kesalahan Saat Megirim Pesan Cek Kembali Data Yang Di Masukkan');
            // session()->setFlashdata('error', 'Terjadi Kesalahan Saat Megirim Pesan Cek Kembali Data Yang Di Masukkan');
            // return view('bot/blast_chat/broadcast', [
            //     'title' => 'Blast Chat',
            //     'validation' => $this->validation,        
            // ]);
        }
    }

    public function broadcast()
    {
        $data = [
            'title' => 'Chatbot | Kirim Pesan Broadcast',
        ];
        return view('bot/blast_chat/pilih_penerima_broadcast', $data);
    }

    public function broadcast_semua()
    {
        $data = [
            'title' => 'Chatbot | Kirim Pesan Broadcast',
        ];
        return view('bot/blast_chat/pesan_broadcast', $data);
    }

    public function broadcast_spesifik()
    {
        $angkatan = $this->Mahasiswa->getAngkatanMahasiswa();
        $kelas = $this->Mahasiswa->getUniqueKelas();
        $data = [
            'kelas' => $kelas,
            'angkatan' => $angkatan,
            'title' => 'Chatbot | Kirim Pesan Broadcast',
        ];
        return view('bot/blast_chat/pesan_broadcast_spesifik', $data);
    }

    public function pilih_penerima_instan()
    {
        $data = [
            'title' => 'Chatbot | Pilih Penerima',
        ];
        return view('bot/blast_chat/pilih_penerima_instan', $data);
    }


    public function pilih_penerima_terjadwal()
    {
        $data = [
            'title' => 'Chatbot | Pilih Penerima',
        ];
        return view('bot/blast_chat/pilih_penerima_terjadwal', $data);
    }

    public function download_format_blast_email()
    {
        $name = 'data-email.xlsx';
        return $this->response->download('bot_assets/' . $name, null);
    }
}
