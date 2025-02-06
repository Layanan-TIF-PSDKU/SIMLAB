<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class PenilaianAkhirModel extends Model
{
    protected $uuidFields       = ['id_hasilakhir'];
    protected $table            = 'simta_hasilakhir';
    protected $primaryKey       = 'id_hasilakhir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_hasilakhir','id_mhs', 'id_staf', 'id_ujianproposal','nilai_ujianproposal', 'nilai_seminarhasil', 'nilai_ujianta', 'hasilakhir', 
                                    ];
    protected $validationRules = [
        'id_hasilakhir' => 'required'
    ];

    public function getHasilakhir()
    {
        $builder = $this->db->table($this->table);
        $builder->select('simta_hasilakhir.*,  simta_ujianproposal.*, mahasiswa.*, staf.*');
        $builder->join('simta_ujianproposal', 'simta_ujianproposal.id_ujianproposal = simta_hasilakhir.id_ujianproposal', 'left');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs', 'left');
        $builder->join('staf', 'staf.id_staf = simta_ujianproposal.id_staf', 'left');
        $query = $builder->get();

        return $query->getResultArray();
    }


    public function getTotalNilaiSeminarHasil($id_ujianproposal){
        $builder = $this->db->table('simta_hasilakhir');
        $builder->join('simta_seminarhasil','simta_seminarhasil.id_seminarhasil = simta_hasilakhir.id_seminarhasil');
        $builder->join('simta_ujianproposal','simta_ujianproposal.id_ujianproposal = simta_hasilakhir.id_ujianproposal');
        $builder->selectSum('nilai_total');
        $builder->where('simta_seminarhasil.nilai_total');
        $builder->where('simta_hasilakhir.id_seminarhasil', $id_ujianproposal);
        $builder->groupBy('simta_hasilakhir.id_seminarhasil');
        $query = $builder->get()->getResult(); 

        foreach ($query as $key => $value) {
            return $value->nilai;
        }
    }

    public function getTotalNilaiUjianProposal1($id_ujianproposal){
        $builder = $this->db->table('simta_hasilakhir');
        $builder->where('id_ujianproposal', $id_ujianproposal);
        $query = $builder->get();
        return $query->getRow();
    }
    
    public function getTotalNilaiSeminarHasil4($id_seminarhasil){
        $builder = $this->db->table('simta_hasilakhir');
        $builder->where('id_seminarhasil', $id_seminarhasil);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getTotalNilaiUjianTA($id_ujianta){
        $builder = $this->db->table('simta_hasilakhir');
        $builder->where('id_ujianta', $id_ujianta);
        $query = $builder->get();
        return $query->getRow();
    }

    public function getTotalNilaiUjianProposal($id_ujianproposal){
        $builder = $this->db->table('simta_penguji_ujianproposal');
        $builder->join('simta_hasilakhir','simta_hasilakhir.id_ujianproposal = simta_penguji_ujianproposal.id_penguji_ujianproposal');
        $builder->selectAvg('nilai_ujianproposal');
        $builder->where('simta_penguji_ujianproposal.id_penguji_ujianproposal', $id_penguji_ujianproposal);
        $builder->groupBy('simta_penguji_ujianproposal.id_ujianproposal');
        $query = $builder->get()->getRow();
    }

    public function getTotalNilaiSeminarHasil1($id_ujianproposal)
{
    $builder = $this->db->table('simta_hasilakhir');
    $builder->join('simta_seminarhasil', 'simta_seminarhasil.id_seminarhasil = simta_hasilakhir.id_seminarhasil');
    $builder->where('simta_seminarhasil.id_ujianproposal', $id_ujianproposal);
    $builder->groupBy('simta_hasilakhir.id_seminarhasil');
    $query = $builder->get()->getRow();

    return $query;
}

public function getTotalNilai($id_ujianproposal){
    $builder = $this->db->table('simta_hasilakhir');
    $builder->where('id_ujianproposal', $id_ujianproposal);
    $query = $builder->get();
    return $query->getRow();
}

}