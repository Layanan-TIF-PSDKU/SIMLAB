<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class CmsModel extends Model
{
    protected $uuidFields       = ['id_cms'];
    protected $table            = 'tracer_cms';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_cms';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_cms', 'warna_bg'];
    protected $validationRules = [
        'id_cms' => 'required', 
    ];

    function getWarna()
    {
        $builder = $this->db->table('tracer_cms');
        $builder->select('id_cms, key, warna_bg');
        $builder->where('key', 'warna');
        $query = $builder->get();
        return $query->getRow();
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