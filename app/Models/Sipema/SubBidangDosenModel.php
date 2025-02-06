<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class SubBidangDosenModel extends Model
{
    protected $uuidFields       = ['id_sub_bidang_dosen'];
    protected $table            = 'sipema_sub_bidang_dosen';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_sub_bidang_dosen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_sub_bidang_dosen', 'id_sub_bidang', 'id_staf', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_sub_bidang_dosen' => 'required'
    ];
}