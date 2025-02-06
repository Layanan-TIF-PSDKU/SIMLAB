<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class KmmModel extends Model
{
    protected $uuidFields       = ['id_kmm'];
    protected $table            = 'simkmm_kmm';
    protected $primaryKey       = 'id_kmm';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_kmm', 'id_mhs', 'id_staf', 'id_mitra', 'proposal', 'surat_pengantar','tgl_mulai','tgl_selesai', 'loa', 'bukti_gagal', 'status_lolos', 'laporan_akhir', 'judul_kmm', 'logbook', 'tgl_seminar', 'status_laporan','catatan_lap_akhir', 'created_at', 'updated_at'];
    
    public function getMahasiswaByProposal(){
        $builder = $this->db->table('mahasiswa');
        $builder->join('simkmm_pengajuan_proposal','simkmm_pengajuan_proposal.id_mhs = mahasiswa.id_mhs');
        $builder->where('status_proposal', 'disetujui');
        $query = $builder->get();
        return $query->getResult();
    }

    public function getStatus(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.status_lolos');
        $builder->orderBy('simkmm_kmm.created_at', 'DESC');
        $builder->limit(1);
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get()->getResult();

        foreach ($query as $key => $value) {
            return $value->status_lolos;
        }
    }

    public function getAllKMM(){
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    public function getKMM(){
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, simkmm_total_nilai.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('simkmm_total_nilai','simkmm_total_nilai.id_kmm = simkmm_kmm.id_kmm');
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    public function getKMMById($id_kmm){
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs, staf.alamat as a_staf, mitra.alamat as a_mitra'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where('id_kmm', $id_kmm);
        $query = $builder->get();
        return $query->getRow(); 
    }

    public function getKMMbyIdMhs(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }
    public function getLastKMM(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->orderBy('simkmm_kmm.created_at', 'DESC');
        $builder->limit(1);
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    public function getKMMbyIdDosen(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    public function getKMMbyIdMitra(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = mitra.id_user');
        $builder->where(['mitra.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }

    function getFilterDataKMM($th_masuk)
    {
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterDataKMMByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterDataLapAkhir($th_masuk)
    {
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where('simkmm_kmm.status_lolos', 'lolos');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    function getFilterDataLapAkhirByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('simkmm_kmm.status_lolos', 'lolos');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterDataSeminar($th_masuk)
    {
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->where('simkmm_kmm.status_laporan', 'disetujui');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterDataSeminarByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_kmm');
        $builder->select('simkmm_kmm.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_kmm.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_kmm.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_kmm.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('simkmm_kmm.status_laporan', 'disetujui');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
}