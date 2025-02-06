<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class PengujiUjianTAModel extends Model
{
    protected $uuidFields       = ['id_penguji_ujianta'];
    protected $table            = 'simta_penguji_ujianta';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_penguji_ujianta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_penguji_ujianta', 'id_staf','id_ujianta', 'nama_penguji', 'nilai_ujianta', 'status_ut', 'catatan' ,'created_at', 'updated_at'];
    protected $validationRules = [
        'id_penguji_ujianta' => 'required'
    ];

    public function getDataByIdUjianTA($id_ujianta)
    {
        $builder = $this->db->table('simta_ujianta');
        $builder->join('simta_penguji_ujianta', 'simta_penguji_ujianta.id_ujianta = simta_ujianta.id_ujianta');
        $builder->select('simta_penguji_ujianta.*,simta_ujianta.*');

        $builder->where('simta_penguji_ujianta.id_ujianta', $id_ujianta);
        return $query = $builder->get()->getRow();
    }

    public function getTotalNilaiUjianTA($id_ujianta){
        $builder = $this->db->table('simta_penguji_ujianta');
        $builder->selectAvg('nilai_ujianta');
        $builder->where('simta_penguji_ujianta.id_ujianta', $id_ujianta);
        // $builder->groupBy('simta_penguji_ujianta.id_penguji_ujianta');
        return $query = $builder->get()->getRow();

    }
}