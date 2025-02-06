<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class LowonganKerjaModel extends Model
{
    protected $uuidFields       = ['id_lowongan_kerja'];
    protected $table            = 'tracer_lowongan_kerja';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_lowongan_kerja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_lowongan_kerja', 'nama_perusahaan', 'link_pt', 'posisi_lowongan', 'persyaratan', 'batas_akhir', 'poster'];
    protected $validationRules = [
        'id_lowongan_kerja' => 'required'
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