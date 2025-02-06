<?php

namespace App\Controllers;

use App\Models\Tracer\CmsModel;
use App\Models\Tracer\FaqModel;
use App\Models\Tracer\AlumniBerprestasiModel;
use App\Models\Tracer\LowonganKerjaModel;
use App\Models\Tracer\InformasiMagangModel;
use App\Models\Tracer\TipsKarirModel;
use App\Controllers\BaseController;

class LandingController extends BaseController
{
    public function __construct()
    {
        $this->cms = new CmsModel();
        $this->faq = new FaqModel();
        $this->alumni_berprestasi = new AlumniBerprestasiModel();
        $this->lowongan_kerja = new LowonganKerjaModel();
        $this->informasi_magang = new InformasiMagangModel();
        $this->tips_karir = new TipsKarirModel();
        $this->validation = \Config\Services::validation();
    }

    /* Fungsi untuk menampilkan halaman landing */
    public function index()
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'page' => 'Home',
            'cms' => $this->cms->getWarna(),
            'faq' => $this->faq->findAll(),
            'alumni_berprestasi' => $this->alumni_berprestasi->findAll(),
        ];
        return view('landing/index', $data);
    }

    public function sistem_informasi()
    {
        $data = [
            'title' => 'Sistem Informasi | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'cms' => $this->cms->getWarna(),
            'page' => 'Sistem Informasi',
        ];
        return view('landing/sistem_informasi', $data);
    }

    public function Kerja()
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'lowongan_kerja' => $this->lowongan_kerja->findAll(),
            'cms' => $this->cms->getWarna(),
            'page' => 'Lowongan Kerja'
        ];
        return view('landing/lowongan_kerja', $data);
    }

    public function kerja_detail($id)
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'lowongan_kerja' => $this->lowongan_kerja->find($id),
            'cms' => $this->cms->getWarna(),
            'page' => 'Lowongan Kerja'
        ];
        return view('landing/lowongan_kerja_detail', $data);
    }

    public function magang()
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'informasi_magang' => $this->informasi_magang->findAll(),
            'cms' => $this->cms->getWarna(),
            'page' => 'Informasi Magang'
        ];
        return view('landing/informasi_magang', $data);
    }

    public function magang_detail($id)
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'informasi_magang' => $this->informasi_magang->find($id),
            'cms' => $this->cms->getWarna(),
            'page' => 'Informasi Magang'
        ];
        return view('landing/informasi_magang_detail', $data);
    }

    public function tips_karir()
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'tips_karir' => $this->tips_karir->findAll(),
            'cms' => $this->cms->getWarna(),
            'page' => 'Tips Karir'
        ];
        return view('landing/tips_karir', $data);
    }

    public function tips_karir_detail($id)
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'tips_karir' => $this->tips_karir->find($id),
            'cms' => $this->cms->getWarna(),
            'page' => 'Tips Karir'
        ];
        return view('landing/tips_karir_detail', $data);
    }

    public function agenda()
    {
        $data = [
            'title' => 'Landing | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'cms' => $this->cms->getWarna(),
            'page' => 'Agenda'
        ];
        return view('landing/agenda', $data);
    }

    public function sipema_info()
    {
        $data = [
            'title' => 'About SIPEMA | Sistem Informasi Prodi D3 Teknik Informatika Madiun',
            'cms' => $this->cms->getWarna(),
            'page' => 'About SIPEMA'
        ];
        return view('landing/sipema_info', $data);
    } 

    public function tracer_info()
    {
        $data = [
            'title' => 'About TRACER | TRACER Study Prodi D3 Teknik Informatika Madiun',
            'cms' => $this->cms->getWarna(),
            'page' => 'About TRACER'
        ];
        return view('landing/tracer_info', $data);
    } 

}

