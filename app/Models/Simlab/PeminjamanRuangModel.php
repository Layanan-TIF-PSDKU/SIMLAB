<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class PeminjamanRuangModel extends Model
{
    protected $table      = 'simlab_peminjaman_ruang';
    protected $primaryKey = 'id_pinjam_ruang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_pinjam_ruang','id_ruang', 'id_staff', 'id_mahasiswa','keperluan', 'tanggal_ajuan', 'hari', 'tanggal_pinjam','waktu_mulai', 'waktu_selesai', 'status_ajuan', 'waktu_konfirmasi_kembali','status_peminjaman', 'keterangan'];
    protected $validationRules = [
        'id_pinjam_ruang' => 'required'
    ];

    function getRuangDipinjam($id_ruang)
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*,simlab_ruang_laboratorium.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff'); 
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->where('simlab_peminjaman_ruang.id_ruang', $id_ruang);
        $builder->orderBy('tanggal_pinjam', 'ASC');
        $builder->orderBy('hari', 'ASC');
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    
    function getRuangDipinjamAll($id)
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*,simlab_ruang_laboratorium.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa,mahasiswa.no_telp as telp_mahasiswa, staf.*, staf.nama as nama_staff, staf.no_telp as telp_staff'); 
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->where('simlab_peminjaman_ruang.id_pinjam_ruang', $id);
        $builder->orderBy('tanggal_pinjam', 'ASC');
        $builder->orderBy('hari', 'ASC');
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getRow();
    }

    public function cekKetersediaanRuangByPeminjaman($id_ruang, $hari, $tanggal_pinjam, $waktu_mulai, $waktu_selesai, $status_peminjaman='Sedang Digunakan')
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->where('id_ruang', $id_ruang);
        $builder->where('hari', $hari);
        $builder->where('tanggal_pinjam', $tanggal_pinjam);
        $builder->where('waktu_mulai <', $waktu_selesai);
        $builder->where('waktu_selesai >', $waktu_mulai);
        $builder->where('status_peminjaman', $status_peminjaman);
        return $builder->countAllResults();
}

        function getRuangDipinjamById(){
        $user_id = user()->id;
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*,simlab_ruang_laboratorium.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff, users.*'); 
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->join('users', 'users.id = mahasiswa.id_user OR users.id = staf.id_user');
        $builder->where('users.id', $user_id);
        $query = $builder->get();
        return $query->getResult();
    }

    function getRuangDipinjamPeminjam()
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*,simlab_ruang_laboratorium.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff'); 
        $builder->join('simlab_ruang_laboratorium', 'simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->orderBy('tanggal_ajuan', 'ASC');
        $builder->orderBy('tanggal_pinjam', 'ASC');
        $builder->orderBy('hari', 'ASC');
        $builder->orderBy('waktu_mulai', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    function getJadwal($status_ajuan = 'Disetujui')
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff, simlab_ruang_laboratorium.*'); 
        $builder->join('simlab_ruang_laboratorium', ',simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang', 'left');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->where('simlab_peminjaman_ruang.status_ajuan', $status_ajuan);
        $query = $builder->get();
        return $query->getResult();
    }
    function getFilterPeminjamanRuang($tanggal_awal, $tanggal_akhir, $status_ajuan = 'Disetujui')
    {
        $builder = $this->db->table('simlab_peminjaman_ruang');
        $builder->select('simlab_peminjaman_ruang.*, mahasiswa.*, mahasiswa.nama as nama_mahasiswa, staf.*, staf.nama as nama_staff, simlab_ruang_laboratorium.*'); 
        $builder->join('simlab_ruang_laboratorium', ',simlab_ruang_laboratorium.id_ruang = simlab_peminjaman_ruang.id_ruang', 'left');
        $builder->join('mahasiswa', ',mahasiswa.id_mhs = simlab_peminjaman_ruang.id_mahasiswa', 'left');
        $builder->join('staf', ',staf.id_staf = simlab_peminjaman_ruang.id_staff', 'left');
        $builder->where('simlab_peminjaman_ruang.tanggal_pinjam >=', $tanggal_awal);
        $builder->where('simlab_peminjaman_ruang.tanggal_pinjam <=', $tanggal_akhir);
        $builder->where('simlab_peminjaman_ruang.status_ajuan', $status_ajuan);
        $query = $builder->get();
        return $query->getResult();
    }
}
?>