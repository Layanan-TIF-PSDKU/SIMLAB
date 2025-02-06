<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class JadwalKuesionerModel extends Model
{
    protected $uuidFields       = ['id_jadwal_kuesioner'];
    protected $table            = 'tracer_jadwal_kuesioner';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_jadwal_kuesioner';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_jadwal_kuesioner', 'jenis_survey', 'tahun_lulus', 'batas_pengisian'];
    protected $validationRules = [
        'jenis_survey' => 'required', 
    ];

    function getJenisKuesioner()
    {
        $builder = $this->db->table('tracer_jadwal_kuesioner');
        $builder->select('tracer_jadwal_kuesioner.*, tracer_jenis_kuesioner.*, tracer_tahun_lulus.*,');
        $builder->join('tracer_jenis_kuesioner', 'tracer_jenis_kuesioner.id_jenis_kuesioner = tracer_jadwal_kuesioner.jenis_survey');
        $builder->join('tracer_tahun_lulus', 'tracer_tahun_lulus.id_tahun_lulus = tracer_jadwal_kuesioner.tahun_lulus');
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