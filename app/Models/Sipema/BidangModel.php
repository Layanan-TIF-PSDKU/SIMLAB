<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class BidangModel extends Model
{
    protected $uuidFields       = ['id_bidang'];
    protected $table            = 'sipema_bidang';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_bidang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bidang', 'nama_bidang', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_bidang' => 'required'
    ];
}