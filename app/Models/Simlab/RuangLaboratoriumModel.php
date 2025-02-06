<?php

namespace App\Models\Simlab;

use CodeIgniter\Model;

class RuangLaboratoriumModel extends Model
{
    protected $table      = 'simlab_ruang_laboratorium';
    protected $primaryKey = 'id_ruang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields = ['id_ruang','nama_ruang', 'gedung', 'lantai'];
    protected $validationRules = [
        'id_ruang' => 'required'
    ];
}

?>