<?php

namespace App\Controllers\Simlab;

use App\Controllers\BaseController;
use App\Models\Bot\ChatbotUserMahasiswaModel;
use App\Models\Bot\ChatbotUserStaffModel;
use App\Models\Master\MahasiswaModel;
use App\Models\Master\StafModel;
use App\Models\Simlab\AlatLaboratoriumModel;
use App\Models\Simlab\DetailPeminjamanAlatModel;
use App\Models\Simlab\JadwalRuangModel;
use App\Models\Simlab\PeminjamanAlatModel;
use App\Models\Simlab\PeminjamanRuangModel;
use CodeIgniter\Config\Services;
use Myth\Auth\Models\GroupModel;

class TransaksiPeminjamanController extends BaseController
{
    protected $alatlab;
    public function __construct()
    {
        $this->alatlab = new AlatLaboratoriumModel();
        $this->mahasiswa = new MahasiswaModel();
        $this->staf = new StafModel();
        $this->UserMahasiswa = new ChatbotUserMahasiswaModel();
        $this->UserStaff = new ChatbotUserStaffModel();
        $this->group = new GroupModel();
        $this->pinjamalat = new PeminjamanAlatModel();
        $this->detailpinjamalat = new DetailPeminjamanAlatModel();
        $this->pinjamruang = new PeminjamanRuangModel();
        $this->jadwal = new JadwalRuangModel();
        $this->validation = \Config\Services::validation();
        $this->session = session();
    }

