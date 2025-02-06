<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class JenisKuesionerModel extends Model
{
    protected $uuidFields       = ['id_jenis_kuesioner'];
    protected $table            = 'tracer_jenis_kuesioner';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_jenis_kuesioner';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_jenis_kuesioner', 'nama'];
    protected $validationRules = [
        'nama' => 'required', 
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