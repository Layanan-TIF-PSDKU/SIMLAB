<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class InformasiMagangModel extends Model
{
    protected $uuidFields       = ['id_informasi_magang'];
    protected $table            = 'tracer_informasi_magang';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_informasi_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_informasi_magang', 'nama_perusahaan', 'link_pt', 'posisi_magang', 'persyaratan_magang', 'batas_akhir', 'poster_magang'];
    protected $validationRules = [
        'id_informasi_magang' => 'required'
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