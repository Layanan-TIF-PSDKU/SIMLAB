<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class BerkasModel extends Model
{
    protected $uuidFields       = ['id_berkas'];
    protected $table            = 'simkmm_berkas';
    protected $primaryKey       = 'id_berkas';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_berkas', 'berkas', 'ket_berkas', 'created_at', 'updated_at'];
}