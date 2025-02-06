<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\TimelineModel;
use Ramsey\Uuid\Uuid;

class TimelineController extends BaseController
{

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->timeline = new TimelineModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Timeline Tugas Akhir',
            'timeline' => $this->timeline->findAll(),
            'activePage' => 'timeline',
        ];
        return view('simta/timeline/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Timeline Tugas Akhir',
            'timeline' => $this->timeline->findAll(),
            'activePage' => 'timeline',
            'validation' => $this->validation,
        ];

        return view('simta/timeline/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_timeline = $uuid->toString();
        $nama_kegiatan = $this->request->getVar('nama_kegiatan');
        $tgl_mulai = $this->request->getVar('tanggal_mulai');
        $tanggal_mulai = round(strtotime($tgl_mulai)*1000);
        $tgl_selesai = $this->request->getVar('tanggal_selesai');
        $tanggal_selesai = round(strtotime($tgl_selesai)*1000);

        $rules = [
            'nama_kegiatan' => [
                'label' => "Nama Kegiatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'tanggal_mulai' => [
                'label' => "Judul Tugas Akhir",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'tanggal_selesai' => [
                'label' => "tanggal_selesai",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_timeline' => $uuid,
                'nama_kegiatan' => $nama_kegiatan,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
            ];
            //dd($data);
            $this->timeline->insert($data);
            session()->setFlashdata('success', 'Data Timeline Berhasil Ditambah');
            return redirect()->to('simta/timeline');
        } else {
            return view('simta/timeline/tambah', [
                'title' => 'Tambah Data Tugas Akhir Terdahulu',
                'activePage' => 'timeline',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_timeline)
    {
        $data = [
            'title' => 'Edit Data Tugas Akhir Terdahulu ',
            'timeline' => $this->timeline->find($id_timeline),
            'activePage' => 'timeline',
            'validation' => $this->validation,
        ];
        return view('simta/timeline/edit', $data);
    }
    public function update($id_timeline)
    {
        $data = [
            $nama_kegiatan = $this->request->getVar('nama_kegiatan'),
            $tgl_mulai = $this->request->getVar('tanggal_mulai'),
            $tanggal_mulai = round(strtotime($tgl_mulai)*1000),
            $tgl_selesai = $this->request->getVar('tanggal_selesai'),
            $tanggal_selesai = round(strtotime($tgl_selesai)*1000),
        ];

        $rules = [
            'nama_kegiatan' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Judul Tugas Akhir harus diisi",
                ],
            ],
            'tanggal_mulai' => [
                'rusles' => "required",
                'errors' => [
                    'required' => "Tanggal Mulai harus diisi",
                ],
            ],
            'tanggal_selesai' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Tanggal Selesai harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'nama_kegiatan' => $nama_kegiatan,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
            ];
            //sdd($data);
            $this->timeline->update($id_timeline, $data);
            session()->setFlashdata('success', 'Data Timeline Berhasil Diubah');
            return redirect()->to("simta/timeline");
        } else {
            return view('simta/timeline/edit', [
                'title' => 'Edit Data Timeline',
                'timeline' => $this->timeline->find($id_timeline),
                'activePage' => 'timeline',
                'validation' => $this->validation,
            ]);
        }
    }

    public function delete($id_timeline)
    {
        $this->timeline->delete($id_timeline);
        session()->setFlashdata('success', 'Data Timeline Berhasil Dihapus');
        return redirect()->to('simta/timeline');
    }
}
