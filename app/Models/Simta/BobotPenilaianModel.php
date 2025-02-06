<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class BobotPenilaianModel extends Model
{
    protected $uuidFields       = ['id_bobot'];
    protected $table            = 'simta_bobot';
    protected $primaryKey       = 'id_bobot';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_bobot', 'bobot_ujianproposal', 'bobot_seminarhasil', 'bobot_ujianta', 'created_at', 'updated_at'];

    public function getBobot(){
        $builder = $this->db->table('simta_bobot');
        $builder->select('*');
        $query = $builder->get()->getResult();
        
        foreach ($query as $key => $value) {
            return $value;
        }
    } 
}