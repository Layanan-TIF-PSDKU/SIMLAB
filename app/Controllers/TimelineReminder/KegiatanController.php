<?php

namespace App\Controllers\TimelineReminder;

use DateTime;
use DateTimeZone;
use DateInterval;
use App\Controllers\BaseController;
use CodeIgniter\Config\Services;
use App\Models\TimelineReminder\KegiatanModel;
use App\Models\TimelineReminder\NotificationModel;
use App\Models\TimelineReminder\DokumenModel;
use App\Models\Master\StafModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class KegiatanController extends BaseController
{
    public function __construct()
    {
        $this->Kegiatan = new KegiatanModel();
        $this->Notifikasi = new NotificationModel();
        $this->Staf = new StafModel();
        $this->DokumenKegiatan = new DokumenModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Agenda',
            'kegiatan' => $this->Kegiatan->findAllWithPenanggungJawab(),
        ];
        return view('timelinereminder/agenda/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Kegiatan Prodi',
            'staf' => $this->Staf->findAll(),
            'validation' => $this->validation,
        ];
        return view('timelinereminder/agenda/tambah', $data);
    }

    public function edit_kegiatan($id_kegiatan)
    {
        $kegiatan = $this->Kegiatan->findAllWithPenanggungJawabID($id_kegiatan);
        $epochMillis = $kegiatan->waktu_kegiatan; // Contoh nilai epoch dalam millisecond
        $timestamp = $epochMillis / 1000; // Konversi epoch dari millisecond ke detik
        $tanggal = date('m/d/Y', $timestamp); // Format tanggal (misalnya: 05/23/2023)
        $pukul = date('H:i', $timestamp); // Format jam (misalnya: 08:00)
        $data = [
            'title' => 'Edit Kegiatan Prodi',
            'staf' => $this->Staf->findAll(),
            'kegiatan' => $kegiatan,
            'tanggal' => $tanggal,
            'pukul' => $pukul,
            'validation' => $this->validation,
        ];
        return view('timelinereminder/agenda/edit', $data);
    }

    public function simpan_edit_kegiatan($id_kegiatan)
    {
        $nama_kegiatan = $this->request->getVar('nama_kegiatan');
        $deskripsi_kegiatan = $this->request->getVar('deskripsi_kegiatan');
        $pic = $this->request->getVar('id_staf');
        $tanggal_kegiatan = $this->request->getVar('tanggal_kegiatan');
        $pukul_kegiatan = $this->request->getVar('time');
        $tanggal_waktu = $tanggal_kegiatan . ' ' . $pukul_kegiatan;
        $timestamp = strtotime($tanggal_waktu);
        $epoch_milis = $timestamp * 1000;

        $rules = [
            'nama_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'deskripsi_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'id_staf' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'tanggal_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'time' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_kegiatan' => $id_kegiatan,
                'nama_kegiatan' => $nama_kegiatan,
                'deskripsi_kegiatan' => $deskripsi_kegiatan,
                'pic' => $pic,
                'waktu_kegiatan' => $epoch_milis
            ];
            $this->Kegiatan->update($id_kegiatan, $data);
            return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'success')->with('status_text', 'Berhasil Di Update Kegiatan');
        } else {
            return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'error')->with('status_text', 'Gagal Update Kegiatan, Coba Kembali');
        }
    }

    public function notifikasi($id_kegiatan)
    {
        $data = [
            'title' => 'Agenda | Notifikasi Kegiatan',
            'kegiatan' => $this->Kegiatan->findAllWithPenanggungJawabID($id_kegiatan),
            'notification' => $this->Notifikasi->findNotification($id_kegiatan),
        ];
        return view('timelinereminder/agenda/notification', $data);
    }

    public function notifikasi_edit($id_kegiatan, $id)
    {
        $data = [
            'title' => 'Agenda | Edit Notifikasi Kegiatan',
            'kegiatan' => $this->Kegiatan->findAllWithPenanggungJawabID($id_kegiatan),
            'notification' => $this->Notifikasi->findNotificationByID($id),
        ];
        return view('timelinereminder/agenda/notification_edit', $data);
    }

    public function simpan_notifikasi_edit($id_kegiatan, $id)
    {
        $message = $this->request->getVar('pesan');
        $subject_email = $this->request->getVar('email_subject');
        $pesan_email = $this->request->getVar('pesan_email');
        $status_notifikasi = $this->request->getVar('status_notifikasi');
        $rules = [
            'pesan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'pesan_email' => [
                'label' => "Pesan Email",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'email_subject' => [
                'label' => "Subject Email",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'status_notifikasi' => [
                'label' => "Status Notifikasi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $data = [
                'pesan' => $message,
                'subject_emal' => $subject_email,
                'pesan_email' => $pesan_email,
                'status_notification' => $status_notifikasi
            ];
            $this->Notifikasi->update($id, $data);
            return redirect()->to('timelinereminder/agenda/notifikasi/' . $id_kegiatan)->with('status_icon', 'success')->with('status_text', 'Notifikasi Berhasil Di Update');
        } else {
            return redirect()->to('timelinereminder/agenda/notifikasi/' . $id_kegiatan)->with('status_icon', 'error')->with('status_text', 'Notifikasi Gagal Di Update Periksa Kembali Data Yang Anda Masukkan');
        }
    }

    public function kirim_notifikasi($id_kegiatan)
    {
        $url = 'http://localhost:8080/bot/api/publishdelay';
        $recipient = $this->request->getVar('penerima');
        $pesan = $this->request->getVar('pesan');
        $pesan_email = $this->request->getVar('pesan_email')?? '';
        $subject_email = $this->request->getVar('email_subject')?? '';
        $platform = $this->request->getVar('platform');
        $tanggal = $this->request->getVar('tanggal');
        $time = $this->request->getVar('time');

        $parts = explode('/', $tanggal);
        $bulan = intval($parts[0]);  // Nilai bulan (misalnya "05")
        $tanggal = intval($parts[1]);  // Nilai tanggal (misalnya "19")
        $tahun = intval($parts[2]);  // Nilai tahun (misalnya "2023")

        $timeArray = explode(':', $time);
        $hour = $timeArray[0]; // Jam
        $minute = $timeArray[1]; // Menit

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
            if ($this->validate($rules)){
                $platformdata = array(
                    'whatsapp' => in_array('whatsapp', $platform),
                    'telegram' => in_array('telegram', $platform),
                    'email'    => in_array('email', $platform)
                );
        
                $timedata = array(
                    'year' => $tahun,
                    'month' => $bulan,
                    'day'    => $tanggal,
                    'hour'    => $hour,
                    'minute'    => $minute,
                );
            
                $datapesan = array(
                    'receiver' => $recipient,
                    'message' => $pesan,
                    'id_kegiatan' => $id_kegiatan,
                    'email_subject' => ($subject_email !== '') ? $subject_email : 'default',
                    'email_message' => ($pesan_email !== '') ? $pesan_email : 'default',
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
            
                if ($httpStatus == 200) {
                    $dataresponse = json_decode($response->getBody(), true);
                    return redirect()->to(base_url('timelinereminder/agenda/notifikasi/'. $id_kegiatan))->with('status_icon', 'success')->with('status_text', 'Berhasil Set Pengiriman Pesan Sesuai Jadwal');
                } else {
                    session()->setFlashdata('error', 'Kesalahan saat membuat notifikasi, Coba lagi');
                    return redirect()->to(base_url('timelinereminder/agenda/detail/'. $id_kegiatan, ));
                }
            }else{
                session()->setFlashdata('error', 'Kesalahan saat membuat notifikasi, Coba lagi');
                return redirect()->to(base_url('timelinereminder/agenda/detail/'. $id_kegiatan, ));
            }
    }

    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_kegiatan = $uuid->toString();
        $nama_kegiatan = $this->request->getVar('nama_kegiatan');
        $deskripsi_kegiatan = $this->request->getVar('deskripsi_kegiatan');
        $pic = $this->request->getVar('id_staf');
        $tanggal_kegiatan = $this->request->getVar('tanggal_kegiatan');
        $pukul_kegiatan = $this->request->getVar('time');
        $tanggal_waktu = $tanggal_kegiatan . ' ' . $pukul_kegiatan;
        $timestamp = strtotime($tanggal_waktu);
        $epoch_milis = $timestamp * 1000;
        $parts = explode('/', $tanggal_kegiatan);
        $bulan = intval($parts[0]);  // Nilai bulan (misalnya "05")
        $tanggal = intval($parts[1]);  // Nilai tanggal (misalnya "19")
        $tahun = intval($parts[2]);  // Nilai tahun (misalnya "2023")
        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = date('Y-m-d H:i:s');
        $tanggal_now = date('d');
        $bulan_now = date('m');
        $tahun_now = date('Y');

        $rules = [
            'nama_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'deskripsi_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'id_staf' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'tanggal_kegiatan' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'time' => [
                'label' => "Pesan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_kegiatan' => $id_kegiatan,
                'nama_kegiatan' => $nama_kegiatan,
                'deskripsi_kegiatan' => $deskripsi_kegiatan,
                'pic' => $pic,
                'waktu_kegiatan' => $epoch_milis
            ];
            $this->Kegiatan->insert($data);

            $tanggal_pengingat = 1;
            $bulan_pengingat = 1;
            $tahun_pengingat = null;
    
            if ($tahun > $tahun_now || ($tahun == $tahun_now && $bulan > $bulan_now)) {
                $bulan_pengingat = (ceil($bulan / 3) - 1) * 3 + 1;
                $tahun_pengingat = $tahun;
            } elseif ($bulan <= $bulan_now) {
                $bulan_pengingat = (ceil($bulan_now / 3) - 1) * 3 + 1;
                $tahun_pengingat = $tahun_now;
            }

            //return redirect()->to('timelinereminder/agenda/auto-reminder/'.$id_kegiatan. '/'.$pic. '/'.$tanggal_pengingat. '/'.$bulan_pengingat. '/'.$tahun_pengingat);
           return $this->autoReminder($tanggal, $bulan, $tahun, $pukul_kegiatan, $id_kegiatan, $pic, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
        } else {
            return redirect()->to('timelinereminder/agenda')->with('status_icon', 'error')->with('status_text', 'Gagal Menambahkan Kegiatan, Silakan Coba Lagi');
        }
    }

    public function autoReminder($tanggal, $bulan, $tahun, $pukul, $id_kegiatan, $pic, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat){
        $kegiatan = $this->Kegiatan->where('id_kegiatan', $id_kegiatan)->get()->getRow();
        $namaBulan = $this->getNamaBulan(intval($bulan));
        $message = "Yth. PIC Kegiatan "
        . $kegiatan->nama_kegiatan . " Mengingatkan bahwa ada kegiatan tersebut Pada :" .
            "\nTanggal: " . $tanggal . " " . $namaBulan . " " . $tahun .
            "\nPukul: " . $pukul .
            "\nDeskripsi: " . $kegiatan->deskripsi_kegiatan;
        $url = 'http://localhost:8080/bot/api/publishdelay';

        $platformdata = array(
            'whatsapp' => false,
            'telegram' => true,
            'email' => false
        );

        $timedata = array(
            'year' => $tahun_pengingat,
            'month' => $bulan_pengingat,
            'day' => $tanggal_pengingat,
            'hour' => '8',
            'minute' => '30',
        );

        $datapesan = array(
            'receiver' => $pic,
            'message' => $message,
            'id_kegiatan' => $id_kegiatan,
            'email_subject' => 'Pengingat Kegiatan',
            'email_message' => $message,
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
        if ($httpStatus == 200) {
            session()->setFlashdata('info', 'Anda bisa menambahkan dokumen kegiatan di tombol Tambah Dokumen');
            return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'success')->with('status_text', 'Berhasil Menambahkan Kegiatan, Anda bisa menambahkan dokumen kegiatan');
        } else {
            return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'error')->with('status_text', 'Notifikasi Gagal Dibuat, Tambahkan secara manual!');
        }
    }

    public function automateReminder($id_kegiatan)
    {
        $kegiatan = $this->Kegiatan->where('id_kegiatan', $id_kegiatan)->get()->getRow();
    
        if ($kegiatan) {
            date_default_timezone_set('Asia/Jakarta');
            $tanggal_now = date('d');
            $bulan_now = date('m');
            $tahun_now = date('Y');
            
            $dateWIB = $kegiatan->waktu_kegiatan / 1000; // Menggunakan timezone default yang sudah diatur sebelumnya
            
            $dateTime = new DateTime("@$dateWIB"); // Membuat objek DateTime berdasarkan epoch time
            $dateTime->setTimezone(new DateTimeZone('Asia/Jakarta')); // Mengatur zona waktu ke WIB
            
            $tahun = $dateTime->format('Y');
            $bulan = $dateTime->format('m');
            $tanggal = $dateTime->format('d');
            $hour = $dateTime->format('H');
            $minute = $dateTime->format('i');
    
            $tanggal_pengingat = 1;
            $bulan_pengingat = 1;
            $tahun_pengingat = null;
    
            if ($tahun > $tahun_now || ($tahun == $tahun_now && $bulan > $bulan_now)) {
                $bulan_pengingat = (ceil($bulan / 3) - 1) * 3 + 1;
                $tahun_pengingat = 2024;
            } elseif ($bulan <= $bulan_now) {
                $bulan_pengingat = (ceil($bulan_now / 3) - 1) * 3 + 1;
                $tahun_pengingat = $tahun_now;
            }
    
            $namaBulan = $this->getNamaBulan(intval($bulan));
            $message = "Yth. PIC Kegiatan "
            . $kegiatan->nama_kegiatan . " Mengingatkan bahwa ada kegiatan tersebut Pada :" ;
                "\nTanggal: " . $tanggal . " " . $namaBulan . " " . $tahun .
                "\nPukul: " . $hour . "." . $minute . " WIB" .
                "\nDeskripsi: " . $kegiatan->deskripsi_kegiatan;
            $url = 'http://localhost:8080/bot/api/publishdelay';
    
            $platformdata = array(
                'whatsapp' => false,
                'telegram' => true,
                'email' => true
            );
    
            $timedata = array(
                'year' => $tahun_pengingat,
                'month' => $bulan_pengingat,
                'day' => $tanggal_pengingat,
                'hour' => '8',
                'minute' => '15',
            );
    
            $datapesan = array(
                'receiver' => $kegiatan->pic,
                'message' => $message,
                'id_kegiatan' => $kegiatan->id_kegiatan,
                'email_subject' => 'Pengingat Kegiatan',
                'email_message' => $message,
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
            if ($httpStatus == 200) {
                session()->setFlashdata('info', 'Anda bisa menambahkan dokumen kegiatan di tombol Tambah Dokumen');
                return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'success')->with('status_text', 'Berhasil Menambahkan Kegiatan, Anda bisa menambahkan dokumen kegiatan');
            } else {
                return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'error')->with('status_text', 'Notifikasi Gagal Dibuat, Tambahkan secara manual!');
            }
        }else{
        return redirect()->to('timelinereminder/agenda/detail/' . $id_kegiatan)->with('status_icon', 'error')->with('status_text', 'Notifikasi Gagal Dibuat, Tambahkan secara manual!');
        }
    }

