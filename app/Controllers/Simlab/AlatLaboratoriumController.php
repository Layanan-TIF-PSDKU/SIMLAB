<?php

namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Models\Simlab\RuangLaboratoriumModel;
use App\Models\Simlab\KategoriModel;
use Ramsey\Uuid\Uuid;
use Dompdf\Dompdf;

class AlatLaboratoriumController extends BaseController
{
    public function __construct()
    {
        $this->alatlab = new AlatLaboratoriumModel();
        $this->kategori = new KategoriModel();
        $this->ruanglab = new RuangLaboratoriumModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Alat Laboratorium',
            'alatlab' => $this->alatlab->getAlatLabBaik(),
            'activePage' => 'alat-laboratorium',
        ];

        return view('simlab/alatlaboratorium/index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Alat Laboratorium',
            'validation' => $this->validation,
            'kategori' => $this->kategori->findAll(),
            'ruanglab' => $this->ruanglab->findAll(),
            'activePage' => 'alat-laboratorium',
        ];
        return view('simlab/alatlaboratorium/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_alat = $uuid->toString();
        $id_kategori = $this->request->getVar('id_kategori');
        $id_ruang = $this->request->getVar('id_ruang');
        $nama_alat = $this->request->getVar('nama_alat');
        $no_inventaris = $this->request->getVar('no_inventaris') ?? null;
        $jumlah_masuk = $this->request->getVar('jumlah_masuk');
        $stok = $this->request->getVar('stok');
        $satuan = $this->request->getVar('satuan');
        $kondisi = $this->request->getVar('kondisi');
        $tanggal_masuk = $this->request->getVar('tanggal_masuk');
        // $gambar = $_FILES['gambar']['name'];
        // if ($gambar != null){
        $gambar = $this->request->getFile('gambar');
        $namaGambar = $gambar->getRandomName();
        // $gambar->move('simlab_assets/alat-laboratorium/', $namaGambar);
        // $pathGambar = ('simlab_assets/alat-laboratorium/' . $gambar);
        // } else{
        //     $pathGambar='';
        // }
        // $gambar->move('simlab_assets/alat-laboratorium/', $namaGambar. '.' . $gambar->getExtension());

        // $pathGambar = 'simlab_assets/alat-laboratorium/' . $fileGambar->getName();

        $rules = [
            'id_kategori' => [
                'label' => "Kategori",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'id_ruang' => [
                'label' => "Ruang laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'nama_alat' => [
                'label' => "Nama alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'kondisi' => [
                'label' => "Kondisi alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'satuan' => [
                'label' => "Satuan jumlah alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],

            'tanggal_masuk' => [
                'label' => "Tanggal masuk",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jumlah_masuk' => [
                'label' => "Jumlah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'gambar' => [
                'label' => "Gambar alat laboratorium",
                'rules' => 'max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png]|ext_in[gambar,jpg,jpeg,png]',
                'errors' => [
                    // 'required'=> '{field} harus diisi!',
                    'ext_int' => "File yang diupload harus berupa PNG/JPG/JPEG",
                    'max_size' => "Foto yang diupload maximal harus berukuran 2Mb",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_alat' => $uuid,
                'id_kategori' => $id_kategori,
                'id_ruang' => $id_ruang,
                'nama_alat' => $nama_alat,
                'no_inventaris' => $no_inventaris,
                'tanggal_masuk' => $tanggal_masuk,
                'jumlah_masuk' => $jumlah_masuk,
                'stok' => $stok,
                'satuan' => $satuan,
                'kondisi' => $kondisi,
                'gambar' => $namaGambar,
            ];
            $this->alatlab->insert($data);
            $gambar->move('simlab_assets/alat-laboratorium/', $namaGambar);
            session()->setFlashdata('success', 'Data Alat Laboratorium Berhasil Ditambahkan!');
            return redirect()->to('simlab/alat-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('simlab/alatlaboratorium/tambah', [
                'title' => 'Tambah Data Alat Laboratorium',
                'activePage' => 'alat-laboratorium',
                'kategori' => $this->kategori->findAll(),
                'ruanglab' => $this->ruanglab->findAll(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Alat Laboratorium',
            'alatlab' => $this->alatlab->find($id),
            'kategori' => $this->kategori->findAll(),
            'ruanglab' => $this->ruanglab->findAll(),
            'validation' => $this->validation,
            'activePage' => 'alat-laboratorium',
        ];
        return view('simlab/alatlaboratorium/edit', $data);
    }

    public function update($id = null)
    {
        $id_kategori = $this->request->getVar('id_kategori');
        $id_ruang = $this->request->getVar('id_ruang');
        $nama_alat = $this->request->getVar('nama_alat');
        $no_inventaris = $this->request->getVar('no_inventaris');
        $jumlah_masuk = $this->request->getVar('jumlah_masuk');
        $stok = $this->request->getVar('stok');
        $satuan = $this->request->getVar('satuan');
        $kondisi = $this->request->getVar('kondisi');
        $tanggal_masuk = $this->request->getVar('tanggal_masuk');
        $gambar = $this->request->getFile('gambar');
        $tanggal_perubahan = $this->request->getVar('tanggal_perubahan');

        $rules = [
            'id_kategori' => [
                'label' => "Kategori",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'id_ruang' => [
                'label' => "Ruang laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'nama_alat' => [
                'label' => "Nama alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'kondisi' => [
                'label' => "Kondisi alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'satuan' => [
                'label' => "Satuan jumlah alat laboratorium",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],

            'tanggal_masuk' => [
                'label' => "Tanggal masuk",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jumlah_masuk' => [
                'label' => "Jumlah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'gambar' => [
                'label' => "Gambar alat laboratorium",
                'rules' => 'max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png]|ext_in[gambar,jpg,jpeg,png]',
                'errors' => [
                    'ext_int' => "File yang diupload harus berupa PNG/JPG/JPEG",
                    'max_size' => "Foto yang diupload maximal harus berukuran 2Mb",
                ],
            ],
        ];

        $img = $this->alatlab->find($id);
        if ($this->validate($rules)) {
            if ($gambar->isValid() && !$gambar->hasMoved()) {
                $old_img = $img->gambar;
                if (file_exists('simlab_assets/alat-laboratorium/' . $old_img)) {
                    unlink('simlab_assets/alat-laboratorium/' . $old_img);
                }
                $namaGambar = $gambar->getRandomName();
                $gambar->move('simlab_assets/alat-laboratorium/', $namaGambar);
                $data = [
                    'id_kategori' => $id_kategori,
                    'id_ruang' => $id_ruang,
                    'nama_alat' => $nama_alat,
                    'no_inventaris' => $no_inventaris,
                    'tanggal_masuk' => $tanggal_masuk,
                    'jumlah_masuk' => $jumlah_masuk,
                    'stok' => $stok,
                    'satuan' => $satuan,
                    'kondisi' => $kondisi,
                    'gambar' => $namaGambar,
                    'tanggal_perubahan' => $tanggal_perubahan,
                ];
                $this->alatlab->update($id, $data);
                session()->setFlashdata('success', 'Data Alat Laboratorium Berhasil Diupdate');
                return redirect()->to('simlab/alat-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
            } else {
                $data = [
                    'id_kategori' => $id_kategori,
                    'id_ruang' => $id_ruang,
                    'nama_alat' => $nama_alat,
                    'no_inventaris' => $no_inventaris,
                    'tanggal_masuk' => $tanggal_masuk,
                    'jumlah_masuk' => $jumlah_masuk,
                    'stok' => $stok,
                    'satuan' => $satuan,
                    'kondisi' => $kondisi,
                    'tanggal_perubahan' => $tanggal_perubahan,
                ];
                $this->alatlab->update($id, $data);
                session()->setFlashdata('success', 'Data Alat Laboratorium Berhasil Diupdate');
                return redirect()->to('simlab/alat-laboratorium')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
            }
        } else {
            return view('simlab/alatlaboratorium/edit', [
                'title' => 'Edit Data Alat Laboratorium',
                'alatlab' => $this->alatlab->find($id),
                'kategori' => $this->kategori->findAll(),
                'ruanglab' => $this->ruanglab->findAll(),
                'activePage' => 'alat-laboratorium',
                'validation' => $this->validation,
            ]);

        }
    }

    public function hapus($id)
    {
        $data = $this->alatlab->find($id);
        $gambar = $data->gambar;
        if (file_exists('simlab_assets/alat-laboratorium/' . $gambar)) {
            unlink('simlab_assets/alat-laboratorium/' . $gambar);
        }
        $this->alatlab->delete($id);
        session()->setFlashdata('success', 'Data Alat Laboratorium Berhasil Dihapus!');
        return redirect()->to(base_url('simlab/alat-laboratorium'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }

    public function detail($id = null)
    {
        $data = $this->alatlab->getDetailAlat($id);
        return json_encode($data);
    }

    public function alat_rusak()
    {
        $data = [
            'title' => 'Data Alat Laboratorium Rusak',
            'alatlab' => $this->alatlab->getAlatLabRusak(),
            'activePage' => 'alat-laboratorium',
        ];

        return view('simlab/alatlaboratorium/alat_rusak', $data);
    }

    public function getStokByAlat($id_alat = null)
    {
        $data = $this->alatlab->getStokByAlat($id_alat);
        return json_encode($data);
    }


}