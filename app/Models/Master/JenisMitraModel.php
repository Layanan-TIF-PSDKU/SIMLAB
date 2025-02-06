<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class JenisMitraModel extends Model
{
    protected $uuidFields       = ['id_mitra_detail'];
    protected $table            = 'mitra_detail';
    protected $primaryKey       = 'id_mitra_detail';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mitra_detail', 'id_mitra', 'jenis'];
}