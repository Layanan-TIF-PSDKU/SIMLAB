<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $uuidFields       = ['id_penilaian'];
    protected $table            = 'simkmm_penilaian';
    protected $primaryKey       = 'id_penilaian';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_penilaian', 'id_kmm', 'id_pertanyaan', 'nilai'];

    public function getTotalNilaiDosen($id_kmm){
        $builder = $this->db->table('simkmm_penilaian');
        $builder->join('simkmm_pertanyaan_nilai','simkmm_pertanyaan_nilai.id_pertanyaan = simkmm_penilaian.id_pertanyaan');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_penilaian.id_kmm');
        $builder->selectSum('nilai');
        $builder->where('simkmm_pertanyaan_nilai.jenis_pertanyaan', 'dosen');
        $builder->where('simkmm_penilaian.id_kmm', $id_kmm);
        $builder->groupBy('simkmm_penilaian.id_kmm');
        $query = $builder->get()->getResult(); 

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }
    
    public function getTotalNilaiMitra($id_kmm){
        $builder = $this->db->table('simkmm_penilaian');
        $builder->join('simkmm_pertanyaan_nilai','simkmm_pertanyaan_nilai.id_pertanyaan = simkmm_penilaian.id_pertanyaan');
        $builder->join('simkmm_kmm','simkmm_kmm.id_kmm = simkmm_penilaian.id_kmm');
        $builder->selectAvg('nilai');
        $builder->where('simkmm_pertanyaan_nilai.jenis_pertanyaan', 'mitra');
        $builder->where('simkmm_penilaian.id_kmm', $id_kmm);
        $builder->groupBy('simkmm_penilaian.id_kmm');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }

    public function getPenilaian(){
        $builder = $this->db->table('simkmm_penilaian');
        $builder->select('simkmm_penilaian.*');
        $builder->join('simkmm_kmm', 'simkmm_kmm.id_kmm = simkmm_penilaian.id_kmm');
        $builder->join('simkmm_pertanyaan_nilai', 'simkmm_pertanyaan_nilai.id_pertanyaan = simkmm_penilaian.id_pertanyaan');
        $builder->where('simkmm_pertanyaan_nilai.jenis_pertanyaan', 'dosen');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getPenilaianMitra(){
        $builder = $this->db->table('simkmm_penilaian');
        $builder->select('simkmm_penilaian.*');
        $builder->join('simkmm_kmm', 'simkmm_kmm.id_kmm = simkmm_penilaian.id_kmm');
        $builder->join('simkmm_pertanyaan_nilai', 'simkmm_pertanyaan_nilai.id_pertanyaan = simkmm_penilaian.id_pertanyaan');
        $builder->where('simkmm_pertanyaan_nilai.jenis_pertanyaan', 'mitra');
        $query = $builder->get();
        return $query->getResult();
    }
    
}