//     public function generatePengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal_kegiatan, $jam_kegiatan)
// {
//     $parts = explode('/', $tanggal_kegiatan);
//     $bulan = intval($parts[0]);  // Nilai bulan (misalnya "05")
//     $tanggal = intval($parts[1]);  // Nilai tanggal (misalnya "19")
//     $tahun = intval($parts[2]);  // Nilai tahun (misalnya "2023")

//     // Mendapatkan waktu sekarang dengan zona waktu WIB
//     date_default_timezone_set('Asia/Jakarta');
//     $waktu_sekarang = date('Y-m-d H:i:s');
//     $tanggal_now = date('d');
//     $bulan_now = date('m');
//     $tahun_now = date('Y');

//     $triwulan = ceil($bulan / 3);

//     // Menghitung pengingat berdasarkan triwulan
//     $tanggal_pengingat = 1;
//     $bulan_pengingat = ($triwulan - 1) * 3 + 1;
//     $tahun_pengingat = $tahun;

//     // Pengecekan jika tanggal kegiatan tepat pada tanggal pengingat
//     if ($bulan == $bulan_pengingat && $tanggal == $tanggal_pengingat) {
//         // Mengurangi satu bulan dari bulan pengingat
//         $bulan_pengingat = $bulan_pengingat - 1;
//         if ($bulan_pengingat < 1) {
//             $bulan_pengingat = 12;
//             $tahun_pengingat--;
//         }
//         $tanggal_pengingat = 2;
//     }

