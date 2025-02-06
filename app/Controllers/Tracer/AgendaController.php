<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\AgendaModel;
use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class AgendaController extends BaseController
{   
    public function __construct()
    {
        $this->agenda = new AgendaModel();
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Agenda',
            'agenda' => $this->agenda->findAll(),
            'cms' => $this->cms->getWarna(),
            'activePage' => 'agenda'
        ];
        return view('tracer/agenda/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Agenda',
            'activePage' => 'agenda',
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
        ];
        
        return view('tracer/agenda/tambah', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_agenda = $uuid->toString();
        $nama_agenda = $this->request->getVar('nama_agenda');
        $deskripsi_agenda = $this->request->getVar('deskripsi_agenda');
        $waktu_kegiatan = $this->request->getVar('waktu_kegiatan');
        
        $rules = [
            'nama_agenda' => [
                'label' => "Nama Agenda",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'deskripsi_agenda' => [
                'label' => "Deskripsi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'waktu_kegiatan' => [
                'label' => "Waktu Kegiatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_agenda' => $uuid,
                'nama_agenda' => $nama_agenda,
                'deskripsi_agenda' => $deskripsi_agenda,
                'waktu_kegiatan' => $waktu_kegiatan,
            ];
            $this->agenda->insert($data);
            session()->setFlashdata('success', 'Data Agenda berhasil ditambahkan');
            return redirect()->to(base_url('tracer/agenda'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil ditambah');
        } else {
            return view('tracer/agenda/tambah', [
                'title' => 'Tambah Data Agenda',
                'activePage' => 'agenda',
                'cms' => $this->cms->getWarna(),
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Agenda',
            'agenda' => $this->agenda->find($id),
            'cms' => $this->cms->getWarna(),
            'validation' => $this->validation,
            'activePage' => 'agenda'
        ];
        return view('tracer/agenda/edit', $data);
    }

    public function update($id = null)
    {
        $nama_agenda = $this->request->getVar('nama_agenda');
        $deskripsi_agenda = $this->request->getVar('deskripsi_agenda');
        $waktu_kegiatan = $this->request->getVar('waktu_kegiatan');
        $rules = [
            'nama_agenda' => [
                'label' => "Nama Agenda",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
            'deskripsi_agenda' => [
                'label' => "Deskripsi",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
            'waktu_kegiatan' => [
                'label' => "Waktu Kegiatan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ], 
        ];
        
        if($this->validate($rules)) {
            $data = [
                'nama_agenda' => $nama_agenda,
                'deskripsi_agenda' => $deskripsi_agenda,
                'waktu_kegiatan' => $waktu_kegiatan,
            ];
            $this->agenda->update($id, $data);
            session()->setFlashdata('success', 'Data Agenda berhasil diupdate');
            return redirect()->to('tracer/agenda')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/agenda/edit', [
                'title' => 'Edit Agenda',
                'agenda' => $this->agenda->find($id),
                'cms' => $this->cms->getWarna(),
                'activePage' => 'agenda',
                'validation' => $this->validation,
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->agenda->find($id);
        $this->agenda->delete($id);
        session()->setFlashdata('success', 'Data Agenda berhasil dihapus');
        return redirect()->to(base_url('tracer/agenda'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
}