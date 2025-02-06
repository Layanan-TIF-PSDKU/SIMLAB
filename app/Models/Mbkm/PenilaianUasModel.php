<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class PenilaianUasModel extends Model
{
    protected $uuidFields = ['id_penilaian_uas'];
    protected $table = 'mbkm_penilaian_uas';
    protected $primaryKey = 'id_penilaian_uas';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_penilaian_uas', 'id_mbkm_fix', 'id_pertanyaan_uas', 'nilai'];
    protected $validationRules = [
        'id_penilaian_uas' => 'required',
    ];

    public function getPenilaianUasDsn($id_mbkm_fix){
        $builder = $this->db->table('mbkm_penilaian_uas');
        $builder->select('mbkm_penilaian_uas.*');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uas.id_mbkm_fix');
        $builder->join('mbkm_pertanyaan_uas', 'mbkm_pertanyaan_uas.id_pertanyaan_uas = mbkm_penilaian_uas.id_pertanyaan_uas');
        $builder->where('mbkm_pertanyaan_uas.jenis_penilai', 'dosen');
        $builder->where('mbkm_penilaian_uas.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getPenilaianUasMtr($id_mbkm_fix){
        $builder = $this->db->table('mbkm_penilaian_uas');
        $builder->select('mbkm_penilaian_uas.*');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uas.id_mbkm_fix');
        $builder->join('mbkm_pertanyaan_uas', 'mbkm_pertanyaan_uas.id_pertanyaan_uas = mbkm_penilaian_uas.id_pertanyaan_uas');
        $builder->where('mbkm_pertanyaan_uas.jenis_penilai', 'mitra');
        $builder->where('mbkm_penilaian_uas.id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getTotalNilaiDosenUas($id_mbkm_fix)
    {
        $builder = $this->db->table('mbkm_penilaian_uas');
        $builder->join('mbkm_pertanyaan_uas', 'mbkm_pertanyaan_uas.id_pertanyaan_uas = mbkm_penilaian_uas.id_pertanyaan_uas');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uas.id_mbkm_fix');
        $builder->selectAvg('nilai');
        $builder->where('mbkm_pertanyaan_uas.jenis_penilai', 'dosen');
        $builder->where('mbkm_penilaian_uas.id_mbkm_fix', $id_mbkm_fix);       
        $builder->groupBy('mbkm_penilaian_uas.id_mbkm_fix');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }

    public function getTotalNilaiMitraUas($id_mbkm_fix)
    {
        $builder = $this->db->table('mbkm_penilaian_uas');
        $builder->join('mbkm_pertanyaan_uas', 'mbkm_pertanyaan_uas.id_pertanyaan_uas = mbkm_penilaian_uas.id_pertanyaan_uas');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_penilaian_uas.id_mbkm_fix');
        $builder->selectAvg('nilai');
        $builder->where('mbkm_pertanyaan_uas.jenis_penilai', 'mitra');
        $builder->where('mbkm_penilaian_uas.id_mbkm_fix', $id_mbkm_fix); 
        $builder->groupBy('mbkm_fix.id_mbkm_fix');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }
}