//     $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
// }

    // public function generatePengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal_kegiatan, $jam_kegiatan)
    // {
    //     $parts = explode('/', $tanggal_kegiatan);
    //     $bulan = intval($parts[0]);  // Nilai bulan (misalnya "05")
    //     $tanggal = intval($parts[1]);  // Nilai tanggal (misalnya "19")
    //     $tahun = intval($parts[2]);  // Nilai tahun (misalnya "2023")

    // // Mendapatkan waktu sekarang dengan zona waktu WIB
    // date_default_timezone_set('Asia/Jakarta');
    // $waktu_sekarang = date('Y-m-d H:i:s');
    // $tanggal_now = date('d');
    // $bulan_now = date('m');
    // $tahun_now = date('Y');


    //     if ($tahun > $tahun_now){
    //         //Pengingat Triwulan
    //         if($bulan > 1 && $bulan <= 3){
    //             //set 1 januari
    //             $tanggal_pengingat = 1;
    //             $bulan_pengingat = 1;
    //             $tahun_pengingat = $tahun;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //         }
    //         elseif ($bulan >= 4 && $bulan <= 6){
    //             //set 1-04 pukul 08.15
    //             $tanggal_pengingat = 1;
    //             $bulan_pengingat = 4;
    //             $tahun_pengingat = $tahun;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //         }
    //         elseif ($bulan >= 7 && $bulan <= 9){
    //             //set 1-07 pukul 08.15
    //             $tanggal_pengingat = 1;
    //             $bulan_pengingat = 7;
    //             $tahun_pengingat = $tahun;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //         }
    //         elseif ($bulan >= 10 && $bulan <= 12){
    //             //set 1-10 pukul 08.15
    //             $tanggal_pengingat = 1;
    //             $bulan_pengingat = 10;
    //             $tahun_pengingat = $tahun;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //         } elseif($bulan == 1){
    //             //pengingat di bulan 12
    //             $tanggal_pengingat = $tanggal;
    //             $bulan_pengingat = 11;
    //             $tahun_pengingat = $tahun - 1;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //         }
    //     }elseif ($tahun == $tahun_now){
    //         if(($bulan >= 2 && $bulan <= 3)){
    //             if($bulan == 1){
    //                 // set $tanggal + 1
    //                 $tanggal_pengingat = $tanggal + 1;
    //                 $bulan_pengingat = $bulan;
    //                 $tahun_pengingat = $tahun;
    //                 $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }else{
    //             //set 1-01 januari pukul 08.15
    //             $tanggal_pengingat = 1;
    //             $bulan_pengingat = 1;
    //             $tahun_pengingat = $tahun;
    //             $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }

    //         }
    //         elseif (($bulan >= 5 && $bulan <= 6)){
    //             if($bulan == 4){
    //                 // set $tanggal + 1
    //                 $tanggal_pengingat = $tanggal + 1;
    //                 $bulan_pengingat = $bulan;
    //                 $tahun_pengingat = $tahun;
    //                 $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }else{
    //               //set 1-04 pukul 08.15
    //               $tanggal_pengingat = 1;
    //               $bulan_pengingat = 4;
    //               $tahun_pengingat = $tahun;
    //               $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }
    //         }
    //         elseif (($bulan >= 8 && $bulan <= 9)){
    //             if($bulan == 7){
    //                 // set $tanggal + 1
    //                 $tanggal_pengingat = $tanggal + 1;
    //                 $bulan_pengingat = $bulan;
    //                 $tahun_pengingat = $tahun;
    //                 $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }else{
    //              //set 1-07 pukul 08.15
    //              $tanggal_pengingat = 1;
    //              $bulan_pengingat = 7;
    //              $tahun_pengingat = $tahun;
    //              $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }
    //         }
    //         elseif (($bulan >= 11 && $bulan <= 12)){
    //             if($bulan == 7){
    //                 // set $tanggal + 1
    //                 $tanggal_pengingat = $tanggal + 1;
    //                 $bulan_pengingat = $bulan;
    //                 $tahun_pengingat = $tahun;
    //                 $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }else{
    //              //set 1-10 pukul 08.15
    //              $tanggal_pengingat = 1;
    //              $bulan_pengingat = 10;
    //              $tahun_pengingat = $tahun;
    //              $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
    //             }
    //         } 
    //     }
    // }

    public function generatePengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $epochTime, $jam_kegiatan)
{

    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    $tanggal_now = date('d');
    $bulan_now = date('m');
    $tahun_now = date('Y');

    // Konversi epoch time menjadi waktu dalam format WIB
    $date = date('Y-m-d H:i:s', $epochTime / 1000); // Bagi dengan 1000 untuk mengubah dari milisecond menjadi second
    $dateWIB = strtotime($date . ' +7 hours'); // Menambahkan 7 jam untuk mengonversi ke WIB

    // Mendapatkan tahun, bulan, dan tanggal dari waktu dalam format WIB
    $tahun = date('Y', $dateWIB);
    $bulan = date('m', $dateWIB);
    $tanggal = date('d', $dateWIB);

    $tanggal_pengingat = 1;
    $bulan_pengingat = 1;
    $tahun_pengingat = $tahun;

    if ($tahun > $tahun_now || ($tahun == $tahun_now && $bulan > $bulan_now)) {
        $bulan_pengingat = (ceil($bulan / 3) - 1) * 3 + 1;
    } elseif ($bulan <= $bulan_now) {
        $bulan_pengingat = (ceil($bulan_now / 3) - 1) * 3 + 1;
        $tahun_pengingat = $tahun_now;
    }
    $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
}

    private function requestPengingat1bulan($bulan_now,$pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan){
            //Pengingat 1 bulan sebelum
            if($bulan > $bulan_now){
                //set pengingat 1 bulan sebelum
                $tanggal_pengingat = $tanggal;
                $bulan_pengingat = $bulan - 1;
                $tahun_pengingat = $tahun;
                $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
            }else{
                //set pengingat tanggal + 1
                $tanggal_pengingat = $tanggal + 1;
                $bulan_pengingat = $bulan;
                $tahun_pengingat = $tahun;
                $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat);
            }
    }

    private function requestPengingat2week($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan){

            // Mengubah tanggal, bulan, dan tahun menjadi format tanggal PHP
            $tanggal_php = sprintf("%04d-%02d-%02d", $tahun, $bulan, $tanggal);
            // Mengurangi 2 minggu dari tanggal
            $interval = new DateInterval('P2W');
            $tanggal_obj = new DateTime($tanggal_php);
            $tanggal_obj->sub($interval);

            // Mendapatkan tanggal, bulan, dan tahun baru setelah dikurangi 2 minggu
            $tanggal_baru = $tanggal_obj->format('d');
            $bulan_baru = $tanggal_obj->format('m');
            $tahun_baru = $tanggal_obj->format('Y');
            $this->requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal, $bulan, $tahun, $jam_kegiatan, $tanggal_baru, $bulan_baru, $tahun_baru);
    }

    private function requestPengingat($pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan, $tanggal_kegiatan, $bulan_kegiatan, $tahun_kegiatan, $jam_kegiatan, $tanggal_pengingat, $bulan_pengingat, $tahun_pengingat){
        $namaBulan = $this->getNamaBulan(intval($bulan_kegiatan));
        $message = "Yth. PIC Kegiatan $nama_kegiatan Mengingatkan bahwa ada kegiatan tersebut Pada :";
        $message .= "\nTanggal: $tanggal_kegiatan - $namaBulan - $tahun_kegiatan";
        $message .= "\nPukul: $jam_kegiatan";
        $message .= "\nDeskripsi: $deskripsi_kegiatan";
        
        $url = 'http://localhost:8080/bot/api/publishdelay';
        // Kirim Notifikasi di semua platform
        $platformdata = array(
            'whatsapp' => true,
            'telegram' => true,
            'email'    => true
        );
    
        $timedata = array(
            'year' => $tahun_pengingat,
            'month' => $bulan_pengingat,
            'day'    => $tanggal_pengingat,
            'hour'    => '8',
            'minute'    => '15',
        );
    
        $datapesan = array(
            'receiver' => $pic,
            'message' => $message,
            'id_kegiatan' => $id_kegiatan,
            'email_subject' => 'Pengingat Kegiatan',
            'email_message' => $message,
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
            return $httpStatus;
    }


    public function redirect_to_detail($id_kegiatan){
        return $this->detail($id_kegiatan);
    }

    public function detail($id_kegiatan)
    {
        $data = [
            'title' => 'Detail Agenda',
            'kegiatan' => $this->Kegiatan->findAllWithPenanggungJawabID($id_kegiatan),
            'dokumen' => $this->DokumenKegiatan->where('id_kegiatan', $id_kegiatan)->findAll(),
            'notification' => $this->Notifikasi->findNotificationActive($id_kegiatan)
        ];
        return view('timelinereminder/agenda/detail', $data);
    }

    public function tambah_dokumen($id_kegiatan){
        $data = [
            'title' => 'Tambah Dokumen Kegiatan',
            'id_kegiatan' => $id_kegiatan,
        ];
        return view('timelinereminder/agenda/tambah_dokumen', $data);
    }

    public function add_dokumen($id_kegiatan)
    {
        $validation = \Config\Services::validation();
        $nama_dokumen = $this->request->getPost('nama_dokumen');
        $file_dokumen = $this->request->getFile('file_dokumen');
        $file_extension = $file_dokumen->getExtension();
        $file_nama_dokumen = $id_kegiatan . '_' . str_replace(' ', '_', $nama_dokumen) .'.'. $file_extension;

        $rules = [
            'nama_dokumen' => [
                'label' => "nama_dokumen",
                'rules' => "required|is_unique[bot_dokumen_kegiatan.nama_dokumen]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => 'Nama file sudah digunakan'
                ],
            ],
            // 'file_dokumen' => [
            //     'rules' => "required|ext_in[file_dokumen,pdf]|max_size[file_berkas,2048]",
            //     'errors' => [
            //         'required' => "File harus diisi",
            //         'ext_in' => 'File berupa pdf',
            //         'max_size' => 'Size maks 5 MB',
            //     ],
            // ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'nama_dokumen' => $nama_dokumen,
                'link' => $file_nama_dokumen,
                'id_kegiatan' => $id_kegiatan
            ];
            $this->DokumenKegiatan->insert($data);
            $file_dokumen->move('timelinereminder_assets/dokumen_kegiatan/', $file_nama_dokumen);
            session()->setFlashdata('success', 'Berhasil menambahkan dokumen');
            return redirect()->to(base_url('timelinereminder/agenda/detail/'. $id_kegiatan))->with('status_icon', 'success')->with('status_text', 'Berhasil menambahkan dokumen');
        } else {
            $data = [
                'title' => 'Detail Agenda',
                'kegiatan' => $this->Kegiatan->findAllWithPenanggungJawabID($id_kegiatan),
                'dokumen' => $this->DokumenKegiatan->findAll(),
            ];
            session()->setFlashdata('error', 'Nama dokumen sudah digunakan');
            return $this->index();
        }
    }

    public function download_dokumen($id)
    {
        $dokumen = $this->DokumenKegiatan->find($id);       
        return $this->response->download('timelinereminder_assets/dokumen_kegiatan/' . $dokumen->link, null);
    }

    public function hapus_dokumen($id_kegiatan, $id)
    {
        $data = $this->DokumenKegiatan->find($id);
        $this->DokumenKegiatan->delete($id);
        if (is_file('timelinereminder_assets/dokumen_kegiatan/' . $data->link)) {
            unlink('timelinereminder_assets/dokumen_kegiatan/' . $data->link);
        }
        return redirect()->to(base_url('timelinereminder/agenda/detail/'. $id_kegiatan))->with('status_icon', 'success')->with('status_text', 'Berhasil menghapus dokumen');
    }

    public function hapus_kegiatan($id_kegiatan)
    {
        $this->DokumenKegiatan->deleteDocumentsByKegiatanId($id_kegiatan);
        $this->Notifikasi->MuteNotification($id_kegiatan);
        $this->Kegiatan->delete($id_kegiatan);
        return redirect()->to(base_url('timelinereminder/agenda'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

    public function pengingatKegiatan($pic, $tanggal_waktu_kegiatan, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan)
    {
        $now = microtime(true) * 1000;
    
        // Mengonversi tanggal dan waktu kegiatan menjadi timestamp
        $waktu_kegiatan = strtotime($tanggal_waktu_kegiatan);
        $bulan_kegiatan = date('n', $waktu_kegiatan);
        $tahun_kegiatan = date('Y', $waktu_kegiatan);
        $triwulan = ceil($bulan_kegiatan / 3); // Mendapatkan triwulan kegiatan
    
        // Pengingat untuk awal triwulan (1 Januari, 1 April, 1 Juli, dst.)
        $reminder_date_triwulan = strtotime('first day of ' . ($triwulan * 3 - 2) . ' months ' . $tahun_kegiatan . ' 08:30:00') * 1000;
        if ($reminder_date_triwulan >= $now || $bulan_kegiatan <= 3) {
            $this->buatPengingat($pic, $id_kegiatan, $reminder_date_triwulan, $nama_kegiatan, $deskripsi_kegiatan);
        }
    
        // Pengingat 1 bulan sebelum kegiatan
        $reminder_date_1_bulan = strtotime('-1 month', $waktu_kegiatan) * 1000;
        if ($reminder_date_1_bulan >= $now) {
            $this->buatPengingat($pic, $id_kegiatan, $reminder_date_1_bulan, $nama_kegiatan, $deskripsi_kegiatan);
        }
    
        // Pengingat 2 minggu sebelum kegiatan
        $reminder_date_2_minggu = strtotime('-2 weeks', $waktu_kegiatan) * 1000;
        if ($reminder_date_2_minggu >= $now) {
            $this->buatPengingat($pic, $id_kegiatan, $reminder_date_2_minggu, $nama_kegiatan, $deskripsi_kegiatan);
        }
    }

    private function buatPengingat($pic, $id_kegiatan, $reminder_date, $nama_kegiatan, $deskripsi_kegiatan)
    {
    date_default_timezone_set('Asia/Jakarta');
    $reminder_date_formatted = date('l, d F Y', $reminder_date / 1000);
    $reminder_time_formatted = date('H:i', $reminder_date / 1000);
    // Menggunakan fungsi date() untuk mengekstrak komponen
    $reminder_year = intval(date('Y', $reminder_date / 1000));
    $reminder_month = intval(date('m', $reminder_date / 1000));
    $reminder_day = intval(date('d', $reminder_date / 1000));
    $reminder_hour = date('H', $reminder_date / 1000);
    $reminder_minute = date('i', $reminder_date / 1000);

    // Kirim notifikasi atau email ke pengguna dengan informasi pengingat
    // Misalnya, menggunakan library notifikasi atau mengirim email
    // Contoh:
    $message = "Yth. PIC Kegiatan $nama_kegiatan Mengingatkan bahwa ada kegiatan Prodi Pada :";
    $message .= "\nTanggal: $reminder_date_formatted";
    $message .= "\nPukul: $reminder_time_formatted";
    $message .= "\nDeskripsi: $deskripsi_kegiatan";
    
    $url = 'http://localhost:8080/bot/api/publishdelay';
    // Kirim Notifikasi di semua platform
    $platformdata = array(
        'whatsapp' => true,
        'telegram' => true,
        'email'    => true
    );

    $timedata = array(
        'year' => $reminder_year,
        'month' => $reminder_month,
        'day'    => $reminder_day,
        'hour'    => $reminder_hour,
        'minute'    => $reminder_minute,
    );

    $datapesan = array(
        'receiver' => $pic,
        'message' => $message,
        'id_kegiatan' => $id_kegiatan,
        'email_subject' => 'Pengingat Kegiatan',
        'email_message' => $message,
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
    return $httpStatus;
    }

    public function createReminders($epoch_time, $pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan)
    {
        // Konversi epoch time menjadi objek DateTime dengan zona waktu WIB
        $wib_timezone = new \DateTimeZone('Asia/Jakarta');
        $event_date = DateTime::createFromFormat('U', $epoch_time / 1000, $wib_timezone);

        // Buat pengingat awal triwulan
        $quarter_start_dates = [];
        for ($month = 1; $month <= 12; $month += 3) {
            $quarter_start_dates[] = new DateTime($event_date->format('Y') . '-' . $month . '-01', $wib_timezone);
        }
        $quarter_reminder_date = null;
        foreach ($quarter_start_dates as $date) {
            if ($date <= $event_date) {
                $quarter_reminder_date = $date;
            } else {
                break;
            }
        }
        if ($quarter_reminder_date !== null) {
            $this->createReminder($quarter_reminder_date, $pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan);
        }

        // Buat pengingat 1 bulan sebelumnya
        $one_month_before = $event_date->sub(new DateInterval('P30D'));
        $this->createReminder($one_month_before, $pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan);

        // Buat pengingat 2 minggu sebelumnya
        $two_weeks_before = $event_date->sub(new DateInterval('P14D'));
        $this->createReminder($two_weeks_before, $pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan);

        // Kode lain untuk melanjutkan proses atau merespons ke permintaan
    }

    private function createReminder(DateTime $reminder_date, $pic, $id_kegiatan, $nama_kegiatan, $deskripsi_kegiatan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $reminder_date_formatted = date('l, d F Y', $reminder_date->getTimestamp());
        $reminder_time_formatted = date('H:i', $reminder_date->getTimestamp());
        
        // Mendapatkan nilai-nilai yang diperlukan
        $reminder_year = intval(date('Y', $reminder_date->getTimestamp()));
        $reminder_month = intval(date('m', $reminder_date->getTimestamp()));
        $reminder_day = intval(date('d', $reminder_date->getTimestamp()));
        $reminder_hour = date('H', $reminder_date->getTimestamp());
        $reminder_minute = date('i', $reminder_date->getTimestamp());
    
        // Kirim notifikasi atau email ke pengguna dengan informasi pengingat
        // Misalnya, menggunakan library notifikasi atau mengirim email
        // Contoh:
        $message = "Yth. PIC Kegiatan $nama_kegiatan Mengingatkan bahwa ada kegiatan Prodi Pada :";
        $message .= "\nTanggal: $reminder_date_formatted";
        $message .= "\nPukul: $reminder_time_formatted";
        $message .= "\nDeskripsi: $deskripsi_kegiatan";
        
        $url = 'http://localhost:8080/bot/api/publishdelay';
        // Kirim Notifikasi di semua platform
        $platformdata = array(
            'whatsapp' => true,
            'telegram' => true,
            'email'    => true
        );
    
        $timedata = array(
            'year' => $reminder_year,
            'month' => $reminder_month,
            'day'    => $reminder_day,
            'hour'    => $reminder_hour,
            'minute'    => $reminder_minute,
        );
    
        $datapesan = array(
            'receiver' => $pic,
            'message' => $message,
            'id_kegiatan' => $id_kegiatan,
            'email_subject' => 'Pengingat Kegiatan',
            'email_message' => $message,
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
        return $httpStatus;
    }


private function getNamaBulan($bulan)
{
    $namaBulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    return $namaBulan[$bulan];
}

//     public function pengingatKegiatan1($pic, $tanggal_kegiatan, $waktu_kegiatan, $id_kegiatan)
//     {
//     $now = time(); // Waktu sekarang
//     $reminder_date = null; // Tanggal pengingat

//     // Mengatur pengingat untuk awal triwulan
//     $bulan_kegiatan = date('n', strtotime($tanggal_kegiatan));
//     $tahun_kegiatan = date('Y', strtotime($tanggal_kegiatan));
//     $triwulan = ceil($bulan_kegiatan / 3); // Mendapatkan triwulan kegiatan

//     // Mengatur pengingat untuk awal triwulan (1 Januari, 1 April, 1 Juli, dst.)
//     if ($bulan_kegiatan % 3 == 0 && $now <= strtotime(date('Y-m-d', mktime(0, 0, 0, $bulan_kegiatan - 2, 1, $tahun_kegiatan)))) {
//         $reminder_date = mktime(0, 0, 0, $bulan_kegiatan - 2, 1, $tahun_kegiatan);
//     } elseif ($now <= strtotime(date('Y-m-d', mktime(0, 0, 0, $triwulan * 3 - 2, 1, $tahun_kegiatan)))) {
//         $reminder_date = mktime(0, 0, 0, $triwulan * 3 - 2, 1, $tahun_kegiatan);
//     }

//     // Mengatur pengingat untuk 1 bulan sebelum kegiatan
//     elseif ($now <= strtotime('-1 month', $waktu_kegiatan)) {
//         $reminder_date = strtotime('-1 month', $waktu_kegiatan);
//     }

//     // Mengatur pengingat untuk 2 minggu sebelum kegiatan
//     elseif ($now <= strtotime('-2 weeks', $waktu_kegiatan)) {
//         $reminder_date = strtotime('-2 weeks', $waktu_kegiatan);
//     }

//     // Mengatur pengingat untuk 1 hari sebelum kegiatan
//     elseif ($now <= strtotime('-1 day', $waktu_kegiatan)) {
//         $reminder_date = strtotime('-1 day', $waktu_kegiatan);
//     }

//     // Jika kegiatan sudah berlangsung kurang dari 1 bulan atau 2 minggu, pengingat dijadwalkan untuk besok harinya
//     else {
//         $reminder_date = strtotime('+1 day', $now);
//     }

//     // Lakukan tindakan pengingat sesuai kebutuhan
//     if ($reminder_date !== null) {
//         // Misalnya, kirim notifikasi atau email kepada pengguna sebagai pengingat kegiatan
//         // Anda dapat menyesuaikan tindakan yang diinginkan di sini
//         // Contoh:
//         $reminder_date_formatted = date('Y-m-d', $reminder_date);
//         $reminder_time_formatted = date('H:i', $reminder_date);
//         // Menggunakan fungsi date() untuk mengekstrak komponen
//         $reminder_year = date('Y', $reminder_date);
//         $reminder_month = date('m', $reminder_date);
//         $reminder_day = date('d', $reminder_date);
//         $reminder_hour = date('H', $reminder_date);
//         $reminder_minute = date('i', $reminder_date);

//         // Kirim notifikasi atau email ke pengguna dengan informasi pengingat
//         // Misalnya, menggunakan library notifikasi atau mengirim email
//         // Contoh:
//         $message = "Yth. PIC Kegiatan $nama_kegiatan Mengingatkan bahwa ada kegiatan Prodi Pada :";
//         $message .= "\nTanggal: $reminder_date_formatted";
//         $message .= "\nPukul: $reminder_time_formatted";
//         $message .= "\nDeskripsi: $deskripsi_kegiatan";
        
//         // Kirim Notifikasi di semua platform
//         $platformdata = array(
//             'whatsapp' => true,
//             'telegram' => true,
//             'email'    => true
//         );

//         $timedata = array(
//             'year' => $reminder_year,
//             'month' => $reminder_month,
//             'day'    => $reminder_day,
//             'hour'    => $reminder_hour,
//             'minute'    => $reminder_minute,
//         );
    
//         $datapesan = array(
//             'receiver' => $pic,
//             'message' => $message,
//             'id_kegiatan' => $id_kegiatan,
//             'email_subject' => 'Pengingat Kegiatan',
//             'email_message' => $message,
//             'platform' => $platformdata,
//             'time' => $timedata
//         );
    
//         $jsonData = json_encode($datapesan);

//         $request = Services::curlrequest();
//         $response = $request->setBody($jsonData)
//             ->setHeader('Content-Type', 'application/json')
//             ->setHeader('x-api-key', '12345678')
//             ->setHeader('App-auth', 'selfchatbotaccess-app')
//             ->post($url);
    
//         $httpStatus = $response->getStatusCode();

//     }
// }




}