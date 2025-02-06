<?php

namespace App\Controllers\Mbkm;

use App\Controllers\BaseController;
use App\Models\Mbkm\BerkasModel;
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

    public function index()
    {
        $data = [
            'title' => 'Berkas MBKM',
            'berkasPendaftaran' => $this->berkas->getBerkasPendaftaran(),
            'berkasInfo' => $this->berkas->getBerkasInformasi(),            
            'activePage' => 'berkas',
        ];
        return view('mbkm/berkas/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Berkas',
            'activePage' => 'berkas',
            'validation' => $this->validation,
        ];
        return view('mbkm/berkas/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_berkas = $uuid->toString();
        $nama_berkas = $this->request->getVar('nama_berkas');
        $jenis = $this->request->getVar('jenis');
        $file_berkas = $this->request->getFile('file_berkas');
        $file_berkasName = $file_berkas->getRandomName();
        $created_at = round(microtime(true) * 1000);
        $rules = [
            'nama_berkas' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama Berkas harus diisi",
                ]
            ],
            'jenis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Jenis Berkas harus diisi",
                ]
            ],
            'file_berkas' => [
                'rules' => "uploaded[file_berkas]|ext_in[file_berkas,pdf]|max_size[file_berkas,5120]",
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File berupa pdf',
					'max_size' => 'Size maks 5 MB',
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_berkas' => $uuid,
                'nama_berkas' => $nama_berkas,
                'jenis' => $jenis,
                'file_berkas' => $file_berkasName,
                'created_at' => $created_at,
            ];
            
            $this->berkas->insert($data);
            
            $file_berkas->move('mbkm_assets/berkas/', $file_berkasName);
            session()->setFlashdata('success', 'Berhasil menambahkan data berkas!');
            return redirect()->to(base_url('mbkm/berkas'))->with('status_icon', 'success')->with('status_text', 'Berhasil menambahkan data berkas!');
        } else {
            return view('mbkm/berkas/tambah', [
                'title' => 'Tambah Berkas',
                'activePage' => 'berkas',
                'validation' => $this->validation,
            ]);
        }
    }
    public function edit($id_berkas)
    {
        $data = [
            'title' => 'Edit Data Berkas ',
            'berkas' => $this->berkas->find($id_berkas),
            'activePage' => 'berkas',
            'validation' => $this->validation,
        ];
        return view('mbkm/berkas/edit', $data);
    }
    public function update($id_berkas)
    {
        $nama_berkas = $this->request->getVar('nama_berkas');        
        $jenis = $this->request->getVar('jenis');        
        $file_berkas = $this->request->getFile('file_berkas');
        $file_berkasName = $file_berkas->getRandomName();  
        $updated_at = round(microtime(true) * 1000);

        $rules = [
            'nama_berkas' => [
                'rules' => "required",
                'errors' => [
                    'required' => "Nama berkas harus diisi",
                ],
            ],
            'jenis' => [
                'rules' => "required",
                'errors' => [
                    'required' => "jenis berkas harus diisi",
                ],
            ],
            'file_berkas' => [
                'rules' => "ext_in[file_berkas,pdf]|max_size[file_berkas,5048]",
                'errors' => [
                    'ext_in' => 'File berupa pdf',
                    'max_size' => 'Size maks 5 MB',
                ],
            ],
        ];
        
        $bks = $this->berkas->find($id_berkas);
        if ($this->validate($rules)) {
            if($file_berkas->isValid() && !$file_berkas->hasMoved())
            {
                $old_berkas = $bks->file_berkas;
                if(file_exists('mbkm_assets/berkas/' . $old_berkas)){
                    unlink('mbkm_assets/berkas/' . $old_berkas);
                }
                $file_berkasName = $file_berkas->getRandomName();
                $data = [
                    'nama_berkas' => $nama_berkas,
                    'jenis' => $jenis,
                    'file_berkas' => $file_berkasName,
                    'updated_at' => $updated_at,
                ];
    
                $this->berkas->update($id_berkas, $data);
                $file_berkas->move('mbkm_assets/berkas/', $file_berkasName);
                return redirect()->to('mbkm/berkas')->with('status', 'Data berhasil diubah');
            } else {
                $data = [
                    'nama_berkas' => $nama_berkas,
                    'jenis' => $jenis,
                    'updated_at' => $updated_at,
                ];
                $this->berkas->update($id_berkas, $data);
                session()->setFlashdata('success', 'Berhasil mengubah data berkas!');
                return redirect()->to('mbkm/berkas')->with('status', 'Data berhasil diubah');
            }
        } else {
            return view('mbkm/berkas/edit', [
                'title' => 'Edit Data Berkas',
                'validation' => $this->validation,
                'berkas' => $this->berkas->find($id_berkas),
                
            ]);
        }
    }
    
    public function hapus($id)
    {
        $data = $this->berkas->find($id);
        $this->berkas->delete($id);
        session()->setFlashdata('success', 'Data berkas berhasil dihapus');
        return redirect()->to(base_url('mbkm/berkas'))->with('status_icon', 'success')->with('status_text', 'Data Berhasil dihapus');
    }
    public function download_berkas($id)
    {
        $berkas = $this->berkas->find($id);       
        return $this->response->download('mbkm_assets/berkas/' . $berkas->file_berkas, null);
    }
}