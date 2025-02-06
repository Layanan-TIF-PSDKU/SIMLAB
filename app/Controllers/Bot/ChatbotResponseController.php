<?php

namespace App\Controllers\Bot;

use App\Controllers\BaseController;
use App\Models\Bot\ChatbotResponseModel;
use App\Models\Bot\BotTagTelegramMessageModel;
use App\Models\Bot\BotTelegramMessageModel;

class ChatbotResponseController extends BaseController
{
    public function __construct()
    {
        $this->BotResponse = new ChatbotResponseModel();
        $this->ResponseTag = new BotTagTelegramMessageModel();
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data = [
            'title' => 'Kelola Chatbot',
            'message' => $this->BotResponse->findAll(),
            'activePage' => 'message'
        ];

        return view('bot/kelola_bot/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Kelola Chatbot',
            'activePage' => 'message',
            'validation' => $this->validation,
        ];
        return view('bot/kelola_bot/tambah', $data);
    }

    public function edit($id){
        $data = [
            'title' => 'Edit Chatbot Response ',
            'message' => $this->BotResponse->find($id),
            'tag' => $this->ResponseTag->where('id_messages', $id)->findAll(),
            'activePage' => 'edit response',
            'validation' => $this->validation,
        ];
        return view('bot/kelola_bot/edit', $data);
    }
    
    public function update_message($id){
        $message = $this->request->getVar('pesan');
        $rules = [
            'pesan' => [
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
                'message' => $message,
            ];
            $this->BotResponse->update($id, $data);
            session()->setFlashdata('success', 'Pesan Response Bot Berhasil Ditambahkan');
            return redirect()->to('bot/kelola_bot')->with('status_icon', 'success')->with('status_text', 'Pesan Response Bot Berhasil Ditambahkan');
        }
    }

    public function update_tag($id_tag){
        $tag = $this->request->getVar('tag-update');
        $rules = [
            'tag-update' => [
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $data = [
                'tag' => $tag,
            ];
            $this->ResponseTag->update($id_tag, $data);
            session()->setFlashdata('success', 'Pesan Response Bot Berhasil Ditambahkan');
            return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Pesan Response Bot Berhasil Ditambahkan');
        }
    }

    public function tambah_tag($id_messages){
        $tag = $this->request->getPost('tag-baru');
        $rules = [
        'tag-baru' => [
            'label' => "Tambah Tag",
            'rules' => "required",
            'errors' => [
                'required' => "{field} harus diisi",
                'is_unique' => "{field} yang dimasukan sudah ada",
            ],
        ],
    ];
        if ($this->validate($rules)) {
            $this->ResponseTag->saveTag($tag, $id_messages);
            session()->setFlashdata('success', 'Tag Berhasil Ditambahkan');
            return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Tag Berhasil Ditambahkan');
        }else {
            return view('bot/kelola_bot/index', [
                'title' => 'Kelola Chatbot',
                'message' => $this->BotResponse->findAll(),
                'activePage' => 'message'
            ]);
        }
    }

    public function insert_tag(){
        $tags = $this->request->getPost('tags');
        $id = $this->BotResponse->insertID();;

        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $this->ResponseTag->saveTag($tag, $id);
            }
        }
        session()->setFlashdata('success', 'Pesan Response Bot Berhasil Ditambahkan');
        return redirect()->to('bot/kelola_bot')->with('status_icon', 'success')->with('status_text', 'Pesan Response Bot Berhasil Ditambahkan');
    }

    public function hapus($id)
    {
        $this->ResponseTag->deleteTagsByMessageId($id);
        $this->BotResponse->delete($id);
        session()->setFlashdata('status', 'Response Chatbot berhasil dihapus');
        return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

    public function hapus_tag($id_tag)
    {
        $data = $this->ResponseTag->find($id_tag);
        $this->ResponseTag->delete($id_tag);
        session()->setFlashdata('status', 'Response Tag berhasil dihapus');
        return redirect()->back()->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

    public function simpan()
    {
        helper('number');
        $iduser = user()->id;
        $pesan = $this->request->getVar('pesan');
        $tag = $this->request->getVar('tag');
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'pesan' => [
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
                'message' => $pesan,
                'create_at' => $created_at,
                'attachment' => '-',
                'created_by' => $iduser,
            ];
            $this->BotResponse->save($data);
            return $this->insert_tag();
        } else {
            return view('bot/kelola_bot/tambah', [
                'title' => 'Kelola Chatbot',
                'message' => $this->BotResponse->findAll(),
                'activePage' => 'message'
            ]);
        }
    }

    public function add_dokumen_lampiran($id)
    {
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('lampiran_file');

        if ($file !== null) {
            if ($file->isValid()) {
                if ($file->getExtension() === 'pdf' && $file->getSize() <= 5000000) {
                    $file_nama = $file->getRandomName();

                    $attachment = $this->BotResponse->find($id);
                    if (is_file('bot_assets/lampiran/chatbot/' . $attachment->attachment)) {
                        unlink('bot_assets/lampiran/chatbot/' . $attachment->attachment);
                    }

                    $data = [
                        'attachment' => $file_nama
                    ];
                    $this->BotResponse->update($id, $data);
                    $file->move('bot_assets/lampiran/chatbot/', $file_nama);
                    return redirect()->to(base_url('/bot/kelola_bot/edit/' . $id))->with('status_icon', 'success')->with('status_text', 'Lampiran File Berhasil Di Upload');
                }else {
                    return redirect()->to(base_url('/bot/kelola_bot/edit/' . $id))->with('status_icon', 'error')->with('status_text', 'Lampiran File Harus PDF dan Ukuran Maks. 5 Mb');
                }
            }
        }
    }


    public function download_dokumen_lampiran($id)
    {
        $dokumen = $this->BotResponse->find($id);       
        return $this->response->download('bot_assets/lampiran/chatbot/' . $dokumen->attachment, null);
    }

    public function hapus_dokumen_lampiran($id)
    {
        $attachment = $this->BotResponse->find($id);
        $data = [
            'attachment' => "-"
        ];
        $this->BotResponse->update($id, $data);
        if (is_file('bot_assets/lampiran/chatbot/' . $attachment->attachment)) {
            unlink('bot_assets/lampiran/chatbot/' . $attachment->attachment);
        }
        return redirect()->to(base_url('/bot/kelola_bot/edit/' . $id))->with('status_icon', 'success')->with('status_text', 'Berhasil menghapus dokumen lampiran');
    }
}
