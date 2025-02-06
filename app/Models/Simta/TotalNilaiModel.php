<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class TotalNilaiModel extends Model
{
    protected $uuidFields       = ['id_totalnilai'];
    protected $table            = 'simta_totalnilai';
    protected $primaryKey       = 'id_totalnilai';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_totalnilai', 'id_hasilakhir', 'nilai_ujianproposal','nilai_seminarhasil' , 'nilai_ujianta', 'nilai_akhir'];

    public function getPenilaian(){
        $builder = $this->db->table('simta_totalnilai');
        $builder->join('simta_totalnilai','simta_totalnilai.id_hasilakhir = simta_totalnilai.id_hasilakhir');
        $query = $builder->get();
        return $query->getResult();
    }
    

    public function getTotalNilai($id_hasilakhir){
        $builder = $this->db->table('simta_hasilakhir');
        $builder->where('id_hasilakhir', $id_hasilakhir);
        $query = $builder->get();
        return $query->getRow();
    }
    
}