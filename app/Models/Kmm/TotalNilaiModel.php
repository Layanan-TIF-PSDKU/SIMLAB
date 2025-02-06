<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class TotalNilaiModel extends Model
{
    protected $uuidFields       = ['id_total_nilai'];
    protected $table            = 'simkmm_total_nilai';
    protected $primaryKey       = 'id_total_nilai';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_total_nilai', 'id_kmm', 'nilai_total_dosen','nilai_total_mitra' , 'nilai_akhir'];

    public function getPenilaian(){
        $builder = $this->db->table('simkmm_total_nilai');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_total_nilai.id_kmm');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getPenilaianDosen(){
        $builder = $this->db->table('simkmm_total_nilai');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_total_nilai.id_kmm');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->where('staf.id_user', user()->id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getTotalNilai($id_kmm){
        $builder = $this->db->table('simkmm_total_nilai');
        $builder->where('id_kmm', $id_kmm);
        $query = $builder->get();
        return $query->getRow();
    }

    function getFilterDataNilai($th_masuk)
    {
        $builder = $this->db->table('simkmm_total_nilai');
        $builder->select('simkmm_total_nilai.*, simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_total_nilai.id_kmm');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterDataNilaiByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_total_nilai');
        $builder->select('simkmm_total_nilai.*, simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_total_nilai.id_kmm');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
}