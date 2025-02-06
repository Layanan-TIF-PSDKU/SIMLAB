<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class TipsKarirModel extends Model
{
    protected $uuidFields       = ['id_tips_karir'];
    protected $table            = 'tracer_tips_karir';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_tips_karir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_tips_karir', 'judul', 'deskripsi'];
    protected $validationRules = [
        'judul' => 'required', 
        'deskripsi' => 'required',
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