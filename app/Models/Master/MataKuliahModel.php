<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class MataKuliahModel extends Model
{
    protected $uuidFields       = ['id_mata_kuliah'];
    protected $table            = 'mata_kuliah';
    protected $primaryKey       = 'id_mata_kuliah';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mata_kuliah', 'kode_mata_kuliah', 'nama_mata_kuliah', 'semester','sks','jenis'];
    protected $validationRules = [
        'id_mata_kuliah' => 'required'
    ];
}