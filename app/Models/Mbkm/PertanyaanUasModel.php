<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class PertanyaanUasModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan_uas'];
    protected $table            = 'mbkm_pertanyaan_uas';
    protected $primaryKey       = 'id_pertanyaan_uas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan_uas', 'nama_mata_kuliah', 'jenis_penilai', 'pertanyaan','created_at', 'update_at'];
    protected $validationRules = [
        'id_pertanyaan_uas' => 'required'
    ];

    function getPertanyaanUas()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uas');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uas.id_mata_kuliah');
        $query = $builder->get();
        return $query->getResult();
    }
    function getPertanyaanMitraUas()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uas');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uas.id_mata_kuliah');
        $builder->where('jenis_penilai', 'mitra');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getPertanyaanDosenUas()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uas');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uas.id_mata_kuliah');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getTotalPertanyaanDosenUas()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uas');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uas.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get()->getResult();
        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
    public function getTotalPertanyaanMitraUas(){
        $builder = $this->db->table('mbkm_pertanyaan_uas');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uas.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'mitra');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
}