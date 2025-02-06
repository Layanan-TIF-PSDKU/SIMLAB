<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class TimelineModel extends Model
{
    protected $uuidFields       = ['id_timeline'];
    protected $table            = 'simta_timeline';
    protected $primaryKey       = 'id_timeline';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_timeline', 'nama_kegiatan', 'tanggal_mulai', 'tanggal_selesai'];
    protected $validationRules = [
        'id_timeline' => 'required'
    ];
}