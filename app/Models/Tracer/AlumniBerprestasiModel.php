<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class AlumniBerprestasiModel extends Model
{
    protected $uuidFields       = ['id_alumni_berprestasi'];
    protected $table            = 'tracer_alumni_berprestasi';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_alumni_berprestasi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_alumni_berprestasi', 'nama_mahasiswa', 'program_study', 'prestasi', 'foto'];
    protected $validationRules = [
        'id_alumni_berprestasi' => 'required'
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