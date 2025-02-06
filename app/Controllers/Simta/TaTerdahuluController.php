<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Simta\TaTerdahuluModel;
use Ramsey\Uuid\Uuid;

class TaTerdahuluController extends BaseController
{

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->mahasiswa = new MahasiswaModel();
        $this->taterdahulu = new TaTerdahuluModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Tugas Akhir Terdahulu',
            'taterdahulu' => $this->taterdahulu->getTaTerdahulu(),
            'activePage' => 'taterdahulu',
        ];
        return view('simta/taterdahulu/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Tugas Akhir Terdahulu',
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'taterdahulu',
            'validation' => $this->validation,
        ];

        return view('simta/taterdahulu/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_taterdahulu = $uuid->toString();
        $id_mhs = $this->request->getVar('id_mhs');
        $judul_ta = $this->request->getVar('judul_ta');
        $abstrak = $this->request->getVar('abstrak');
        $dokumen_ta = $this->request->getFile('dokumen_ta');
        $dokumen_taName = $dokumen_ta->getRandomName();
        // $status = $this->request->getVar('status');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'id_mhs' => [
                'label' => "Nama Mahasiswa",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'judul_ta' => [
                'label' => "Judul Tugas Akhir",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'abstrak' => [
                'label' => "abstrak",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'dokumen_ta' => [
                'rules' => "uploaded[dokumen_ta]|ext_in[dokumen_ta,pdf]|max_size[dokumen_ta,2048]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_taterdahulu' => $uuid,
                'id_mhs' => $id_mhs,
                'judul_ta' => $judul_ta,
                'abstrak' => $abstrak,
                'dokumen_ta' => $dokumen_taName,
                // 'status' => $status,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->taterdahulu->insert($data);
            $dokumen_ta->move('simta_assets/dokumenta/', $dokumen_taName);
            session()->setFlashdata('success', 'Data Tugas Akhir Terdahulu Berhasil Ditambah');
            return redirect()->to('simta/taterdahulu');
        } else {
            return view('simta/taterdahulu/tambah', [
                'title' => 'Tambah Data Tugas Akhir Terdahulu',
                'mahasiswa' => $this->mahasiswa->findAll(),
                'activePage' => 'taterdahulu',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_taterdahulu)
    {
        $data = [
            'title' => 'Edit Data Tugas Akhir Terdahulu ',
            'taterdahulu' => $this->taterdahulu->find($id_taterdahulu),
            'mahasiswa' => $this->mahasiswa->findAll(),
            'activePage' => 'taterdahulu',
            'validation' => $this->validation,
        ];
        return view('simta/taterdahulu/edit', $data);
    }
    public function update($id_taterdahulu)
    {
        $data = [
            $id_mhs = $this->request->getVar('id_mhs'),
            $judul_ta = $this->request->getVar('judul_ta'),
            $abstrak = $this->request->getVar('abstrak'),
            $dokumen_ta = $this->request->getFile('dokumen_ta'),
            $dokumen_taName = $dokumen_ta->getRandomName(),
            $updated_at = round(microtime(true) * 1000),
        ];

        $rules = [
            'judul_ta' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Judul Tugas Akhir harus diisi",
                ],
            ],
            'abstrak' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Abstrak harus diisi",
                ],
            ],
            'dokumen_ta' => [
                'rules' => "ext_in[dokumen_ta,pdf]|max_size[dokumen_ta,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $dokumen = $this->taterdahulu->find($id_taterdahulu);
            $old_prop = $dokumen->dokumen_ta;

            if ($dokumen_ta->isValid() && !$dokumen_ta->hasMoved()) {
                if (file_exists('simta_assets/dokumenta/' . $old_prop)) {
                    unlink('simta_assets/dokumenta/' . $old_prop);
                }
                $dokumen_taName = $dokumen_ta->getRandomName();
                $dokumen_ta->move('simta_assets/dokumenta/', $dokumen_taName);
            } else {
                $dokumen_taName = $dokumen->dokumen_ta;
            }

            $data = [
                'id_mhs' => $id_mhs,
                'judul_ta' => $judul_ta,
                'abstrak' => $abstrak,
                'dokumen_ta' => $dokumen_taName,
                'updated_at' => $updated_at,
            ];

            $this->taterdahulu->update($id_taterdahulu, $data);
            session()->setFlashdata('success', 'Data Tugas Akhir Terdahulu Berhasil Diubah');
            return redirect()->to("simta/taterdahulu");
        } else {
            return view('simta/taterdahulu/edit', [
                'title' => 'Edit Data Tugas Akhir Terdahulu ',
                'taterdahulu' => $this->taterdahulu->find($id_taterdahulu),
                'mahasiswa' => $this->mahasiswa->findAll(),
                'activePage' => 'taterdahulu',
                'validation' => $this->validation,
            ]);
        }
    }

    public function delete($id_taterdahulu)
    {
        $file = $this->taterdahulu->find($id_taterdahulu);
        $dokumen = $file->dokumen_ta;

        if (file_exists('simta_assets/dokumenta/' . $dokumen)) {
            unlink('simta_assets/dokumenta/' . $dokumen);
        }

        $this->taterdahulu->delete($id_taterdahulu);
        session()->setFlashdata('success', 'Data Tugas Akhir Terdahulu Berhasil Dihapus');
        return redirect()->to('simta/taterdahulu');
    }

    public function download_dokumen_ta($id_taterdahulu)
    {
        $taterdahulu = $this->taterdahulu->find($id_taterdahulu);
        return $this->response->download('simta_assets/dokumenta/' . $taterdahulu->dokumen_ta, null);
    }
}
