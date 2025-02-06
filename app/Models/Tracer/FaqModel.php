<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $uuidFields       = ['id_faq'];
    protected $table            = 'faq';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_faq';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_faq', 'pertanyaan', 'jawaban'];
    protected $validationRules = [
        'pertanyaan' => 'required', 
        'jawaban' => 'required',
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