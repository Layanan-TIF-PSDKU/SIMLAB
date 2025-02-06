<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Mbkm\BobotModel;
use Ramsey\Uuid\Uuid;

class BobotController extends BaseController
{
    public function __construct()
    {
        $this->bobot = new BobotModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Bobot Penilaian',
            'bobot' => $this->bobot->findAll(),
            'activePage' => 'bobot',
        ];

        return view('mbkm/bobot/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Bobot Penilaian',
            'validation' => $this->validation,
        ];

        return view('mbkm/bobot/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_bobot = $uuid->toString();
        $bobot_dosen = $this->request->getVar('bobot_dosen');
        $bobot_mitra = $this->request->getVar('bobot_mitra');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'bobot_dosen' => [
                'rules' => "required|numeric",
                'errors' => [
                    'required' => "Harus diisi!",
                    'numeric' => "Inputan berupa angka!",
                ],
            ],
            'bobot_mitra' => [
                'rules' => "required|numeric",
                'errors' => [
                    'required' => "Harus diisi!",
                    'numeric' => "Inputan berupa angka!",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_bobot' => $uuid,
                'bobot_dosen' => $bobot_dosen,
                'bobot_mitra' => $bobot_mitra,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->bobot->insert($data);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('mbkm/bobot');
        } else {
            return view('mbkm/bobot/tambah', [
                'title' => 'Data Bobot Penilaian',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_bobot)
    {
        $data = [
            'title' => 'Edit Bobot Penilaian',
            'validation' => $this->validation,
            'bobot' => $this->bobot->find($id_bobot),
        ];
        return view('mbkm/bobot/edit', $data);
    }

    public function update($id_bobot)
    {
        $bobot_dosen = $this->request->getVar('bobot_dosen');
        $bobot_mitra = $this->request->getVar('bobot_mitra');
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'bobot_dosen' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi!",
                ],
            ],
            'bobot_dosen' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Harus diisi!",
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $data = [
                'bobot_dosen' => $bobot_dosen,
                'bobot_mitra' => $bobot_mitra,
                'updated_at' => $updated_at,
            ];

            $this->bobot->update($id_bobot, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('mbkm/bobot');
        } else {
            return view('mbkm/bobot/edit', [
                'title' => 'Edit Bobot Penilaian',
                'validation' => $this->validation,
                'bobot' => $this->bobot->find($id_bobot),
            ]);
        }
    }

    public function hapus($id_bobot)
    {
        $this->bobot->delete($id_bobot);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('mbkm/bobot');
    }
}