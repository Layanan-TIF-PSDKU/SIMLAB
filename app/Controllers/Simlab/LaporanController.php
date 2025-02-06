<?php

namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Simlab\PenghapusanAsetModel;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Models\Simlab\JadwalRuangModel;
use App\Models\Simlab\PeminjamanAlatModel;
use App\Models\Simlab\DetailPeminjamanAlatModel;
use App\Models\Simlab\PeminjamanRuangModel;
use App\Models\Simlab\PerawatanAlatLabModel;
use App\Models\Simlab\RuangLaboratoriumModel;
use Dompdf\Dompdf;
use Myth\Auth\Models\GroupModel;

class LaporanController extends BaseController
{
    public function __construct()
    {
        $this->alatlab = new AlatLaboratoriumModel();
        $this->ruanglab = new RuangLaboratoriumModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->group = new GroupModel();
        $this->pinjamalat = new PeminjamanAlatModel();
        $this->detailpinjamalat = new DetailPeminjamanAlatModel();
        $this->pinjamruang = new PeminjamanRuangModel();
        $this->jadwal = new JadwalRuangModel();
        $this->perawatan = new PerawatanAlatLabModel();
        $this->penghapusanaset = new PenghapusanAsetModel();
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'title' => 'Laporan',
            'activePage' => 'laporan',
        ];

        return view('simlab/laporan/index', $data);
    }

    public function alatMasuk()
    {
        $data = [
            'title' => 'Laporan Alat Laboratorium Masuk',
            'ruanglab' => $this->ruanglab->findAll(),
            'alatlab' => $this->alatlab->getAlatLabBaik(),
            'activePage' => 'laporan/alat-masuk',
        ];
        return view('simlab/laporan/index_alat_masuk', $data);
    }

    public function getFilterAlatMasuk($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->alatlab->getFilterAlatMasuk($id_ruang, $tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function alatMasukPdf($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->alatlab->getFilterAlatMasuk($id_ruang, $tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_alat_masuk', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Laporan Alat Laboratorium Masuk.pdf');
    }

    public function alatRusak()
    {
        $data = [
            'title' => 'Laporan Alat Laboratorium Rusak',
            'ruanglab' => $this->ruanglab->findAll(),
            'alatlab' => $this->alatlab->getAlatLabRusak(),
            'activePage' => 'laporan/alat-rusak',
        ];
        return view('simlab/laporan/index_alat_rusak', $data);
    }

    public function getFilterAlatRusak($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->alatlab->getFilterAlatRusak($id_ruang, $tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function alatRusakPdf($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->alatlab->getFilterAlatRusak($id_ruang, $tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_alat_rusak', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Laporan Alat Laboratorium Rusak.pdf');
    }
    public function penghapusanAset()
    {
        $data = [
            'title' => 'Laporan Penghapusan Aset',
            'ruanglab' => $this->ruanglab->findAll(),
            'alatlab' => $this->penghapusanaset->getPenghapusanAset(),
            'activePage' => 'laporan/penghapusan-aset',
        ];
        return view('simlab/laporan/index_penghapusan_aset', $data);
    }

    public function getFilterPenghapusanAset($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->penghapusanaset->getFilterPenghapusanAset($id_ruang, $tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function penghapusanAsetPdf($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->penghapusanaset->getFilterPenghapusanAset($id_ruang, $tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_penghapusan_aset', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Laporan Penghapusan Aset Laboratorium.pdf');
    }
    public function perawatanAlat()
    {
        $data = [
            'title' => 'Laporan Perawatan Alat Laboratorium',
            'ruanglab' => $this->ruanglab->findAll(),
            'alatlab' => $this->perawatan->getPerawatanAlat(),
            'activePage' => 'laporan/perawatan-alat',
        ];
        return view('simlab/laporan/index_perawatan_alat', $data);
    }

    public function getFilterPerawatanAlat($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->perawatan->getFilterPerawatanAlat($id_ruang, $tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function perawatanAlatPdf($id_ruang, $tanggal_awal, $tanggal_akhir)
    {
        $data = $this->perawatan->getFilterPerawatanAlat($id_ruang, $tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_perawatan_alat', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Laporan Perawatan Alat Laboratorium.pdf');
    }

    public function ruangPraktikum()
    {
        $data = [
            'title' => 'Laporan Penggunaan Ruang Laboratorium',
            'ruanglab' => $this->ruanglab->findAll(),
            'jadwal' => $this->jadwal->getJadwal(),
            'activePage' => 'laporan/jadwal-praktikum',
        ];
        return view('simlab/laporan/index_jadwal_praktikum', $data);
    }

    public function getFilterRuangPraktikum($id_ruang, $tahun_ajaran, $semester)
    {
        $data = $this->jadwal->getFilterRuangPraktikum($id_ruang, $tahun_ajaran, $semester);
        // dd($data);
        return json_encode($data);
    }

    public function ruangPraktikumPdf($id_ruang, $tahun_ajaran, $semester)
    {
        $data = $this->jadwal->getFilterRuangPraktikum($id_ruang, $tahun_ajaran, $semester);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_ruang_praktikum', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'portrait');
        $pdf->render();
        $pdf->stream('Laporan Penggunaan Ruang.pdf');
    }

    public function peminjamanAlat()
    {
        $data = [
            'title' => 'Laporan Peminjaman Alat Laboratorium',
            'pinjamalat' => $this->pinjamalat->getAlatDipinjamDisetujui(),
            // 'detailpinjam' => $this->detailpinjamalat->getDetailAlatDipinjamDisetujui($id),
            'activePage' => 'laporan/peminjaman/alat-laboratorium',
        ];
        return view('simlab/laporan/index_peminjaman_alat', $data);
    }

    public function getFilterPeminjamanAlat($tanggal_awal, $tanggal_akhir)
    {
        $data = $this->pinjamalat->getFilterPeminjamanAlat($tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function peminjamanAlatPdf($tanggal_awal, $tanggal_akhir)
    {
        $data = $this->pinjamalat->getFilterPeminjamanAlat($tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_peminjaman_alat', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'landscape');
        $pdf->render();
        $pdf->stream('Laporan Peminjaman Alat Laboratorium.pdf');
    }
    public function peminjamanRuang()
    {
        $data = [
            'title' => 'Laporan Peminjaman Ruang Laboratorium',
            'pinjamruang' => $this->pinjamruang->getJadwal(),
            'activePage' => 'laporan/jadwal-praktikum',
        ];
        return view('simlab/laporan/index_peminjaman_ruang', $data);
    }

    public function getFilterPeminjamanRuang($tanggal_awal, $tanggal_akhir)
    {
        $data = $this->pinjamruang->getFilterPeminjamanRuang($tanggal_awal, $tanggal_akhir);
        return json_encode($data);
    }

    public function peminjamanRuangPdf($tanggal_awal, $tanggal_akhir)
    {
        $data = $this->pinjamruang->getFilterPeminjamanRuang($tanggal_awal, $tanggal_akhir);
        $pdf = new Dompdf(array('enable_remote' => true));
        $html = view('simlab/laporan/laporan_peminjaman_ruang', ['data' => $data]);
        $pdf->loadHtml($html);
        $pdf->setPaper('Legal', 'landscape');
        $pdf->render();
        $pdf->stream('Laporan Peminjaman Ruang Laboratorium.pdf');
    }

}