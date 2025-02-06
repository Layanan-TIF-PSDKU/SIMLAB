<?php

namespace App\Models\Bot;

use CodeIgniter\Model;

class MahasiswaForBotModel extends Model
{
    protected $uuidFields       = ['id_mhs'];
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mhs';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mhs', 'id_user', 'nama', 'email', 'nim', 'prodi', 'no_telp', 'th_masuk', 'th_lulus', 'kelas', 'status'];

    public function getIdMhs()
    {
    $id_user = user()->id;
    return $this->select('id_mhs')->where('id_user', $id_user)->findAll();
    }

    public function checkMahasiswaExists()
    {
        $id_user = user()->id;
        return $this->where('id_user', $id_user)->countAllResults() > 0;
    }

    public function getNamaMhs()
    {
    $id_user = user()->id;
    return $this->select('nama')->where('id_user', $id_user)->find();
    }
}