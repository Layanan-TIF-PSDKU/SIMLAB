<?php

namespace App\Models\Simta;

use CodeIgniter\Model;

class UjianTAModel extends Model
{
    protected $uuidFields       = ['id_ujianta'];
    protected $table            = 'simta_ujianta';
    protected $primaryKey       = 'id_ujianta';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_ujianta', 'id_mhs', 'id_staf', 'id_ujianproposal','nama_judul', 'abstrak','ruangan', 'tanggal','jam_mulai',
                                   'jam_selesai', 'nilai_totalujian', 'status_ajuan', 'status_ut', 'catatan', 'proposalakhir', 'berita_acarakmm',
                                   'krs', 'transkrip_nilai', 'rekomendasi_dospem', 'revisi_proposal','created_at', 'updated_at'];
    protected $validationRules = ['id_ujianta' => 'required'];
                               
    function getujianta()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianta');
        $builder->select('simta_ujianta.*, mahasiswa.*, staf.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianta.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_ujianta.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult();
    }
                               
    function getujiantaByMahasiswa()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianta');
        $builder->select('simta_ujianta.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianta.id_mhs');
        $builder->join('staf', 'staf.id_staf = simta_ujianta.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    function getujiantaByDosen()
    {   
        $user_id = user()->id;
        $builder = $this->db->table('simta_ujianta');
        $builder->select('simta_ujianta.*, staf.*, mahasiswa.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs'); 
        $builder->join('simta_penguji_ujianta', 'simta_penguji_ujianta.id_ujianta = simta_ujianta.id_ujianta');
        $builder->join('staf', 'staf.id_staf = simta_penguji_ujianta.id_staf');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simta_ujianta.id_mhs');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getDataByIdUjianTA($id_ujianta)
    {
        $builder = $this->db->table('simta_penguji_ujianta');
        $builder->where('id_ujianta', $id_ujianta);
        $builder->findAll();
    }

    public function getTotalNilaiUjianTA($id_ujianta){
        $builder = $this->db->table('simta_penguji_ujianta');
        $builder->join('simta_ujianta','simta_ujianta.id_penguji_ujianta = simta_penguji_ujianta.id_penguji_ujianta');
        $builder->selectAvg('nilai_ujianta');
        $builder->where('simta_penguji_ujianta.id_penguji_ujianta', $id_penguji_ujianta);
        $builder->groupBy('simta_penguji_ujianta.id_ujianta');
        $query = $builder->get()->getRow();
    }

    public function countUjianTA() {
        // Assuming you have the method getPengajuanJudulByUser1 in the model
        $ujianta = $this->getujiantaByDosen();

        // Return the count of pengajuan judul
        return count($ujianta);
    }
}