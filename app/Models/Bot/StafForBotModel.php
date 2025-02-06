<?php

namespace App\Models\Bot;

use CodeIgniter\Model;

class StafForBotModel extends Model
{
    protected $uuidFields       = ['id_staf'];
    protected $table            = 'staf';
    protected $primaryKey       = 'id_staf';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_staf', 'id_user', 'nama', 'nip', 'no_telp', 'alamat','jenis'];

    public function getIdStaf()
    {
    $id_user = user()->id;
    return $this->select('id_staf')->where('id_user', $id_user)->findAll();
    }

    public function getNamaStaf()
    {
    $id_user = user()->id;
    return $this->select('nama')->where('id_user', $id_user)->find();
    }
}