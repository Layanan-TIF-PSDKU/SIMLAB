<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\TahunModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class TahunController extends BaseController
{   
    public function __construct()
    {
        $this->tahun = new TahunModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Tahun Lulus',
            'tahun' => $this->tahun->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'tahun'
        ];
        return view('tracer/tahun/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Tahun Lulus',
            'activePage' => 'tahun',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/tahun/tambah', $data);
    }
    
    public function simpan($id = null)
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_tahun_lulus = $uuid->toString();
        $tahun = $this->request->getVar('tahun');
        
        $rules = [
            'tahun' => [
                'label' => "Tahun",
                'rules' => "required|is_unique[tracer_tahun_lulus.tahun, id_tahun_lulus, $id]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_tahun_lulus' => $uuid,
                'tahun' => $tahun,
            ];
            $this->tahun->insert($data);
            session()->setFlashdata('success', 'Data Tahun berhasil ditambahkan');
            return redirect()->to(base_url('tracer/tahun'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/tahun/tambah', [
                'title' => 'Tambah Data Tahun',
                'activePage' => 'tahun',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Tahun',
            'tahun' => $this->tahun->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'tahun'
        ];
        return view('tracer/tahun/edit', $data);
    }

    public function update($id = null)
    {
        $tahun = $this->request->getVar('tahun');
        $rules = [
            'tahun' => [
                'label' => "Tahun",
                'rules' => "is_unique[tracer_tahun_lulus.tahun, id_tahun_lulus, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'tahun' => $tahun,
            ];
            $this->tahun->update($id, $data);
            session()->setFlashdata('success', 'Data Tahun berhasil diupdate');
            return redirect()->to('tracer/tahun')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/tahun/edit', [
                'title' => 'Edit Tahun',
                'tahun' => $this->tahun->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'tahun',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->tahun->find($id);
        $this->tahun->delete($id);
        session()->setFlashdata('success', 'Data Tahun berhasil dihapus');
        return redirect()->to(base_url('tracer/tahun'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}