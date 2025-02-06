<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class PengujiUjianProposalModel extends Model
{
    protected $uuidFields       = ['id_penguji_ujianproposal'];
    protected $table            = 'simta_penguji_ujianproposal';
    protected $useTimestamps    = false;
    protected $primaryKey       = 'id_penguji_ujianproposal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_penguji_ujianproposal', 'id_staf','id_ujianproposal', 'nama_penguji', 'nilai_ujianproposal', 'status_up', 'catatan','created_at', 'updated_at'];
    protected $validationRules = [
        'id_penguji_ujianproposal' => 'required'
    ];

    public function getDataByIdUjianProposal($id_ujianproposal)
    {
        $builder = $this->db->table('simta_ujianproposal');
        $builder->join('simta_penguji_ujianproposal', 'simta_penguji_ujianproposal.id_ujianproposal = simta_ujianproposal.id_ujianproposal');
        $builder->select('simta_penguji_ujianproposal.*,simta_ujianproposal.*');

        $builder->where('simta_penguji_ujianproposal.id_ujianproposal', $id_ujianproposal);
        return $query = $builder->get()->getRow();
    }

    public function getTotalNilaiUjianProposal($id_ujianproposal){
        $builder = $this->db->table('simta_penguji_ujianproposal');
        $builder->selectAvg('nilai_ujianproposal');
        $builder->where('simta_penguji_ujianproposal.id_ujianproposal', $id_ujianproposal);
        // $builder->groupBy('simta_penguji_ujianproposal.id_penguji_ujianproposal');
        return $query = $builder->get()->getRow();

    }

    // public function getAverageStatusUp($id_ujianproposal)
    // {
    //     $builder = $this->db->table('simta_penguji_ujianproposal');
    //     $builder->selectAvg('status_up');
    //     $builder->where('id_ujianproposal', $id_ujianproposal);
    //     $result = $builder->get()->getRow();

}