    public function index()
    {
        $data = [
            'title' => 'Transaksi Peminjaman',
            'activePage' => 'transaksi',
        ];
        // dd($data);
        return view('simlab/transaksi_peminjaman/index', $data);
    }
    public function dataPengajuanAlat()
    {
        $data = [
            'title' => 'Data Pengajuan Peminjaman Alat Laboratorium',
            'pengajuanalat' => $this->pinjamalat->getAlatDipinjam(),
            'activePage' => 'transaksi/konfirmasi-pengajuan-peminjaman',
        ];
        // dd($data);
        return view('simlab/transaksi_peminjaman/data_pengajuan_alat', $data);

    }
    public function dataPengajuanRuang()
    {
        $data = [
            'title' => 'Data Pengajuan Peminjaman Ruang Laboratorium',
            'pengajuanruang' => $this->pinjamruang->getRuangDipinjamPeminjam(),
            'activePage' => 'transaksi/konfirmasi-pengajuan-peminjaman',
        ];
        return view('simlab/transaksi_peminjaman/data_pengajuan_ruang', $data);

    }
    public function dataPeminjamanAlat()
    {
        $data = [
            'title' => 'Data Peminjaman Alat Laboratorium',
            'peminjamanalat' => $this->pinjamalat->getAlatDipinjam(),
            'activePage' => 'transaksi/konfirmasi-pengembalian',
        ];
        return view('simlab/transaksi_peminjaman/data_peminjaman_alat', $data);
    }
    public function detail_alat($id)
    {
        $detailpinjamalat = $this->detailpinjamalat->getDetailAlatDipinjam($id);
        $data = array(
            'detailpinjamalat' => $detailpinjamalat,
        );
        dd($data);
        // return json_encode($data);
    }
    public function dataPeminjamanRuang()
    {
        $data = [
            'title' => 'Data Peminjaman Ruang Laboratorium',
            'peminjamanruang' => $this->pinjamruang->getRuangDipinjamPeminjam(),
            'activePage' => 'transaksi/konfirmasi-pengembalian',
        ];
        return view('simlab/transaksi_peminjaman/data_peminjaman_ruang', $data);
    }
    public function verif_disetujui_alat($id)
    {
        $data = [
            'status_ajuan' => 'Disetujui',
            'status_peminjaman' => 'Sedang Digunakan',
        ];

        if ($data) {
            $pinjamalat = $this->pinjamalat->find($id);
            $detailpinjamalat = $this->detailpinjamalat->getDetailAlatDipinjam($id);

            $AlatTidakTersedia = [];
            $stokTersedia = true;
            foreach ($detailpinjamalat as $detail) {
                $alatlab = $this->alatlab->find($detail->id_alat);

                if ($alatlab->stok < $detail->jumlah_pinjam) {
                    $AlatTidakTersedia[] = $alatlab->nama_alat;
                    $stokTersedia = false;
                    break;
                }
            }
            if ($stokTersedia) {
                $update = $this->pinjamalat->update($id, $data);
                if ($update) {
                    foreach ($detailpinjamalat as $detail) {
                        $alatlab = $this->alatlab->find($detail->id_alat);
                        $stokBaru = $alatlab->stok - $detail->jumlah_pinjam;

                        $this->alatlab->update($detail->id_alat, ['stok' => $stokBaru]);
                    }
                    return redirect()->to('simlab/transaksi/konfirmasi-pengajuan-peminjaman/alat-laboratorium');
                }
            } else {
                return redirect()->back()->with('error', 'Alat tidak tersedia : ' . implode(', ', $AlatTidakTersedia));
            }
        }

    }
    public function verif_disetujui_ruang($id)
    {
        $pinjamruang = $this->pinjamruang->find($id);
        if ($pinjamruang) {
            $id_ruang = $pinjamruang->id_ruang;
            $hari = $pinjamruang->hari;
            $waktu_mulai = $pinjamruang->waktu_mulai;
            $waktu_selesai = $pinjamruang->waktu_selesai;
            $cekKetersediaanRuangByJadwalPraktikum = $this->jadwal->cekKetersediaanRuangByJadwalPraktikum($id_ruang, $hari, $waktu_mulai, $waktu_selesai);
            $cekKetersediaanRuangByPeminjaman = $this->pinjamruang->cekKetersediaanRuangByPeminjaman($id_ruang, $hari, $pinjamruang->tanggal_pinjam, $waktu_mulai, $waktu_selesai, $status_peminjaman = 'Sedang Digunakan');
            if (!$cekKetersediaanRuangByPeminjaman && !$cekKetersediaanRuangByJadwalPraktikum) {
                $data = [
                    'status_ajuan' => 'Disetujui',
                    'status_peminjaman' => 'Sedang Digunakan',
                ];
                $update = $this->pinjamruang->update($id, $data);
                if ($update) {
                    return redirect()->to('simlab/transaksi/konfirmasi-pengajuan-peminjaman/ruang-laboratorium');
                }
            } else {
                return redirect()->back()->with('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
            }
        }
        return redirect()->back()->with('error', 'Ruang laboratorium sudah digunakan pada hari dan waktu tersebut!');
    }

    public function verif_ditolak_alat($id)
    {
        $keterangan = $this->request->getVar('keterangan');
        $data = [
            'status_ajuan' => 'Ditolak',
            'keterangan' => $keterangan,
        ];
        $this->pinjamalat->update($id, $data);
        return redirect()->to('simlab/transaksi/konfirmasi-pengajuan-peminjaman/alat-laboratorium');
    }

    public function verif_ditolak_ruang($id)
    {
        $keterangan = $this->request->getVar('keterangan');
        $data = [
            'status_ajuan' => 'Ditolak',
            'keterangan' => $keterangan,
        ];
        $this->pinjamruang->update($id, $data);
        return redirect()->to('simlab/transaksi/konfirmasi-pengajuan-peminjaman/ruang-laboratorium');
    }

    public function verif_pengembalian_alat($id)
    {
        $data = [
            'status_peminjaman' => 'Dikembalikan',
            'waktu_konfirmasi_kembali' => round(microtime(true) * 1000),
        ];
        $this->pinjamalat->update($id, $data);

        $detailpinjamalat = $this->detailpinjamalat->getDetailAlatDipinjam($id);
  
        foreach ($detailpinjamalat as $detail) {
            $alat = $this->alatlab->find($detail->id_alat);
            $stokBaru = $alat->stok + $detail->jumlah_pinjam;
            $this->alatlab->update($detail->id_alat, ['stok' => $stokBaru]);
            $kondisi_pengembalian = $this->request->getPost('kondisi_pengembalian');
        $kondisi_alat = $kondisi_pengembalian[$detail->id_pinjam_alat][$detail->id_alat];

        // Update kondisi_pengembalian untuk setiap baris berdasarkan id_pinjam_alat dan id_alat
        $this->detailpinjamalat->updateKondisiPengembalian($detail->id_pinjam_alat, $detail->id_alat, $kondisi_alat);
        }
        return redirect()->to('simlab/transaksi/konfirmasi-pengembalian/alat-laboratorium');
    }

    public function verif_pengembalian_ruang($id)
    {
        $data = [
            'status_peminjaman' => 'Dikembalikan',
            'waktu_konfirmasi_kembali' => round(microtime(true) * 1000),
        ];
        $this->pinjamruang->update($id, $data);
        return redirect()->to('simlab/transaksi/konfirmasi-pengembalian/ruang-laboratorium');
    }

    public function riwayat_peminjaman_alat()
    {
        $data = [
            'title' => 'Riwayat Peminjaman Alat Laboratorium',
            'peminjamanalat' => $this->pinjamalat->getAlatDipinjam(),
            'activePage' => 'transaksi/riwayat-peminjaman',
        ];
        return view('simlab/transaksi_peminjaman/riwayat_peminjaman_alat', $data);
    }
    public function riwayat_peminjaman_ruang()
    {
        $data = [
            'title' => 'Riwayat Peminjaman Ruang Laboratorium',
            'peminjamanruang' => $this->pinjamruang->getRuangDipinjamPeminjam(),
            'activePage' => 'transaksi/riwayat-peminjaman',
        ];
        return view('simlab/transaksi_peminjaman/riwayat_peminjaman_ruang', $data);
    }
}