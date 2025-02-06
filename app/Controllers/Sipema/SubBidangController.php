<?php

namespace App\Controllers\Sipema;

use App\Models\Sipema\BidangModel;
use App\Models\Sipema\SubBidangModel;
use App\Models\Master\StafModel;
use App\Models\Sipema\SubBidangDosenModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class SubBidangController extends BaseController
{
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->subbidang = new SubBidangModel();
        $this->sub_bidang_dosen = new SubBidangDosenModel();
        $this->bidang = new BidangModel();
        $this->staf = new StafModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Sub Bidang',
            'DetailSubBidang' => $this->subbidang->getDetailSubBidang(),
            'activePage' => 'sub-bidang'
        ];

        return view('sipema/subbidang/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Sub Bidang',
            'bidang' => $this->bidang->findAll(),
            'staf' => $this->staf->where('staf.jenis', 'dosen')->findAll(),
            'activePage' => 'sub-bidang',
            'validation' => $this->validation,
        ];
        
        return view('sipema/subbidang/tambah', $data);
    }
    
    public function simpan()
    {
        $uuid =  Uuid::uuid4();
        $id_sub_bidang = $uuid->toString();
        $nama_sub_bidang = $this->request->getVar('nama_sub_bidang');
        $id_bidang = $this->request->getVar('id_bidang');
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'nama_sub_bidang' => [
                'label' => "Nama Sub Bidang",
                'rules' => 'required|is_unique[sipema_sub_bidang.nama_sub_bidang,id_sub_bidang,'.$id_sub_bidang.']|alpha_space',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha_space' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'id_bidang' => [
                'label' => "Nama Bidang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_sub_bidang' => $uuid,
                'id_bidang' => $id_bidang,
                'nama_sub_bidang' => $nama_sub_bidang,
                'created_at' => $created_at,
            ];
            $this->subbidang->insert($data);
            $uuid2 = $data['id_sub_bidang'];
            $data2 = array();
            $id_staf = $this->request->getVar('id_staf');
            $jumlah_staf = count((array)$id_staf);
            for ($i = 0; $i < $jumlah_staf; $i++) {
                $data2[] = array(
                    'id_sub_bidang_dosen' => Uuid::uuid4()->toString(),
                    'id_sub_bidang' => $uuid2,
                    'id_staf' => $id_staf[$i],
                    'created_at' => $created_at,
                );
            }
            $this->sub_bidang_dosen->insertBatch($data2);
            return redirect()->to('sipema/sub-bidang')->with('status_icon', 'success')->with('status_text', 'Data sub bidang berhasil ditambahkan');
        } else {
            return view('sipema/subbidang/tambah', [
                'title' => 'Tambah Data Sub Bidang',
                'bidang' => $this->bidang->findAll(),
                'staf' => $this->staf->findAll(),
                'activePage' => 'sub-bidang',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Sub Bidang',
            'subbidang' => $this->subbidang->getSubBidang($id),
            'bidang' => $this->bidang->findAll(),
            'staf' => $this->staf->where('staf.jenis', 'dosen')->findAll(),
            'id_staf' => array_column($this->subbidang->getIdSubBidang($id), 'id_staf'),
            'activePage' => 'sub-bidang',
            'validation' => $this->validation,
        ];
        return view('sipema/subbidang/edit', $data);
    }
    
    public function update($id = null)
    {
        $nama_sub_bidang = $this->request->getVar('nama_sub_bidang');
        $id_bidang = $this->request->getVar('id_bidang');
        $updated_at = round(microtime(true) * 1000);
    
        $rules = [
            'nama_sub_bidang' => [
                'label' => "Nama Sub Bidang",
                'rules' => 'required|is_unique[sipema_sub_bidang.nama_sub_bidang,id_sub_bidang,'.$id.']|alpha_space',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha_space' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} sudah digunakan",
                ]
            ],
            'id_bidang' => [
                'label' => "Nama Bidang",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus dipilih",
                ]
            ],
        ];    
    
        if ($this->validate($rules)) {
            $data = [
                'id_bidang' => $id_bidang,
                'nama_sub_bidang' => $nama_sub_bidang,
                'updated_at' => $updated_at,
            ];

            $this->subbidang->update($id, $data);
    
            $this->sub_bidang_dosen->where('id_sub_bidang', $id)->delete();
    
            $uuid2 = $id;
            $data2 = array();
            $id_staf = $this->request->getVar('id_staf');
            $jumlah_staf = count((array) $id_staf);
            for ($i = 0; $i < $jumlah_staf; $i++) {
                $data2[] = array(
                    'id_sub_bidang_dosen' => Uuid::uuid4()->toString(),
                    'id_sub_bidang' => $uuid2,
                    'id_staf' => $id_staf[$i],
                    'created_at' => $updated_at,
                );
            }
            $this->sub_bidang_dosen->insertBatch($data2);

            return redirect()->to('sipema/sub-bidang')->with('status_icon', 'success')->with('status_text', 'Data sub bidang berhasil diupdate');
            } else {
                return view('sipema/subbidang/edit', [
                    'title' => 'Edit Data Sub Bidang',
                    'subbidang' => $this->subbidang->getSubBidang($id),
                    'bidang' => $this->bidang->findAll(),
                    'staf' => $this->staf->findAll(),
                    'id_staf' => array_column($this->subbidang->getIdSubBidang($id), 'id_staf'),
                    'activePage' => 'sub-bidang',
                    'validation' => $this->validation,
                ]);
            }
    }
    
    public function hapus($id)
    {
        $data = $this->subbidang->find($id);
        $this->subbidang->delete($id);
        session()->setFlashdata('status_icon', 'success');
        session()->setFlashdata('status_text', 'Data Sub Bidang berhasil dihapus');
        return redirect()->to(base_url('sipema/sub-bidang'));
    }
}