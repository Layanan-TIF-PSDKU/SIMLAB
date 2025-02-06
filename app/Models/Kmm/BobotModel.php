<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class BobotModel extends Model
{
    protected $uuidFields       = ['id_bobot'];
    protected $table            = 'simkmm_bobot';
    protected $primaryKey       = 'id_bobot';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bobot', 'bobot_dosen', 'bobot_mitra'];

    public function getBobot(){
        $builder = $this->db->table('simkmm_bobot');
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value;
        }
    }
}