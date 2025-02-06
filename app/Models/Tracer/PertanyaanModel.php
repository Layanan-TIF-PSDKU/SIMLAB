<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class PertanyaanModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan'];
    protected $table            = 'tracer_pertanyaan_kuesioner';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_pertanyaan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan', 'pertanyaan', 'pilihan1', 'pilihan2'];
    protected $validationRules = [
        'pertanyaan' => 'required', 
    ];
    

    function getPertanyaanKuesioner()
    {
        $builder = $this->db->table('tracer_pertanyaan_kuesioner');
        $builder->select('tracer_pertanyaan_kuesioner.*, tracer_jadwal_kuesioner.*,');
        $query = $builder->get();
        return $query->getResult();
    }

    protected function setCreatedAt(array $data)
    {
        $data['data']['created_at'] = currentMillis();
        return $data;
    }

    protected function setUpdatedAt(array $data)
    {
        $data['data']['updated_at'] = currentMillis();
        return $data;
    }
}