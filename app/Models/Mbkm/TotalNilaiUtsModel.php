<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class TotalNilaiUtsModel extends Model
{
    protected $uuidFields       = ['id_total_uts'];
    protected $table            = 'mbkm_total_uts';
    protected $primaryKey       = 'id_total_uts';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_total_uts', 'id_mbkm_fix', 'nilai_dosen_uts','nilai_mitra_uts' , 'nilai_final_uts'];

    public function getTotPenilaianbyMbkm(){
        $builder = $this->db->table('mbkm_total_uts');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uts.id_mbkm_fix');
        $query = $builder->get();
        return $query->getResult();
    }
    public function getTotalNilaiUts($id_mbkm_fix){
        $builder = $this->db->table('mbkm_total_uts');
        $builder->where('id_mbkm_fix', $id_mbkm_fix);
        $query = $builder->get();
        return $query->getRow();
    }

    function getFilterDataNilai($th_masuk)
    {
        // $builder = $this->db->table('mbkm_total_uts');
        // $builder->select('mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mitra.nama_instansi as nm_mtr, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        // $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uts.id_mbkm_fix');
        // $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        // $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        // $builder->where('mahasiswa.th_masuk', $th_masuk);
        // return $builder->get()->getResult();
        $builder = $this->db->table('mbkm_total_uts');
        $builder->select('mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mitra.nama_instansi as nm_mitra, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_fix.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        // $builder->where('mbkm_fix.jenis_mbkm', 'msib');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
 
    
    function getFilterDataNilaiByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_total_uts');
        $builder->select('mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uts.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    function getFilterDataNilaiUtsByIdAdm($th_masuk)
    {
       
        $builder = $this->db->table('mbkm_total_uts');
        $builder->select('mbkm_total_uts.*, mbkm_fix.*, mahasiswa.*, staf.*, mitra.*, mitra.*, mitra.nama_instansi as nm_mitra, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uts.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    function getFilterDataNilaiByIdAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_total_uts');
        $builder->select('mbkm_total_uts.*, mbkm_fix.*, mbkm_nilai_konversi.*, mahasiswa.*, staf.*, mitra.*, mitra.nama_instansi as nm_mitra, staf.nama as nm_staf, mahasiswa.nama as nm_mhs');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_total_uts.id_mbkm_fix');
        $builder->join('mbkm_fix','mbkm_fix.id_mbkm_fix = mbkm_nilai_konversi.id_mbkm_fix');
        $builder->join('staf','staf.id_staf = mbkm_fix.id_staf');
        $builder->join('mitra','mitra.id_mitra = mbkm_fix.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_fix.id_mhs');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    // Grafik Kalkulasi Nilai UTS
    function getKalkulasiNilaiUTS()
    {
        $builder = $this->db->table('mbkm_total_uts');
        $builder->select('id_mbkm_fix, nilai_final_uts');   
        return $builder->get()->getResult();
    }
}