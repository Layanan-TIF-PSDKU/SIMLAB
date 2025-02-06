<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;


class ChatbotUserController extends BaseController
{
    public function __construct()
    {
        $this->UserMahasiswa = new ChatbotUserMahasiswaModel();
        $this->UserStaff = new ChatbotUserStaffModel();
        $this->validation = \Config\Services::validation();
    }

    public function user_mahasiswa()
    {
        $mahasiswa = $this->UserMahasiswa->findAllUserMahasiswa();
        $data = [
            'title' => 'Chatbot | User Mahasiswa',
            'mahasiswa' => $mahasiswa,
        ];
        return view('bot/bot_user_mahasiswa/index', $data);
    }

    public function user_mahasiswa_edit($id_user_bot)
    {
        $mahasiswa = $this->UserMahasiswa->findUserMahasiswaByID($id_user_bot);
        $data = [
            'title' => 'Chatbot | Edit User Mahasiswa',
            'mahasiswa' => $mahasiswa,
        ];
        return view('bot/bot_user_mahasiswa/edit', $data);
    }

    public function user_mahasiswa_edit_simpan($id_user_bot)
    {
        $email = $this->request->getVar('email');
        $whatsapp = $this->request->getVar('whatsapp');
        $status_notification = $this->request->getVar('status_notification');

        $rules = [
            'email' => [
                'label' => "Email",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'whatsapp' => [
                'label' => "Whatsapp",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'email' => $email,
                'whatsapp' => $email,
                'status_notification' => $status_notification,
            ];
            $this->UserMahasiswa->update($id_user_bot, $data);
            return redirect()->to('/bot/kelola_bot/user/mahasiswa')->with('status_icon', 'success')->with('status_text', 'User Berhasil di Update');
        }else{
            return redirect()->to('/bot/kelola_bot/user/mahasiswa')->with('status_icon', 'error')->with('status_text', 'User Gagal di Update, Coba Lagi');
        }
        
    }

    public function hapus_user_mahasiswa($id_user_bot)
    {
        $data = $this->UserMahasiswa->find($id_user_bot);
        $this->UserMahasiswa->delete($id_user_bot);
        return redirect()->to('/bot/kelola_bot/user/mahasiswa')->with('status_icon', 'success')->with('status_text', 'User Berhasil dihapus ' . $data->username_telegram);
    }

    public function user_staf()
    {
        $staf = $this->UserStaff->findAllUserStaf();
        $data = [
            'title' => 'Chatbot | User Mahasiswa',
            'staf' => $staf,
        ];
        return view('bot/bot_user_staff/index', $data);
    }

    public function user_staf_edit($id_user_bot)
    {
        $staf = $this->UserStaff->findUserStafByID($id_user_bot);
        $data = [
            'title' => 'Chatbot | Edit User Staf',
            'staf' => $staf,
        ];
        return view('bot/bot_user_staff/edit', $data);
    }

    public function user_staf_edit_simpan($id_user_bot)
    {
        $email = $this->request->getVar('email');
        $whatsapp = $this->request->getVar('whatsapp');
        $status_notification = $this->request->getVar('status_notification');

        $rules = [
            'email' => [
                'label' => "Email",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'whatsapp' => [
                'label' => "Whatsapp",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'email' => $email,
                'whatsapp' => $email,
                'status_notification' => $status_notification,
            ];
            $this->UserStaff->update($id_user_bot, $data);
            return redirect()->to('/bot/kelola_bot/user/staf')->with('status_icon', 'success')->with('status_text', 'User Berhasil di Update');
        }else{
            return redirect()->to('/bot/kelola_bot/user/staf')->with('status_icon', 'error')->with('status_text', 'User Gagal di Update, Coba Lagi');
        }
        
    }

    public function hapus_user_staf($id_user_bot)
    {
        $data = $this->UserStaff->find($id_user_bot);
        $this->UserStaff->delete($id_user_bot);
        return redirect()->to('/bot/kelola_bot/user/staf')->with('status_icon', 'success')->with('status_text', 'User Berhasil dihapus ' . $data->username_telegram);
    }

 
}
