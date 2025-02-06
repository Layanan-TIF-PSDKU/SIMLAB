<?php

namespace App\Models\Tracer;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $uuidFields       = ['id_agenda'];
    protected $table            = 'tracer_agenda';
    protected $useTimestamps = true;
    protected $primaryKey       = 'id_agenda';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_agenda', 'nama_agenda', 'deskripsi_agenda', 'waktu_kegiatan'];
    protected $validationRules = [
        'nama_agenda' => 'required', 
        'deskripsi_agenda' => 'required', 
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