<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class MonitoringModel extends Model
{
    protected $uuidFields       = ['id_monitoring'];
    protected $table            = 'mbkm_monitoring';
    protected $primaryKey       = 'id_monitoring';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_monitoring', 'id_mbkm_fix', 'tanggal', 'deskripsi', 'feedback', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_monitoring' => 'required'
    ];

    // function getMonitoring()
    // {
    //     $builder = $this->db->table('mbkm_monitoring');
    //     $builder->select('mbkm_monitoring.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
    //     $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_monitoring.id_mhs');
    //     $builder->join('staf', 'staf.id_staf = mbkm_monitoring.id_staf');
    //     $query = $builder->get();
    //     return $query->getResult();
    // }

    // function getMonitoringByDosen()
    // {   
    //     $user_id = user()->id;
    //     $builder = $this->db->table('mbkm_monitoring');
    //     $builder->select('mbkm_monitoring.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
    //     $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_monitoring.id_mhs');
    //     $builder->join('staf', 'staf.id_staf = mbkm_monitoring.id_staf');
    //     $builder->join('users', 'users.id = staf.id_user');
    //     $builder->where(['staf.id_user' => $user_id]);
    //     $query = $builder->get();
    //     return $query->getResult();
    // }
    
    function getMonitoring()
    {
        $builder = $this->db->table('mbkm_monitoring');
        // $builder->select('mbkm_monitoring.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        // $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_monitoring.id_mhs');
        $builder->join('mbkm_fix', 'mbkm_fix.id_mbkm_fix = mbkm_monitoring.id_mbkm_fix');
        // $builder->join('staf', 'staf.id_staf = mbkm_monitoring.id_staf');
        $query = $builder->get();
        return $query->getResult();
    }

    
}