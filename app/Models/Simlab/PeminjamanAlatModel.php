<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class PeminjamanAlatModel extends Model
{
    protected $table = 'simlab_peminjaman_alat';
    protected $primaryKey = 'id_pinjam_alat';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_pinjam_alat', 'id_mahasiswa', 'id_staff', 'keperluan', 'tanggal_ajuan', 'tanggal_pinjam', 'tanggal_kembali', 'status_ajuan', 'waktu_konfirmasi_kembali', 'status_peminjaman', 'keterangan'];
    protected $validationRules = [
        'id_pinjam_alat' => 'required',
    ];

    public function getAlatDipinjam()
    {
        $builder = $this->db->table('simlab_peminjaman_alat');
        $builder->select('simlab_peminjaman_alat.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', 'staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->orderBy('tanggal_ajuan', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAlatDipinjamForDetail($id)
    {
        $builder = $this->db->table('simlab_peminjaman_alat');
        $builder->select('simlab_peminjaman_alat.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.no_telp as telp_mahasiswa, staf.*, staf.nama as nama_staff, staf.no_telp as telp_staff,');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', 'staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->where('simlab_peminjaman_alat.id_pinjam_alat', $id);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getAlatDipinjamById()
    {
        $user_id = user()->id;
        $builder = $this->db->table('simlab_peminjaman_alat');
        $builder->select('simlab_peminjaman_alat.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff, users.*,');
        // $builder->join('simlab_detail_peminjaman_alat', 'simlab_detail_peminjaman_alat.id_pinjam_alat = simlab_peminjaman_alat.id_pinjam_alat','left');
        // $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_detail_peminjaman_alat.id_alat', 'left');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', 'staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->join('users', 'users.id = mahasiswa.id_user OR users.id = staf.id_user');
        $builder->where('users.id', $user_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAlatDipinjamDisetujui($status_ajuan = 'Disetujui')
    {
        $builder = $this->db->table('simlab_detail_peminjaman_alat');
        $builder->select('simlab_peminjaman_alat.*, simlab_detail_peminjaman_alat.*, simlab_alat_laboratorium.*, simlab_ruang_laboratorium.*,mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff');
        $builder->join('simlab_peminjaman_alat', 'simlab_peminjaman_alat.id_pinjam_alat = simlab_detail_peminjaman_alat.id_pinjam_alat', 'left');
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_detail_peminjaman_alat.id_alat', 'left');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang', 'left');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', 'staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->where('simlab_peminjaman_alat.status_ajuan', $status_ajuan);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getFilterPeminjamanAlat($tanggal_awal, $tanggal_akhir, $status_ajuan = 'Disetujui')
    {
        $builder = $this->db->table('simlab_peminjaman_alat');
        $builder->select('simlab_peminjaman_alat.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, mahasiswa.no_telp as telp_mhs, staf.*, staf.nama as nama_staff, staf.no_telp as telp_staf, simlab_detail_peminjaman_alat.*, simlab_alat_laboratorium.*, simlab_ruang_laboratorium.*');
        $builder->join('simlab_detail_peminjaman_alat', ',simlab_detail_peminjaman_alat.id_pinjam_alat = simlab_peminjaman_alat.id_pinjam_alat', 'left');
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_detail_peminjaman_alat.id_alat', 'left');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', 'staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->where('simlab_peminjaman_alat.tanggal_pinjam >=', $tanggal_awal);
        $builder->where('simlab_peminjaman_alat.tanggal_pinjam <=', $tanggal_akhir);
        $builder->where('simlab_peminjaman_alat.status_ajuan', $status_ajuan);
        $query = $builder->get();
        return $query->getResult();
    }
}

class DetailPeminjamanAlatModel extends Model
{
    protected $table = 'simlab_detail_peminjaman_alat';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_pinjam_alat', 'id_alat', 'jumlah_pinjam', 'kondisi_pengembalian'];

    public function getDetailAlatDipinjam($id)
    {
        $builder = $this->db->table('simlab_detail_peminjaman_alat');
        $builder->select('*,  mahasiswa.nama as nama_mahasiswa, staf.nama as nama_staff');
        $builder->join('simlab_peminjaman_alat', 'simlab_peminjaman_alat.id_pinjam_alat = simlab_detail_peminjaman_alat.id_pinjam_alat', 'left');
        $builder->join('simlab_alat_laboratorium', 'simlab_alat_laboratorium.id_alat = simlab_detail_peminjaman_alat.id_alat');
        $builder->join('simlab_kategori', 'simlab_kategori.id_kategori = simlab_alat_laboratorium.id_kategori');
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_alat_laboratorium.id_ruang');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_alat.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_alat.id_staff', 'left');
        $builder->where('simlab_detail_peminjaman_alat.id_pinjam_alat', $id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function insertKondisiPengembalian($data)
    {
        $this->insert($data);
    }
    public function updateKondisiPengembalian($id_pinjam_alat, $id_alat, $kondisi_pengembalian)
    {
        $builder = $this->db->table('simlab_detail_peminjaman_alat');
        $builder->where('id_pinjam_alat', $id_pinjam_alat)
                ->where('id_alat', $id_alat)
                ->update(['kondisi_pengembalian' => $kondisi_pengembalian]);
    }

}
