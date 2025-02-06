<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class PengajuanBimbinganModel extends Model
{
    protected $uuidFields       = ['id_bimbingan'];
    protected $table            = 'simta_pengajuanbimbingan';
    protected $primaryKey       = 'id_bimbingan';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bimbingan', 'id_mhs', 'id_staf', 'id_pengajuanjudul','jadwal_bimbingan', 'ruang_bimbingan','jam_mulai', 'hasil_bimbingan', 'status_ajuan','created_at', 'update_at'];
    protected $validationRules = ['id_bimbingan' => 'required'];
                               
    function getPengajuanBimbinganByUser()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_pengajuanbimbingan');
        $builder->select('simta_pengajuanbimbingan.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_pengajuanbimbingan.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_pengajuanbimbingan.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getPengajuanBimbinganByUser1()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_pengajuanbimbingan');
        $builder->select('simta_pengajuanbimbingan.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_pengajuanbimbingan.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_pengajuanbimbingan.id_staf');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
}