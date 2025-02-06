<?php

namespace App\Controllers\Master;

use App\Models\Master\MataKuliahModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class MataKuliahController extends Controller
{
    public function __construct()
    {
        $this->matakuliah = new MataKuliahModel();
        $this->validation = \Config\Services::validation();
    }

    /* Fungsi untuk menampilkan data matakuliah pada halaman utama*/
    public function index()
    {
        $data = [
            'title' => 'Data Mata Kuliah | Sistem Terintegrasi D3 TI',
            'matakuliah' => $this->matakuliah->orderBy('semester', 'ASC')->findAll(),
            'activePage' => 'mata-kuliah'
        ];
        return view('master/matakuliah/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Mata Kuliah | Sistem Terintegrasi D3 TI',
            'validation' => $this->validation,
            'activePage' => 'mata-kuliah'
        ];

        return view('master/matakuliah/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_mata_kuliah = $uuid->toString();
        $kode_mata_kuliah = $this->request->getVar('kode_mata_kuliah');
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $semester = $this->request->getVar('semester');
        $sks = $this->request->getVar('sks');
        $jenis = $this->request->getVar('jenis');

        $rules = [
            'kode_mata_kuliah' => [
                'label' => "Kode Mata Kuliah",
                'rules' => "required|is_unique[mata_kuliah.kode_mata_kuliah]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'nama_mata_kuliah' => [
                'label' => "Nama Mata Kuliah",
                'rules' => "required|is_unique[mata_kuliah.nama_mata_kuliah]",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'semester' => [
                'label' => "Semester",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'sks' => [
                'label' => "SKS",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jenis' => [
                'label' => "Jenis Mata Kuliah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_mata_kuliah' => $uuid,
                'kode_mata_kuliah' => $kode_mata_kuliah,
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'semester' => $semester,
                'sks' => $sks,
                'jenis' => $jenis,
            ];
            $this->matakuliah->insert($data);
            session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Ditambahkan');
            return redirect()->to('mata-kuliah')->with('status_icon', 'success')->with('status_text', 'Data Mata Kuliah Berhasil Ditambah');
        } else {
            return view('master/matakuliah/tambah', [
                'title' => 'Tambah Data Mata Kuliah | Sistem Terintegrasi D3 TI',
                'matakuliah' => $this->matakuliah->findAll(),
                'validation' => $this->validation,
                'activePage' => 'mata-kuliah'
            ]);
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Mata Kuliah | Sistem Terintegrasi D3 TI',
            'matakuliah' => $this->matakuliah->find($id),
            'validation' => $this->validation,
            'activePage' => 'mata-kuliah'
        ];
        return view('master/matakuliah/edit', $data);
    }

    public function update($id = null)
    {
        $kode_mata_kuliah = $this->request->getVar('kode_mata_kuliah');
        $nama_mata_kuliah = $this->request->getVar('nama_mata_kuliah');
        $semester = $this->request->getVar('semester');
        $sks = $this->request->getVar('sks');
        $jenis = $this->request->getVar('jenis');

        $rules = [
            'kode_mata_kuliah' => [
                'label' => "Kode Mata Kuliah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'nama_mata_kuliah' => [
                'label' => "Nama Mata Kuliah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan sudah ada",
                ],
            ],
            'semester' => [
                'label' => "Semester",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'sks' => [
                'label' => "SKS",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
            'jenis' => [
                'label' => "Jenis Mata Kuliah",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $data = [
                'kode_mata_kuliah' => $kode_mata_kuliah,
                'nama_mata_kuliah' => $nama_mata_kuliah,
                'semester' => $semester,
                'sks' => $sks,
                'jenis' => $jenis,
            ];
            $this->matakuliah->update($id, $data);
            session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Diupdate');
            return redirect()->to('mata-kuliah')->with('status_icon', 'success')->with('status_text', 'Data Mata Kuliah Berhasil diupdate');
        } else {
            return view('master/matakuliah/edit', [
                'title' => 'Edit Data Mata Kuliah | Sistem Terintegrasi D3 TI',
                'matakuliah' => $this->matakuliah->findAll(),
                'validation' => $this->validation,
                'activePage' => 'mata-kuliah'
            ]);
        }
    }

    public function hapus($id)
    {
        $data = $this->matakuliah->find($id);
        $this->matakuliah->delete($id);
        session()->setFlashdata('success', 'Data Mata Kuliah Berhasil Dihapus');
        return redirect()->to(base_url('mata-kuliah'))->with('status_icon', 'success')->with('status_text', 'Data Mata Kuliah Berhasil dihapus');
    }

    public function importExcel()
    {
        $file = $this->request->getFile('file');
        $extension = $file->getClientExtension();
        if($extension == 'xlsx' || $extension == 'xls'){
            if($extension == 'xls'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }else{
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
        $spreadsheet = $reader->load($file);
        $matkuliah =  $spreadsheet->getActiveSheet()->toArray();
        for ($i=1; $i<count($matkuliah); $i++) {
            $data = [
                'id_mata_kuliah' => Uuid::uuid4()->toString(),
                'kode_mata_kuliah' => $matkuliah[$i][0],
                'nama_mata_kuliah' => $matkuliah[$i][1],
                'semester' => $matkuliah[$i][2],
                'sks' => $matkuliah[$i][3],
                'jenis' => $matkuliah[$i][4],
            ];
            $this->matakuliah->insert($data);
        }
        return redirect()->back()->with('success', 'Data Excel berhasil diimport');
    } else {
        return redirect()->back()->with('error', 'Format file tidak sesuai');
    }
  }
}