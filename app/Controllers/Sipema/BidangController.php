<?php

namespace App\Controllers\Sipema;

use App\Models\Sipema\BidangModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BidangController extends BaseController
{   
    public function __construct()
    {
        $this->bidang = new BidangModel();
        $this->validation = \Config\Services::validation();
    }
    
    /* Fungsi untuk menampilkan data bidang pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data bidang',
            'bidang' => $this->bidang->orderBy('nama_bidang', 'ASC')->findAll(),
            'activePage' => 'bidang'
        ];
        return view('sipema/bidang/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data bidang',
            'activePage' => 'bidang',
            'validation' => $this->validation,
        ];
        
        return view('sipema/bidang/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_bidang = $uuid->toString();
        $nama_bidang = $this->request->getVar('nama_bidang');
        $created_at = round(microtime(true) * 1000);
        
        $rules = [
            'nama_bidang' => [
                'label' => "Nama Bidang",
                'rules' => 'required|is_unique[sipema_bidang.nama_bidang,id_bidang,'.$id_bidang.']|alpha_space',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha_space' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_bidang' => $uuid,
                'nama_bidang' => $nama_bidang,
                'created_at' => $created_at,
            ];
            $this->bidang->insert($data);
            return redirect()->to(base_url('sipema/bidang'))->with('status_icon', 'success')->with('status_text', 'Data bidang berhasil ditambah');
        } else {
            return view('sipema/bidang/tambah', [
                'title' => 'Tambah Data bidang',
                'activePage' => 'bidang',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data bidang',
            'bidang' => $this->bidang->find($id),
            'validation' => $this->validation,
            'activePage' => 'bidang'
        ];
        return view('sipema/bidang/edit', $data);
    }

    public function update($id = null)
    {
        $nama_bidang = $this->request->getVar('nama_bidang');
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'nama_bidang' => [
                'label' => "Nama Bidang",
                'rules' => 'required|is_unique[sipema_bidang.nama_bidang,id_bidang,'.$id.']|alpha_space',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha_space' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'nama_bidang' => $nama_bidang,
                'updated_at' => $updated_at,
            ];
            $this->bidang->update($id, $data);
            return redirect()->to('sipema/bidang')->with('status_icon', 'success')->with('status_text', 'Data bidang berhasil diupdate');
        } else {
            return view('sipema/bidang/edit', [
                'title' => 'Edit Data bidang',
                'bidang' => $this->bidang->find($id),
                'activePage' => 'bidang',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->bidang->find($id);
        $this->bidang->delete($id);
        return redirect()->to(base_url('sipema/bidang'))->with('status_icon', 'success')->with('status_text', 'Data bidang berhasil dihapus');
    }
}