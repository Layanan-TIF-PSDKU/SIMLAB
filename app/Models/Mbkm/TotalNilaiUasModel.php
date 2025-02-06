<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class TotalNilaiUasModel extends Model
{
    protected $uuidFields       = ['id_total_uas'];
    protected $table            = 'mbkm_total_uas';
    protected $primaryKey       = 'id_total_uas';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_total_uas', 'id_mbkm_fix', 'nilai_dosen_uas','nilai_mitra_uas' , 'nilai_final_uas'];

    public function getTotPenilaianbyMbkm(){
        $builder = $this->db->table('mbkm_total_uas');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uas.id_mbkm_fix');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getTotalNilaiUas($id_mbkm_fix){
        $builder = $this->db->table('mbkm_total_uas');
        $builder->where('id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getRow();
    }
    function getFilterNilaiUasDsn($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_total_uas');
        $builder->select('mbkm_total_uas.*, mbkm_fix.*, mahasiswa.*, mbkm_nilai_konversi.*, staf.*, mitra.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uas.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    function getFilterNilaiUasAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_total_uas');
        $builder->select('mbkm_total_uas.*, mbkm_fix.*, mahasiswa.*, mbkm_nilai_konversi.*, staf.*, mitra.*, mitra.nama_instansi as nm_mitra, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uas.id_mbkm_fix');
        $builder->join('mbkm_nilai_konversi','mbkm_nilai_konversi.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    function getKalkulasiNilaiUAS()
    {
        $builder = $this->db->table('mbkm_total_uas');
        $builder->select('id_mbkm_fix, nilai_final_uas');   
        return $builder->get()->getResult();
    }
}