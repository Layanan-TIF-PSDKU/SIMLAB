<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class PertanyaanIsianModel extends Model
{
    protected $uuidFields       = ['id_pertanyaan_isian'];
    protected $table            = 'tracer_pertanyaan_isian';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_pertanyaan_isian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_pertanyaan_isian', 'pertanyaan_isian'];
    protected $validationRules = [
        'pertanyaan_isian' => 'required', 
    ];
    
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