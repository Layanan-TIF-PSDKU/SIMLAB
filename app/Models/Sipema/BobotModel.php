<?php

namespace App\Models\Sipema;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $uuidFields       = ['id_bobot'];
    protected $table            = 'sipema_bobot';
    protected $useTimestamps = false;
    protected $primaryKey       = 'id_bobot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bobot', 'jenis_bobot', 'nilai_bobot', 'created_at', 'updated_at'];
    protected $validationRules  = [
        'id_bobot' => 'required'
    ];

    public function getTotalBobotTambah()
    {
        $builder = $this->db->table('sipema_bobot');
        $builder->selectSum('nilai_bobot','total_bobot');
        $query = $builder->get();
        $row = $query->getRow();
        $totalBobot = $row->total_bobot;
    
        if (round($totalBobot, 2) < 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getTotalBobotUpdate($nilai_bobot_lama, $nilai_bobot_baru)
    {
        $builder = $this->db->table('sipema_bobot');
        $builder->selectSum('nilai_bobot','total_bobot');
        $query = $builder->get();
        $row = $query->getRow();
        $totalBobot = $row->total_bobot;

        $totalBobot2 = $totalBobot - $nilai_bobot_lama->nilai_bobot + $nilai_bobot_baru;
    
        if (round($totalBobot2, 2) <= 1) {
            return true;
        } else {
            return false;
        }
    }
}