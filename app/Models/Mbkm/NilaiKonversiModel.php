<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class NilaiKonversiModel extends Model
{
    protected $uuidFields       = ['id_nilai_konversi'];
    protected $table            = 'mbkm_nilai_konversi';
    protected $primaryKey       = 'id_nilai_konversi';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_nilai_konversi', 'id_mbkm_fix', 'nilai_konversi',];


    public function getNilaiKonversi($id_mbkm_fix){
        $builder = $this->db->table('mbkm_nilai_konversi');
        $builder->where('id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getRow();
    }
    // public function getTotalNilaiUts($id_mbkm_fix){
    //     $builder = $this->db->table('mbkm_total_uts');
    //     $builder->where('id_mbkm_fix', $id_mbkm_fix);
    //     $query = $builder->get();
    //     return $query->getRow();
    // }
    public function getKonvPenilaianbyMbkm(){
        $builder = $this->db->table('mbkm_nilai_konversi');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_nilai_konversi.id_mbkm_fix');
        $query = $builder->get();
        return $query->getResult();
    }
}