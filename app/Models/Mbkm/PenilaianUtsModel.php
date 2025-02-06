<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class PenilaianUtsModel extends Model
{
    protected $uuidFields = ['id_penilaian_uts'];
    protected $table = 'mbkm_penilaian_uts';
    protected $primaryKey = 'id_penilaian_uts';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_penilaian_uts', 'id_mbkm_fix', 'id_pertanyaan_uts', 'nilai', 'nilai_mitra_uts'];
    protected $validationRules = [
        'id_penilaian_uts' => 'required',
    ];

    public function getTotalNilaiDosenUts($id_mbkm_fix)
    {
        $builder = $this->db->table('mbkm_penilaian_uts');
        $builder->join('mbkm_pertanyaan_uts', 'mbkm_pertanyaan_uts.id_pertanyaan_uts = mbkm_penilaian_uts.id_pertanyaan_uts');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uts.id_mbkm_fix');
        $builder->selectAvg('nilai');
        $builder->where('mbkm_pertanyaan_uts.jenis_penilai', 'dosen');
        $builder->where('mbkm_penilaian_uts.id_mbkm_fix', $id_mbkm_fix);       
        $builder->groupBy('mbkm_penilaian_uts.id_mbkm_fix');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }

    public function getTotalNilaiMitraUts($id_mbkm_fix)
    {
        $builder = $this->db->table('mbkm_penilaian_uts');
        $builder->join('mbkm_pertanyaan_uts', 'mbkm_pertanyaan_uts.id_pertanyaan_uts = mbkm_penilaian_uts.id_pertanyaan_uts');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uts.id_mbkm_fix');
        $builder->selectAvg('nilai');
        $builder->where('mbkm_pertanyaan_uts.jenis_penilai', 'mitra');
        $builder->where('mbkm_penilaian_uts.id_mbkm_fix', $id_mbkm_fix); 
        $builder->groupBy('mbkm_fix.id_mbkm_fix');
        $query = $builder->get()->getResult();
        foreach ($query as $key => $value) {
            return $value->nilai;
        
        }
    }
    public function getPenilaianDsn($id_mbkm_fix){
        $builder = $this->db->table('mbkm_penilaian_uts');
        $builder->select('mbkm_penilaian_uts.*');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uts.id_mbkm_fix');
        $builder->join('mbkm_pertanyaan_uts', 'mbkm_pertanyaan_uts.id_pertanyaan_uts = mbkm_penilaian_uts.id_pertanyaan_uts');
        $builder->where('mbkm_pertanyaan_uts.jenis_penilai', 'dosen');
        $builder->where('mbkm_penilaian_uts.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getPenilaianMtr($id_mbkm_fix){
        $builder = $this->db->table('mbkm_penilaian_uts');
        $builder->select('mbkm_penilaian_uts.*');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uts.id_mbkm_fix');
        $builder->join('mbkm_pertanyaan_uts', 'mbkm_pertanyaan_uts.id_pertanyaan_uts = mbkm_penilaian_uts.id_pertanyaan_uts');
        $builder->where('mbkm_pertanyaan_uts.jenis_penilai', 'mitra');
        $builder->where('mbkm_penilaian_uts.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
}