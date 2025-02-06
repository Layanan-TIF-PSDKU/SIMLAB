<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class UjianProposalModel extends Model
{
    protected $uuidFields       = ['id_ujianproposal'];
    protected $table            = 'simta_ujianproposal';
    protected $primaryKey       = 'id_ujianproposal';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_ujianproposal', 'id_mhs', 'id_staf', 'id_pengajuanjudul', 'nama_judul', 'abstrak', 'hari', 'tanggal','ruang_sempro', 
                                   'jam_mulai','jam_selesai', 'nilai_totalujian', 'status_ajuan', 'status_up', 'catatan', 'proposalawal', 
                                   'transkrip_nilai','revisi_proposal', 'created_at', 'updated_at'];
    protected $validationRules = ['id_ujianproposal' => 'required'];

    function getUjianProposal()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianproposal');
        $builder->select('simta_ujianproposal.*, mahasiswa.*, staf.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_ujianproposal.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult();
    }
                               
    function getUjianProposalByMahasiswa()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianproposal');
        $builder->select('simta_ujianproposal.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_ujianproposal.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getUjianProposalByDosen()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianproposal');
        $builder->select('simta_ujianproposal.*, staf.*, mahasiswa.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('simta_penguji_ujianproposal', 'simta_penguji_ujianproposal.id_ujianproposal = simta_ujianproposal.id_ujianproposal');
        $builder->join('staf', 'staf.id_staf = simta_penguji_ujianproposal.id_staf');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getUjianProposalByUser1()
    {
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianproposal');
        $builder->select('simta_ujianproposal.*, mahasiswa.*, staf.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs');
        // Tambahkan join dengan tabel simta_penguji_ujianproposal
        $builder->join('simta_penguji_ujianproposal', 'simta_penguji_ujianproposal.id_ujianproposal = simta_ujianproposal.id_ujianproposal');
        $builder->join('staf', 'staf.id_staf = simta_penguji_ujianproposal.id_staf');
        $query = $builder->get();
        return $query->getResult();
    }

    public function updateNilaiTotal($id_ujianproposal)
{
    $query = $this->db->table('simta_penguji_ujianproposal')
        ->selectSum('nilai_ujianproposal')
        ->where('id_ujianproposal', $id_ujianproposal)
        ->get();

    $totalNilai = $query->getRow()->nilai_total;

    $data = [
        'nilai_total' => $totalNilai,
    ];

    $this->db->table('simta_ujianproposal')
        ->where('id_ujianproposal', $id_ujianproposal)
        ->update($data);
}

public function getTotalNilaiUjianProposal($id_ujianproposal){
    $builder = $this->db->table('simta_penguji_ujianproposal');
    $builder->join('simta_ujianproposal','simta_ujianproposal.id_penguji_ujianproposal = simta_penguji_ujianproposal.id_penguji_ujianproposal');
    $builder->selectAvg('nilai_ujianproposal');
    $builder->where('simta_penguji_ujianproposal.id_penguji_ujianproposal', $id_penguji_ujianproposal);
    $builder->groupBy('simta_penguji_ujianproposal.id_ujianproposal');
    $query = $builder->get()->getRow();
}

function getPenguji($id_ujianproposal)
    {   
        $builder = $this->db->table('simta_ujianproposal');
        $builder->select('simta_ujianproposal.*, simta_.nama as nm_mhs'); 
        $builder->join('simta_penguji_ujianproposal', 'simta_penguji_ujianproposal.id_ujianproposal = simta_ujianproposal.id_ujianproposal');
        $builder->join('staf', 'staf.id_staf = simta_penguji_ujianproposal.id_staf');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianproposal.id_mhs');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getTotalNilai($id_ujianproposal){
        $builder = $this->db->table('simta_ujianproposal');
        $builder->where('id_ujianproposal', $id_ujianproposal);
        $query = $builder->get();
        return $query->getRow();
    }

    public function countUjianProposal() {
        // Assuming you have the method getPengajuanJudulByUser1 in the model
        $ujianproposal = $this->getujianproposalByDosen();

        // Return the count of pengajuan judul
        return count($ujianproposal);
    }
    // public function getAverageStatusUp($id_ujianproposal)
    // {
    //     $builder = $this->db->table('pengujiujianproposal');
    //     $builder->selectAvg('status_up');
    //     $builder->where('id_ujianproposal', $id_ujianproposal);
    //     $result = $builder->get()->getRow();

    //     return $result ? $result->status_up_avg : 0;
    // }

}