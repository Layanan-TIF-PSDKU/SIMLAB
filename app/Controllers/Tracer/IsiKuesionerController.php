<?php

namespace App\Controllers\Tracer;

use App\Models\Tracer\JadwalKuesionerModel;
use App\Models\Tracer\PertanyaanModel;
use App\Models\Tracer\PertanyaanIsianModel;
use App\Models\Tracer\JawabanKuesionerModel;
use App\Models\Tracer\JawabanIsianModel;
use App\Models\Master\MahasiswaModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Dompdf\Dompdf;

class IsiKuesionerController extends BaseController
{   
    public function __construct()
    {
        $this->jadwal_kuesioner = new JadwalKuesionerModel();
        $this->pertanyaan_kuesioner = new PertanyaanModel();
        $this->pertanyaan_isian = new PertanyaanIsianModel();
        $this->jawaban_kuesioner = new JawabanKuesionerModel();
        $this->jawaban_isian = new JawabanIsianModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->validation = \Config\Services::validation();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Isi Kuesioner',
            'jadwal_kuesioner' => $this->jadwal_kuesioner->getJenisKuesioner(),
            'activePage' => 'jadwal_kuesioner'
        ];
        return view('tracer/isi_kuesioner/index', $data);
    }

    public function mengisi($id)
    {
        $data = [
            'title' => 'Halaman Pengisian Kuesioner',
            'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->findAll(),
            'pertanyaan_isian' => $this->pertanyaan_isian->findAll(),
            'jawaban_kuesioner' => $this->jawaban_kuesioner->findAll(),
            'jawaban_isian' => $this->jawaban_isian->findAll(),
            'jadwal_kuesioner' => $this->jadwal_kuesioner->find($id),
            'activePage' => 'jadwal_kuesioner',
            'validation' => $this->validation,
        ];
        
        return view('tracer/isi_kuesioner/mengisi', $data);
    }
    
    public function simpan()
    {
        $validation =  \Config\Services::validation();
        $id_jadwal_kuesioner = $this->request->getPost('id_jadwal_kuesioner');
        $id_user = $this->request->getPost('id_user');
        $id_pertanyaan = $this->request->getPost('id_pertanyaan');
        $pertanyaan = $this->request->getPost('pertanyaan');
        $pilihan = $this->request->getPost('pilihan');
        
        $id_jadwal_kuesioner_isian = $this->request->getPost('id_jadwal_kuesioner_isian');
        $id_user_isian = $this->request->getPost('id_user_isian');
        $id_pertanyaan_isian = $this->request->getPost('id_pertanyaan_isian');
        $pertanyaan_isian = $this->request->getPost('pertanyaan_isian');
        $isian = $this->request->getPost('isian');
        
        $rules = [
            'pilihan' => [
                'label' => "Anda harus memilih jawaban",
                'rules' => "required",
                'errors' => [
                    'required' => "{field} harus diisi",
                ]
            ],
        ];
        
        if($this->validate($rules)) {
            for ($i = 0; $i < count($id_pertanyaan); $i++) {
                $data = [
                    'id_jadwal_kuesioner' => $id_jadwal_kuesioner,
                    'id_user' => $id_user,
                    'id_pertanyaan' => $id_pertanyaan[$i],
                    'pertanyaan' => $pertanyaan[$i],
                    'pilihan' => $pilihan[$i],
                ];
            $this->jawaban_kuesioner->insert($data);
            }
            for ($i = 0; $i < count($id_pertanyaan_isian); $i++) {
                $data2 = [
                    'id_jadwal_kuesioner_isian' => $id_jadwal_kuesioner_isian,
                    'id_user_isian' => $id_user_isian,
                    'id_pertanyaan_isian' => $id_pertanyaan_isian[$i],
                    'pertanyaan_isian' => $pertanyaan_isian[$i],
                    'isian' => $isian[$i],
                ];
            $this->jawaban_isian->insert($data2);
            }
            session()->setFlashdata('kuesioner', 'Anda sudah mengisi kuesioner');
            return redirect()->to(base_url('tracer/isi_kuesioner'))->with('status_icon', 'kuesioner')->with('status_text', 'Anda sudah mengisi kuesioner');
        } else {
            return view('tracer/isi_kuesioner/mengisi', [
                'title' => 'Halaman Pengisian Kuesioner',
                'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->findAll(),
                'pertanyaan_isian' => $this->pertanyaan_isian->findAll(),
                'jawaban_kuesioner' => $this->jawaban_kuesioner->findAll(),
                'jawaban_isian' => $this->jawaban_isian->findAll(),
                'jadwal_kuesioner' => $this->jadwal_kuesioner->find($id),
                'activePage' => 'jadwal_kuesioner',
                'validation' => $this->validation,
            ]);
        }
    }
    
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Agenda',
            'agenda' => $this->agenda->find($id),
            'validation' => $this->validation,
            'activePage' => 'agenda'
        ];
        return view('tracer/agenda/edit', $data);
    }

    public function update()
    {
        $validation =  \Config\Services::validation();
        $uuid =  Uuid::uuid4();
        $id_jawaban = $uuid->toString();
        $id_jadwal_kuesioner = $this->request->getVar('id_jadwal_kuesioner');
        $id_user = $this->request->getVar('id_user');
        $id_pertanyaan = $this->request->getVar('id_pertanyaan');
        $pilihan = $this->request->getVar('pilihan');
        $rules = [
            
        ];
        
        if($this->validate($rules)) {
            $data = [
                'id_jawaban' => $uuid,
                'id_jadwal_kuesioner' => $id_jadwal_kuesioner,
                'id_user' => $id_user,
                'id_pertanyaan' => $id_pertanyaan,
                'pilihan' => $pilihan,
            ];
            $this->jawaban_kuesioner->insert($data);
            session()->setFlashdata('success', 'Mengisi Pertanyaan Kuesioner');
            return redirect()->to('tracer/isi_kuesioner')->with('status_icon', 'success')->with('status_text', 'Data Berhasil mengisi');
        } else {
            return view('tracer/isi_kuesioner/mengisi', [
                'title' => 'Halaman Pengisian Kuesioner',
                'pertanyaan_kuesioner' => $this->pertanyaan_kuesioner->findAll(),
                'jadwal_kuesioner' => $this->jadwal_kuesioner->getJenisKuesioner(),
                'activePage' => 'jadwal_kuesioner',
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

    public function BuktiMengisiKuesioner()
    {
        $dompdf = new Dompdf();

        $data = [ 'mahasiswa' => $this->mahasiswa->getMahasiswabyUserId(),];
       
        $html = view('tracer/isi_kuesioner/bukti', $data);
        
    
        $dompdf->loadHtml($html);
    
        $dompdf->setPaper('A4', 'landscape');
    
        $dompdf->render();
    
        $dompdf->stream('Cetak Bukti Mengisi Kuesioner.pdf');
    }
}