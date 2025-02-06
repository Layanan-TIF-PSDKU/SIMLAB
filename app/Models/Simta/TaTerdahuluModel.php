<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class TaTerdahuluModel extends Model
{
    protected $uuidFields       = ['id_taterdahulu'];
    protected $table            = 'simta_taterdahulu';
    protected $primaryKey       = 'id_taterdahulu';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_taterdahulu', 'id_mhs', 'judul_ta', 'abstrak', 'dokumen_ta', 'created_at', 'updated_at'];
    protected $validationRules = [
        'id_taterdahulu' => 'required'
    ];

    function getTaTerdahulu()
    {
        $builder = $this->db->table('simta_taterdahulu');
        $builder->select('simta_taterdahulu.*, mahasiswa.*,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_taterdahulu.id_mhs');
        $query = $builder->get();
        return $query->getResult();
    }
}