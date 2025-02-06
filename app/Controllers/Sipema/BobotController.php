<?php

namespace App\Controllers\Sipema;

use App\Models\Sipema\BobotModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BobotController extends BaseController
{   
    public function __construct()
    {
        $this->bobot = new BobotModel();
        $this->validation = \Config\Services::validation();
    }
    
    /* Fungsi untuk menampilkan data bobot pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data bobot',
            'bobot' => $this->bobot->findAll(),
            'activePage' => 'bobot'
        ];
        return view('sipema/bobot/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data bobot',
            'activePage' => 'bobot',
            'validation' => $this->validation,
        ];
        
        return view('sipema/bobot/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_bobot = $uuid->toString();
        $jenis_bobot = $this->request->getVar('jenis_bobot');
        $nilai_bobot = $this->request->getVar('nilai_bobot') / 100;
        $created_at = round(microtime(true) * 1000);
        
        $rules = [
            'jenis_bobot' => [
                'label' => "Jenis Bobot",
                'rules' => 'required|is_unique[sipema_bobot.jenis_bobot,id_bobot,'.$id_bobot.']|alpha',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nilai_bobot' => [
                'label' => "Nilai Bobot",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            if ($this->bobot->getTotalBobotTambah() == true){
                $data = [
                    'id_bobot' => $uuid,
                    'jenis_bobot' => $jenis_bobot,
                    'nilai_bobot' => $nilai_bobot,
                    'created_at' => $created_at,
                ];
                
                $this->bobot->insert($data);
                return redirect()->to(base_url('sipema/bobot'))->with('status_icon', 'success')->with('status_text', 'Data bobot berhasil ditambah');
            }else{          
                return redirect()->back()->withInput()->with('error', 'Total nilai bobot melebihi 100%.');
            }
        } else {
            return view('sipema/bobot/tambah', [
                'title' => 'Tambah Data bobot',
                'activePage' => 'bobot',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data bidang',
            'bobot' => $this->bobot->find($id),
            'validation' => $this->validation,
            'activePage' => 'bidang'
        ];
        return view('sipema/bobot/edit', $data);
    }

    public function update($id = null)
    {   
        $nilai_bobot_lama = $this->bobot->find($id);
        $jenis_bobot = $this->request->getVar('jenis_bobot');
        $nilai_bobot_baru = $this->request->getVar('nilai_bobot') / 100;
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'jenis_bobot' => [
                'label' => "Jenis Bobot",
                'rules' => 'required|is_unique[sipema_bobot.jenis_bobot,id_bobot,'.$id.']|alpha',
                'errors' => [
                    'required' => "{field} harus diisi",
                    'alpha' => "{field} karakternya hanya boleh huruf",
                    'is_unique' => "{field} yang dimasukan Sudah ada"
                ]
            ],
            'nilai_bobot' => [
                'label' => "Nilai Bobot",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi" 
                ]
            ],
        ];
        if($this->validate($rules)) {
            if ($totalBobot = $this->bobot->getTotalBobotUpdate($nilai_bobot_lama, $nilai_bobot_baru) == true){
                $data = [
                    'jenis_bobot' => $jenis_bobot,
                    'nilai_bobot' => $nilai_bobot_baru,
                    'updated_at' => $updated_at,
                ];
                
                $this->bobot->update($id, $data);
                return redirect()->to(base_url('sipema/bobot'))->with('status_icon', 'success')->with('status_text', 'Data bobot berhasil diupdate');
            }else{          
                return redirect()->back()->withInput()->with('error', 'Total nilai bobot melebihi 100%.');
            }
        } else {
            return view('sipema/bobot/edit', [
                'title' => 'Edit Data bobot',
                'activePage' => 'bobot',
                'bobot' => $this->bobot->find($id),
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->bobot->find($id);
        $this->bobot->delete($id);
        session()->setFlashdata('success', 'Data Bobot berhasil dihapus');
        return redirect()->to(base_url('sipema/bobot'))->with('status_icon', 'success')->with('status_text', 'Data bobot berhasil dihapus');
    }
}