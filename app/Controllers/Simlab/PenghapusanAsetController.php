<?php

namespace App\Controllers\Simlab;

use App\Models\Simlab\PenghapusanAsetModel;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class PenghapusanAsetController extends BaseController
{
    public function __construct()
    {
        $this->alatlab = new AlatLaboratoriumModel();
        $this->penghapusanaset = new PenghapusanAsetModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Penghapusan Aset',
            'penghapusanaset' => $this->penghapusanaset->getPenghapusanAset(),
            'activePage' => 'penghapusan-aset'
        ];
        
        return view('simlab/penghapusanaset/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Penghapusan Aset',
            'alatlab' => $this->alatlab->getAlatLab(),
            'validation' => $this->validation,
            'activePage' => 'penghapusan-aset'
        ];
        return view('simlab/penghapusanaset/tambah', $data);
    }

    public function simpan()
    {
            $uuid =  Uuid::uuid4();
            $id_penghapusan_aset = $uuid->toString();
            $id_alat = $this->request->getVar('id_alat');
            $jumlah_penghapusan = $this->request->getVar('jumlah_penghapusan');
            $tanggal_penghapusan = $this->request->getVar('tanggal_penghapusan');
            
            $rules = [
                'id_alat' => [
                    'label' => "Nama Alat Laboratorium",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
                'jumlah_penghapusan' => [
                    'label' => "Jumlah alat laboratorium yang keluar",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
               
                'tanggal_penghapusan' => [
                    'label' => "Tanggal penghapusan aset",
                    'rules' => "required",
                    'errors' => [
                        'required' => "{field} harus diisi",
                    ]
                ],
            ];

            $data_alat = $this->alatlab->find($id_alat);
            if ($data_alat) {
                if ($data_alat->stok < $jumlah_penghapusan) {
                    session()->setFlashdata('error', 'Stok tidak tersedia!');
                    return redirect()->to('simlab/penghapusan-aset/tambah')->with('status_icon', 'error');
                } else {
                $stok = $data_alat->stok - $jumlah_penghapusan;
                $this->alatlab->update($id_alat, ['stok' => $stok]);
            }
        }
                if($this->validate($rules)) {
                    $data = [
                        'id_penghapusan_aset' => $uuid,
                        'id_alat' => $id_alat,
                        'jumlah_penghapusan' => $jumlah_penghapusan,
                        'tanggal_penghapusan' => $tanggal_penghapusan,
                    ];
                    $this->penghapusanaset->insert($data);
                    session()->setFlashdata('success', 'Data Penghapusan Aset Berhasil Ditambahkan!');
                    return redirect()->to('simlab/penghapusan-aset')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
                } else {
                    return view('simlab/penghapusanaset/tambah', [
                        'title' => 'Tambah Data Penghapusan Aset',
                        'activePage' => 'penghapusan-aset',
                        'alatlab' => $this->alatlab->getAlatLab(),
                            'validation' => $this->validation,
                    ]);
                }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Penghapusan Aset',
            'penghapusanaset' => $this->penghapusanaset->find($id),
            'alatlab' => $this->alatlab->getAlatLab(),
            'validation' => $this->validation,
            'activePage' => 'penghapusan-aset'
        ];
        return view('simlab/penghapusanaset/edit', $data);
    }
      
    public function update($id = null)
    {
        $id_alat = $this->request->getVar('id_alat');
        $jumlah_penghapusan = $this->request->getVar('jumlah_penghapusan');
        $tanggal_penghapusan = $this->request->getVar('tanggal_penghapusan');
   
        $rules = [
            'id_alat' => [
                'label' => "Nama Alat Laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'jumlah_penghapusan' => [
                'label' => "Jumlah alat laboratorium yang keluar",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],            
            'tanggal_penghapusan' => [
                'label' => "Tanggal penghapusan aset",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        $data_alat = $this->alatlab->find($id_alat);
        if ($data_alat) {
            if ($data_alat->stok < $jumlah_penghapusan) {
                session()->setFlashdata('error', 'Stok tidak tersedia!');
                return redirect()->to('simlab/penghapusan-aset/tambah')->with('status_icon', 'error');
            } else {
            $stok = $data_alat->stok - $jumlah_penghapusan;
            $this->alatlab->update($id_alat, ['stok' => $stok]);
        }
    }
            if($this->validate($rules)) {
                $data = [
                    'id_alat' => $id_alat,
                    'jumlah_penghapusan' => $jumlah_penghapusan,
                'tanggal_penghapusan' => $tanggal_penghapusan,
                ];
                $this->penghapusanaset->update($id, $data);
                session()->setFlashdata('success', 'Data Penghapusan Aset Berhasil Diupdate');
                return redirect()->to('simlab/penghapusan-aset')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
            } else {
                return view('simlab/penghapusanaset/edit', [
                    'title' => 'Edit Data Penghapusan Aset',
                    'penghapusanaset' => $this->penghapusanaset->find($id),
                    'alatlab' => $this->alatlab->getAlatLab(),
                    'activePage' => 'penghapusan-aset',
                    'validation' => $this->validation,
                ]);
            }
    }

    public function hapus($id)
    {
        $data = $this->penghapusanaset->find($id);
        $this->penghapusanaset->delete($id);
        session()->setFlashdata('success', 'Data Penghapusan Aset Berhasil Dihapus!');
        return redirect()->to(base_url('simlab/penghapusan-aset'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

}


?>