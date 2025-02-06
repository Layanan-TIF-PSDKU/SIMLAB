<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class RekomendasiMahasiswaModel extends Model
{
    protected $uuidFields       = ['id_rekomendasi_m'];
    protected $table            = 'sipema_rekomendasi_m';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_rekomendasi_m';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_rekomendasi_m', 'id_mhs', 'id_staf', 'id_sub_bidang', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_rekomendasi_m' => 'required'
    ];

    function getRekomendasiMahasiswa()
    {
        $builder = $this->db->table('sipema_rekomendasi_m');
        $builder->select('sipema_rekomendasi_m.*, sipema_sub_bidang.*, mahasiswa.nama as nama_mahasiswa, staf.nama as nama_dosen');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_rekomendasi_m.id_mhs');
        $builder->join('staf', 'staf.id_staf = sipema_rekomendasi_m.id_staf');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_rekomendasi_m.id_sub_bidang');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getCountPerSubBidang()
    {
        $builder = $this->db->table('sipema_rekomendasi_m');
        $builder->select('sipema_sub_bidang.nama_sub_bidang AS label, COUNT(*) AS data');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_rekomendasi_m.id_sub_bidang');
        $builder->groupBy('sipema_rekomendasi_m.id_sub_bidang');
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getRekomendasiMahasiswaById($id)
    {
        $builder = $this->db->table('sipema_rekomendasi_m');
        $builder->select('staf.nama, sipema_sub_bidang.nama_sub_bidang, mahasiswa.nama as nama_mahasiswa');
        $builder->join('sipema_sub_bidang', 'sipema_sub_bidang.id_sub_bidang = sipema_rekomendasi_m.id_sub_bidang');
        $builder->join('staf', 'staf.id_staf = sipema_rekomendasi_m.id_staf');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = sipema_rekomendasi_m.id_mhs');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where('mahasiswa.id_user', $id);
        return $builder->get()->getResultArray();
    }
}
