<?php

namespace App\Controllers\Simta;

use App\Controllers\BaseController;
use App\Models\Simta\BobotPenilaianModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class BobotPenilaianController extends BaseController
{
    public function __construct()
    {
        $this->bobotpenilaian = new BobotPenilaianModel();
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        $data = [
            'title' => 'Bobot Penilaian Tugas Akhir',
            'bobotpenilaian' => $this->bobotpenilaian->findAll(),
            'activePage' => 'bobotpenilaian',
        ];
        return view('simta/bobotpenilaian/index', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Data Bobot Penilaian Tugas Akhir',
            'bobotpenilaian' => $this->bobotpenilaian->findAll(),
            'activePage' => 'bobotpenilaian',
            'validation' => $this->validation,

        ];

        return view('simta/bobotpenilaian/tambah', $data);
    }

    public function simpan()
    {
        $uuid = Uuid::uuid4();
        $id_bobot = $uuid->toString();
        $bobot_ujianproposal = $this->request->getVar('bobot_ujianproposal');
        $bobot_seminarhasil = $this->request->getVar('bobot_seminarhasil');
        $bobot_ujianta = $this->request->getVar('bobot_ujianta');
        $created_at = round(microtime(true) * 1000);

        $rules = [
            'bobot_ujianproposal' => [
                'label' => "Bobot Penilaian Ujian Proposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'bobot_seminarhasil' => [
                'label' => "Bobot Penilaian Seminar Hasil",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'bobot_ujianta' => [
                'label' => "Bobot Penilaian Ujian Tugas Akhir",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            
        ];

        if ($this->validate($rules)) {
            $data = [
                'id_bobot' => $uuid,
                'bobot_ujianproposal' => $bobot_ujianproposal,
                'bobot_seminarhasil' => $bobot_seminarhasil,
                'bobot_ujianta' => $bobot_ujianta,
                'created_at' => $created_at,
            ];
            // return dd($data);
            $this->bobotpenilaian->insert($data);
            
            session()->setFlashdata('success', 'Data Bobot Penilaian Tugas Akhir Berhasil Ditambah');
            return redirect()->to('simta/bobotpenilaian');
        } else {
            return view('simta/bobotpenilaian/tambah', [
                'title' => 'Tambah Data Bobot Penilaian TA',
                'bobotpenilaian' => $this->bobotpenilaian->findAll(),
                'activePage' => 'bobotpenilaian',
                'validation' => $this->validation,
            ]);
        }
    }

    public function edit($id_bobot)
    {
        $data = [
            'title' => 'Edit Data Bobot Penilaian Tugas Akhir ',
            'bobotpenilaian' => $this->bobotpenilaian->find($id_bobot),
            'activePage' => 'bobotpenilaian',
            'validation' => $this->validation,
        ];
        return view('simta/bobotpenilaian/edit', $data);
    }

    public function update($id_bobot)
    {
        $bobot_ujianproposal = $this->request->getVar('bobot_ujianproposal');
        $bobot_seminarhasil = $this->request->getVar('bobot_seminarhasil');
        $bobot_ujianta = $this->request->getVar('bobot_ujianta');
        $updated_at = round(microtime(true) * 1000);
        
        $rules = [
            'bobot_ujianproposal' => [
                'label' => "Bobot Penilaian Ujian Proposal",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'bobot_seminarhasil' => [
                'label' => "Bobot Penilaian Seminar Hasil",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            'bobot_ujianta' => [
                'label' => "Bobot Penilaian Tugas Akhir",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                    'is_unique' => "{field} yang dimasukan Sudah ada",
                ],
            ],
            
        ];

        if ($this->validate($rules)) {
        $data = [
            'bobot_ujianproposal' => $bobot_ujianproposal,
            'bobot_seminarhasil' => $bobot_seminarhasil,
            'bobot_ujianta' => $bobot_ujianta,
            'updated_at' => $updated_at,
        ];
        //dd($data);
        $this->bobotpenilaian->update($id_bobot, $data);
        //dd($data);
        session()->setFlashdata('success', 'Data Bobot Penilaian Tugas Akhir Berhasil Diubah');
        return redirect()->to('simta/bobotpenilaian');

        } else {
            return view('simta/bobotpenilaian/edit', [
                'title' => 'Edit Data Bobot Penilaian',
                'bobotpenilaian' => $this->bobotpenilaian->find($id_bobot),
                'activePage' => 'bobotpenilaian',
                'validation' => $this->validation,
            ]);
        }
    }

    public function delete($id_bobot)
    {
        $data = $this->bobotpenilaian->find($id_bobot);
        $this->bobotpenilaian->delete($id_bobot);
        session()->setFlashdata('success', 'Data Bobot Penilaian Tugas Akhir Berhasil Dihapus');
        return redirect()->to('simta/bobotpenilaian');
    }
}