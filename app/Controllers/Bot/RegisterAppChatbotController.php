<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use App\Models\Bot\RegisterAppChatbotModel;

class RegisterAppChatbotController extends BaseController
{
    public function __construct()
    {
        $this->RegisteredApp = new RegisterAppChatbotModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {

        $data = [
            'title' => 'Register App Chatbot',
            'app_list' => $this->RegisteredApp->findAll(),
        ];

        return view('bot/register_app/index', $data);
    }

    public function tambah()
    {

        $data = [
            'title' => 'Register App Chatbot',
        ];

        return view('bot/register_app/tambah', $data);
    }

    public function submit()
    {
        $registered_id = $this->request->getVar('id_register');
        $app_detail = $this->request->getVar('detail_aplikasi');

        $rules = [
            'id_register' => [
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'detail_aplikasi' => [
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'registered_id' => $registered_id,
                'app_detail' => $app_detail,
            ];
            $this->RegisteredApp->insert($data);
            return $this->index();
        } else {
            return view('bot/kelola_bot/tambah', [
                'title' => 'Kelola Chatbot',
                'message' => $this->BotResponse->findAll(),
                'activePage' => 'message'
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->RegisteredApp->find($id);
        $this->RegisteredApp->delete($id);
        session()->setFlashdata('status', 'Response Chatbot berhasil dihapus');
        return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}