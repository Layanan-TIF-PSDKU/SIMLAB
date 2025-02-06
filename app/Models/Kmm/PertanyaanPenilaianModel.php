<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class PertanyaanPenilaianModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan'];
    protected $table            = 'simkmm_pertanyaan_nilai';
    protected $primaryKey       = 'id_pertanyaan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan', 'pertanyaan', 'jenis_pertanyaan', 'nilai_maks', 'created_at', 'updated_at'];

    public function getPertanyaanDosen(){
        $builder = $this->db->table('simkmm_pertanyaan_nilai');
        $builder->where('jenis_pertanyaan', 'dosen');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getPertanyaanMitra(){
        $builder = $this->db->table('simkmm_pertanyaan_nilai');
        $builder->where('jenis_pertanyaan', 'mitra');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getTotalNilaiMaksPertanyaanDosen(){
        $builder = $this->db->table('simkmm_pertanyaan_nilai');
        $builder->where('jenis_pertanyaan', 'dosen');
        $builder->selectSum('nilai_maks');
        $query = $builder->get();
        return $query->getResult();
    }
}