<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class TahunModel extends Model
{
    protected $uuidFields       = ['id_tahun_lulus'];
    protected $table            = 'tracer_tahun_lulus';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_tahun_lulus';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_tahun_lulus', 'tahun'];
    protected $validationRules = [
        'tahun' => 'required', 
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