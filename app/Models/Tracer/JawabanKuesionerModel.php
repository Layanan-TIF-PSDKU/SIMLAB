<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class JawabanKuesionerModel extends Model
{
    protected $uuidFields       = ['id_jawaban'];
    protected $table            = 'tracer_jawaban_kuesioner';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_jawaban';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_jawaban','id_jadwal_kuesioner', 'id_user', 'id_pertanyaan','pertanyaan', 'pilihan'];
    protected $validationRules = [
        'pilihan' => 'required', 
    ];

    public function countSameData($fieldName, $value)
    {
        return $this->where($fieldName, $value)->countAllResults();
    }

    function getTotalPengisi($id_jadwal_kuesioner, $pilihan1, $pilihan2)
    {
        $this->db->from('tracer_jawaban_kuesioner');
        $this->db->where('id_jadwal_kueisoner', $id_jadwal_kuesioner);
        $this->db->where('pilihan1', $pilihan1);
        $this->db->where('pilihan2', $pilihan2);
        return $this->db->count_all_results();
    }

    public function count_alumni_by_status_alumni($id_survey, $id_status_alumni)
    {
        $this->db->from('kuesioner_alumni_answer kaa');
        $this->db->where('id_survey', $id_survey);
        $this->db->where('id_status_alumni', $id_status_alumni);
        return $this->db->count_all_results();
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