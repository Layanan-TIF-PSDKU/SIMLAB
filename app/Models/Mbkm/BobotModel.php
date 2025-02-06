<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $uuidFields       = ['id_bobot'];
    protected $table            = 'mbkm_bobot';
    protected $primaryKey       = 'id_bobot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bobot', 'bobot_dosen', 'bobot_mitra', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_bobot' => 'required'
    ];
    
    public function getBobot(){
        $builder = $this->db->table('mbkm_bobot');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value;
        }
    }
    
}