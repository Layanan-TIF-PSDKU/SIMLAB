<?php

namespace App\Controllers\Kmm;

use App\Models\Kmm\BobotModel;
use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BobotController extends BaseController
{
    public function __construct()
    {
        $this->bobot = new BobotModel();
        $this->validation = \Config\Services::validation();
        helper('form');
    }

    public function index(){
        $data = [
            'title' => 'Bobot Penilaian KMM',
            'bobot' => $this->bobot->findAll(),
        ];

        return view('kmm/bobot/index', $data);
    }

    public function edit($id_bobot){
        $data = [
            'title' => 'Bobot Penilaian KMM',
            'validation' => $this->validation,
            'bobot' => $this->bobot->find($id_bobot),
        ];
        return view('kmm/bobot/edit', $data);
    }

    public function update($id_bobot){
        $bobot_dosen = $this->request->getvar('bobot_dosen');
        $bobot_mitra = $this->request->getVar('bobot_mitra');
        
        $rules = [
            'bobot_dosen' => [
                'rules' => "required|greater_than[0]",
                    'errors' => [
                        'required' => "Keterangan bobot harus diisi",
                        'greater_than' => "Skala bobot 0-100",
                    ]
            ],
            'bobot_mitra' => [
                'rules' => "required|greater_than[0]",
                    'errors' => [
                        'required' => "Keterangan bobot harus diisi",
                        'greater_than' => "Skala bobot 0-100",
                    ]
            ],
        ];
            
        if($this->validate($rules)) {            
            $data = [
                'bobot_dosen' => $bobot_dosen,
                'bobot_mitra' => $bobot_mitra,
            ];
            $this->bobot->update($id_bobot, $data);
            session()->setFlashdata('success', 'Bobot penilaian berhasil diupdate');
            return redirect()->to('kmm/bobot');
        } else {
            return view('kmm/bobot/edit',[
                'title' => 'Bobot Penilaian KMM',
                'validation' => $this->validation,
                'bobot' => $this->bobot->find($id_bobot),
            ]);
        }
    }

    public function delete($id_bobot){        
        $this->bobot->delete($id_bobot);
        session()->setFlashdata('success', 'Bobot penilaian berhasil dihapus');
        return redirect()->to('kmm/bobot');
    }
}