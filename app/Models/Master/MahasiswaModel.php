<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $uuidFields       = ['id_mhs'];
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mhs';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mhs', 'id_user', 'nama', 'nim', 'prodi', 'no_telp', 'th_masuk', 'th_lulus', 'kelas', 'status'];
    protected $validationRules = [
        'id_mhs' => 'required'
    ];

    public function getMahasiswabyUserId()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mahasiswa');
        $builder->select('*');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where('id_user', $user_id);
        $query = $builder->get();
        return $query->getResult();  
    }

    public function getDataMataKuliah($id_bidang, $id_mhs, $id_sub_bidang = null)
    {
        $builder = $this->db->table('mahasiswa');
        $builder->select('mk.kode_mata_kuliah, mk.nama_mata_kuliah, mk.sks, ssb.nama_sub_bidang');
        $builder->join('sipema_nilai sn', 'mahasiswa.id_mhs = sn.id_mhs');
        $builder->join('mata_kuliah mk', 'sn.id_mata_kuliah = mk.id_mata_kuliah');
        $builder->join('sipema_pemetaan_mata_k spk', 'mk.id_mata_kuliah = spk.id_mata_kuliah');
        $builder->join('sipema_hasil_pemetaan_k shpk', 'spk.id_sub_bidang = shpk.id_sub_bidang AND shpk.id_mhs = mahasiswa.id_mhs');
        $builder->join('sipema_sub_bidang ssb', 'shpk.id_sub_bidang = ssb.id_sub_bidang');
        $builder->join('sipema_bidang sb', 'ssb.id_bidang = sb.id_bidang');
        if($id_sub_bidang != null){
            $builder->where('mahasiswa.id_mhs', $id_mhs);
            $builder->where('sb.id_bidang', $id_bidang);
            $builder->where('ssb.id_sub_bidang', $id_sub_bidang);
        }else if($id_sub_bidang == null){
            $builder->where('mahasiswa.id_mhs', $id_mhs);
            $builder->where('sb.id_bidang', $id_bidang);
        } 
        $query = $builder->get();
        return $query->getResult();  
    }

    public function getMahasiswa($id_mhs){
        $builder = $this->db->table('mahasiswa');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where('mahasiswa.id_mhs', $id_mhs);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getUniqueKelas(){
        $builder = $this->db->table('mahasiswa');
        $builder->select('kelas');
        $builder->groupBy('kelas');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAngkatanMahasiswa(){
        $builder = $this->db->table('mahasiswa');
        $builder->select('th_masuk');
        $builder->groupBy('th_masuk');
        $query = $builder->get();
        return $query->getResult();
    }
}