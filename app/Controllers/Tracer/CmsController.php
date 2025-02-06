<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\CmsModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class CmsController extends BaseController
{   
    public function __construct()
    {
        $this->cms = new CmsModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Content Management System',
            'cms' => $this->cms->getWarna(),
            'activePage' => 'cms'
        ];
        return view('tracer/cms/index', $data);
    }

    public function update($id = null)
    {
        $warna_bg = $this->request->getVar('warna_bg');

        $rules = [
            'warna_bg' => [
                'label' => "Nama Perusahaan",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            $data = [
                'warna_bg' => $warna_bg,
            ];
            $this->cms->update($id, $data);
            session()->setFlashdata('success', 'Data CMS berhasil diupdate');
            return redirect()->to('tracer/cms')->with('status_icon', 'success')->with('status_text', 'Data Berhasil diedit');
        } else {
            return view('tracer/cms/edit', [
                'title' => 'Edit Agenda',
                'cms' => $this->cms->find($id),
                'activePage' => 'cms',
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