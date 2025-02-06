<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\BerkasModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BerkasController extends BaseController
{
    public function __construct()
    {
        $this->berkas = new BerkasModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Dokumen Pendukung KMM',
            'berkas' => $this->berkas->findAll(),
        ];

        return view('kmm/berkas/index', $data);
    }

    public function create(){
        $data = [
            'title' => 'Dokumen Pendukung KMM',
            'validation' => $this->validation,
            'berkas' => $this->berkas->findAll(),
        ];

        return view('kmm/berkas/tambah', $data);
    }

    public function store(){
        $uuid =  Uuid::uuid4();
        $id_berkas = $uuid->toString();
        $berkas = $this->request->getFile('berkas');
        $berkasName = $berkas->getRandomName();
        $ket_berkas = $this->request->getVar('ket_berkas');
        $created_at = round(microtime(true) * 1000);
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'ket_berkas' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Keterangan Berkas harus diisi",
                ]
            ],
            'berkas' => [
                'rules' => "uploaded[berkas]|ext_in[berkas,pdf]|max_size[berkas,5120]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB',
                ]
            ],
        ];

        if($this->validate($rules)) {
            $data = [
                'id_berkas' => $id_berkas,
                'ket_berkas' => $ket_berkas,
                'berkas' => $berkasName,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
            $this->berkas->insert($data);
            $berkas->move('kmm_assets/dokumen-pendukung/', $berkasName);
            session()->setFlashdata('success', 'Data berhasil ditambahkan');
            return redirect()->to('kmm/berkas');
        } else {
            return view('kmm/berkas/tambah', [
                'title' => 'Dokumen Pendukung KMM',
                'validation' => $this->validation,
                'berkas' => $this->berkas->findAll(),
            ]);
        }
    }

    public function edit($id_berkas){
        $data = [
            'title' => 'Dokumen Pendukung KMM',
            'validation' => $this->validation,
            'berkas' => $this->berkas->find($id_berkas),
        ];
        return view('kmm/berkas/edit', $data);
    }

    public function update($id_berkas){
        $berkas = $this->request->getFile('berkas');
        $ket_berkas = $this->request->getVar('ket_berkas');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'ket_berkas' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Keterangan Berkas harus diisi",
                ]
            ],
            'berkas' => [
                'rules' => "ext_in[berkas,pdf]|max_size[berkas,5120]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB'
                ]
            ],
        ];
            
        if($this->validate($rules)) {            
            $file = $this->berkas->find($id_berkas);
            $old_file = $file->berkas;
            
            if($berkas->isValid() && !$berkas->hasMoved())
            {
                if(file_exists('kmm_assets/dokumen-pendukung/' . $old_file)){
                    unlink('kmm_assets/dokumen-pendukung/' . $old_file);
                }
                   $berkasName = $berkas->getRandomName();
                   $berkas->move('kmm_assets/dokumen-pendukung/', $berkasName);
            } else {
                    $berkasName = $file->berkas;
            }
            $data = [
                'berkas' => $berkasName,
                'ket_berkas' => $ket_berkas,
                'updated_at' => $updated_at,
            ];
            $this->berkas->update($id_berkas, $data);
            session()->setFlashdata('success', 'Data berhasil diupdate');
            return redirect()->to('kmm/berkas');
        } else {
            return view('kmm/berkas/edit',[
                'title' => 'Dokumen Pendukund KMM',
                'validation' => $this->validation,
                'berkas' => $this->berkas->find($id_berkas),
            ]);
        }
    }

    public function delete($id_berkas){
        $file = $this->berkas->find($id_berkas);
        $berkas = $file->berkas;
        
        if(file_exists('kmm_assets/dokumen-pendukung/' . $berkas)){
            unlink('kmm_assets/dokumen-pendukung/' . $berkas);
        }
        
        $this->berkas->delete($id_berkas);
        session()->setFlashdata('success', 'Data berhasil dihapus');
        return redirect()->to('kmm/berkas');
    }
    
    public function download($id_berkas){
        $file = $this->berkas->find($id_berkas);       
        return $this->response->download('kmm_assets/dokumen-pendukung/' . $file->berkas, null);
    }
}