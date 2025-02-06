<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\FaqModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class FaqController extends BaseController
{   
    public function __construct()
    {
        $this->faq = new FaqModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data FAQ',
            'faq' => $this->faq->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'faq'
        ];
        return view('tracer/faq/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data FAQ',
            'activePage' => 'faq',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/faq/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_faq = $uuid->toString();
        $pertanyaan = $this->request->getVar('pertanyaan');
        $jawaban = $this->request->getVar('jawaban');
        
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'jawaban' => [
                'label' => "Jawaban",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_faq' => $uuid,
                'pertanyaan' => $pertanyaan,
                'jawaban' => $jawaban,
            ];
            $this->faq->insert($data);
            session()->setFlashdata('success', 'Data FAQ berhasil ditambahkan');
            return redirect()->to(base_url('tracer/faq'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/faq/tambah', [
                'title' => 'Tambah Data FAQ',
                'activePage' => 'faq',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit faq',
            'faq' => $this->faq->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'faq'
        ];
        return view('tracer/faq/edit', $data);
    }

    public function update($id = null)
    {
        $pertanyaan = $this->request->getVar('pertanyaan');
        $jawaban = $this->request->getVar('jawaban');
        $rules = [
            'pertanyaan' => [
                'label' => "Pertanyaan",
                'rules' => "is_unique[faq.pertanyaan, id_faq, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'jawaban' => [
                'label' => "Jawaban",
                'rules' => "is_unique[faq.jawaban, id_faq, $id]",
                'errors' => [
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'pertanyaan' => $pertanyaan,
                'jawaban' => $jawaban,
            ];
            $this->faq->update($id, $data);
            session()->setFlashdata('success', 'Data FAQ berhasil diupdate');
            return redirect()->to('tracer/faq')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/faq/edit', [
                'title' => 'Edit FAQ',
                'faq' => $this->faq->find($id),
                'activePage' => 'faq',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->faq->find($id);
        $this->faq->delete($id);
        session()->setFlashdata('success', 'Data FAQ berhasil dihapus');
        return redirect()->to(base_url('tracer/faq'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}