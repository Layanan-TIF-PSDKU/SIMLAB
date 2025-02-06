<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'simlab_kategori';
    protected $primaryKey = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_kategori','nama_kategori'];
    protected $validationRules = [
        'id_kategori' => 'required'
    ];
}

?>