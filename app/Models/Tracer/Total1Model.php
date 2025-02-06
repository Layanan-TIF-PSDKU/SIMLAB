<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class Total1Model extends Model
{
    protected $table            = 'tracer_jawaban_kuesioner';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_jadwal_kuesioner';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_jadwal_kuesioner', 'id_pertanyaan', 'pilihan'];
    protected $validationRules = [
        'id_jadwal_kuesioner' => 'required', 
    ];

    public function countS()
    {
        $this->select('id_pertanyaan, COUNT(*) as jumlah');
        $this->groupBy(['id_pertanyaan']);
        $query = $this->get();
        return $query->getResult();
    }

    public function countP()
    {
        $this->select('pilihan, COUNT(*) as jumlah');
        $this->groupBy(['pilihan']);
        $query = $this->get();
        return $query->getResult();
    }


    public function hitungJumlahDataSama()
    {
        return $this->groupBy('pilihan, isian, pertanyaan, id_pertanyaan')->select('pilihan, isian, COUNT(pilihan) as jumlah, COUNT(isian) as jumlah2, pertanyaan, id_pertanyaan')->findAll();
    }


    

    public function countSamePertanyaan($fieldpertanyaan, $valuepertanyaan)
    {
        return $this->where($fieldpertanyaan, $valuepertanyaan)->countAllResults();
    }

    public function filterData()
    {
        $this->select('*');
        $this->groupBy('id_pertanyaan');
        $query = $this->get();
        return $query->getResult();
    }

    public function countSameData($fieldName, $value)
    {
        return $this->where($fieldName, $value)->countAllResults();
    }

    public function countSameData2($fieldName, $value2)
    {
        return $this->where($fieldName, $value2)->countAllResults();
    }
    
}