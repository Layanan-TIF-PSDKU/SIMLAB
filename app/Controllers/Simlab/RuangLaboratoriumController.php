<?php

namespace App\Controllers\Simlab;

use App\Models\Simlab\RuangLaboratoriumModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class RuangLaboratoriumController extends BaseController
{
    public function __construct()
    {
        $this->ruanglab = new RuangLaboratoriumModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Ruang Laboratorium',
            'ruanglab' => $this->ruanglab->orderBy('nama_ruang', 'ASC')->findAll(),
            'activePage' => 'ruang-laboratorium'
        ];

        return view('simlab/ruanglaboratorium/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Ruang Laboratorium',
            'validation' => $this->validation,
            'activePage' => 'ruang-laboratorium'
        ];
        return view('simlab/ruanglaboratorium/tambah', $data);
    }

    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_ruang = $uuid->toString();
        $nama_ruang = $this->request->getVar('nama_ruang');
        $gedung = $this->request->getVar('gedung');
        $lantai = $this->request->getVar('lantai');
        
        $rules = [
            'nama_ruang' => [
                'label' => "Nama ruang laboratorium",
                'rules' => "required|is_unique[simlab_ruang_laboratorium.nama_ruang]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada"
                ]
            ],
            'gedung' => [
                'label' => "Gedung",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'lantai' => [
                'label' => "Lantai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_ruang' => $uuid,
                'nama_ruang' => $nama_ruang,
                'gedung' => $gedung,
                'lantai' => $lantai,
            ];
            $this->ruanglab->insert($data);
            session()->setFlashdata('success', 'Data Ruang Laboratorium Berhasil Ditambahkan!');
            return redirect()->to('simlab/ruang-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simlab/ruanglaboratorium/tambah', [
                'title' => 'Tambah Data Ruang Laboratorium',
                'activePage' => 'ruang-laboratorium',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Ruang Laboratorium',
            'ruanglab' => $this->ruanglab->find($id),
            'validation' => $this->validation,
            'activePage' => 'ruang-laboratorium',
        ];
        return view('simlab/ruanglaboratorium/edit', $data);
    }

    public function update($id = null)
    {
        $nama_ruang = $this->request->getVar('nama_ruang');
        $gedung = $this->request->getVar('gedung');
        $lantai = $this->request->getVar('lantai');
            $rules = [
                'nama_ruang' => [
                    'label' => "Nama ruang laboratorium",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
                'gedung' => [
                    'label' => "Gedung",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
                'lantai' => [
                    'label' => "Lantai",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
            ];

            if($this->validate($rules)) {
                $data = [
                    'nama_ruang' => $nama_ruang,
                    'gedung' => $gedung,
                    'lantai' => $lantai,
                ];
                $this->ruanglab->update($id, $data);
                session()->setFlashdata('success', 'Data Ruang Laboratorium Berhasil Diupdate');
                return redirect()->to('simlab/ruang-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
            } else {
                return view('simlab/ruanglaboratorium/edit', [
                    'title' => 'Edit Data Ruang Laboratorium',
                    'ruanglab' => $this->ruanglab->find($id),
                    'activePage' => 'ruang-laboratorium',
                    'validation' => $this->validation,
                ]);
            }
    }

    public function hapus($id)
    {
        $data = $this->ruanglab->find($id);
        $this->ruanglab->delete($id);
        session()->setFlashdata('success', 'Data Ruang Laboratorium Berhasil Dihapus!');
        return redirect()->to('simlab/ruang-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

}


?>