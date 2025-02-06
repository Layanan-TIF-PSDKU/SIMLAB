<?php

namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Models\Simlab\PerawatanAlatLabModel;
use Ramsey\Uuid\Uuid;

class PerawatanAlatLabController extends BaseController
{
    public function __construct()
    {
        $this->alatlab = new AlatLaboratoriumModel();
        $this->perawatanalat = new PerawatanAlatLabModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Perawatan Alat Laboratorium',
            'perawatanalat' => $this->perawatanalat->getPerawatanAlat(),
            'activePage' => 'perawatan-alat',
        ];

        return view('simlab/perawatanalat/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Perawatan Alat Laboratorium',
            'alatlab' => $this->alatlab->getAlatLabBaik(),
            'validation' => $this->validation,
            'activePage' => 'perawatan-alat',
        ];
        return view('simlab/perawatanalat/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_perawatan_alat = $uuid->toString();
        $id_alat = $this->request->getVar('id_alat');
        $jenis = $this->request->getVar('jenis');
        $level = $this->request->getVar('level');
        $tanggal = $this->request->getVar('tanggal');

        $rules = [
            'id_alat' => [
                'label' => "Nama Alat Laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jenis' => [
                'label' => "Jenis Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'level' => [
                'label' => "Level Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],

            'tanggal' => [
                'label' => "Tanggal Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_perawatan_alat' => $uuid,
                'id_alat' => $id_alat,
                'jenis' => $jenis,
                'level' => $level,
                'tanggal' => $tanggal,
            ];
            $this->perawatanalat->insert($data);
            session()->setFlashdata('success', 'Data Perawatan Alat Laboratorium Berhasil Ditambahkan!');
            return redirect()->to('simlab/perawatan-alat')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simlab/perawatanalat/tambah', [
                'title' => 'Tambah Data Perawatan Alat Laboratorium',
                'activePage' => 'perawatan-alat',
                'alatlab' => $this->alatlab->getAlatLabBaik(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Perawatan Alat Laboratorium',
            'alatlab' => $this->alatlab->getAlatLabBaik(),
            'perawatanalat' => $this->perawatanalat->find($id),
            'validation' => $this->validation,
            'activePage' => 'perawatan-alat',
        ];
        return view('simlab/perawatanalat/edit', $data);
    }

    public function update($id = null)
    {
        $id_alat = $this->request->getVar('id_alat');
        $jenis = $this->request->getVar('jenis');
        $level = $this->request->getVar('level');
        $tanggal = $this->request->getVar('tanggal');

        $rules = [
            'id_alat' => [
                'label' => "Nama Alat Laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jenis' => [
                'label' => "Jenis Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'level' => [
                'label' => "Level Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],

            'tanggal' => [
                'label' => "Tanggal Perawatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_alat' => $id_alat,
                'jenis' => $jenis,
                'level' => $level,
                'tanggal' => $tanggal,
            ];
            $this->perawatanalat->update($id, $data);
            session()->setFlashdata('success', 'Data Perawatan Alat Laboratorium Berhasil Diupdate');
            return redirect()->to('simlab/perawatan-alat')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('simlab/alatlaboratorium/edit', [
                'title' => 'Edit Data Alat Laboratorium',
                'perawatanalat' => $this->perawatanalat->find($id),
                'alatlab' => $this->alatlab->getAlatLabBaik(),
                'activePage' => 'perawatan-alat',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->perawatanalat->find($id);
        $this->perawatanalat->delete($id);
        session()->setFlashdata('success', 'Data Perawatan Alat Laboratorium Berhasil Dihapus!');
        return redirect()->to(base_url('simlab/perawatan-alat'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

}
