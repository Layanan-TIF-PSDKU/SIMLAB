<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class SeminarHasilModel extends Model
{
    protected $uuidFields       = ['id_seminarhasil'];
    protected $table            = 'simta_seminarhasil';
    protected $primaryKey       = 'id_seminarhasil';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_seminarhasil', 'id_mhs', 'id_staf', 'id_ujianproposal', 'nama_judul', 'abstrak', 'ruang_semhas', 'jadwal_semhas', 
                                   'jam_mulai', 'jam_selesai', 'nilai_total', 'status_ajuan', 'status_sh', 'catatan', 
                                   'proposal_seminarhasil','persetujuan_dosen', 'berita_acara', 'revisi_proposal', 'created_at', 'updated_at'];
    protected $validationRules = ['id_seminarhasil' => 'required'];
                               
    function getSeminarHasil()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_seminarhasil');
        $builder->select('simta_seminarhasil.*, mahasiswa.*, staf.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_seminarhasil.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_seminarhasil.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult();
    }
                               
    function getseminarhasilByMahasiswa()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_seminarhasil');
        $builder->select('simta_seminarhasil.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_seminarhasil.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_seminarhasil.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getseminarhasilByDosen()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_seminarhasil');
        $builder->select('simta_seminarhasil.*, staf.*, mahasiswa.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('staf', 'staf.id_staf = simta_seminarhasil.id_staf');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_seminarhasil.id_mhs');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
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

public function getNilaiTotal($id_ujianproposal)
{
    return $this->select('nilai_total')
        ->where('id_ujianproposal', $id_ujianproposal)
        ->first();
}
public function countSeminarHasil() {
    // Assuming you have the method getPengajuanJudulByUser1 in the model
    $seminarhasil = $this->getseminarhasilByDosen();

    // Return the count of pengajuan judul
    return count($seminarhasil);
}
}