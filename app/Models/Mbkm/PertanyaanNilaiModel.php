<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class PertanyaanNilaiModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan_nilai'];
    protected $table            = 'mbkm_pertanyaan_nilai';
    protected $primaryKey       = 'id_pertanyaan_nilai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan_nilai', 'id_mata_kuliah', 'jenis_penilai', 'pertanyaan','created_at', 'update_at'];
    protected $validationRules = [
        'id_pertanyaan_nilai' => 'required'
    ];

    function getPertanyaan()
    {
        $builder = $this->db->table('mbkm_pertanyaan_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_nilai.id_mata_kuliah');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getPertanyaanDosen()
    {
        $builder = $this->db->table('mbkm_pertanyaan_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_nilai.id_mata_kuliah');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getTotalPertanyaanDosen()
    {
        $builder = $this->db->table('mbkm_pertanyaan_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_nilai.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'dosen');
        $query = $builder->get()->getResult();
        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
    public function getTotalPertanyaanMitra(){
        $builder = $this->db->table('mbkm_pertanyaan_nilai');
        $builder->join('mata_kuliah', 'mata_kuliah.id_mata_kuliah = mbkm_pertanyaan_nilai.id_mata_kuliah');
        $builder->selectCount('pertanyaan');
        $builder->where('jenis_penilai', 'mitra');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->pertanyaan;
        }
    }
}