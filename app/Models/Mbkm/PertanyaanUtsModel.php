<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class PertanyaanUtsModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan_uts'];
    protected $table            = 'mbkm_pertanyaan_uts';
    protected $primaryKey       = 'id_pertanyaan_uts';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan_uts', 'nama_mata_kuliah', 'jenis_penilai', 'pertanyaan','created_at', 'update_at'];
    protected $validationRules = [
        'id_pertanyaan_uts' => 'required'
    ];

    function getPertanyaanUts()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uts');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uts.id_mata_kuliah');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getPertanyaanDosenUts()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uts');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uts.id_mata_kuliah');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getTotalPertanyaanDosenUts()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uts');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uts.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get()->getResult();
        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
    function getPertanyaanMitraUts()
    {
        $builder = $this->db->table('mbkm_pertanyaan_uts');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uts.id_mata_kuliah');
        $builder->where('jenis_penilai', 'mitra');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getTotalPertanyaanMitraUts(){
        $builder = $this->db->table('mbkm_pertanyaan_uts');
        // $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_uts.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'mitra');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
}