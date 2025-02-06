<?php

namespace App\Models\Kmm;

use CodeIgniter\Model;

class PengajuanProposalModel extends Model
{
    protected $uuidFields       = ['id_proposal'];
    protected $table            = 'simkmm_pengajuan_proposal';
    protected $primaryKey       = 'id_proposal';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_proposal', 'id_mhs', 'id_staf', 'id_mitra', 'proposal_awal', 'status_proposal', 'catatan', 'created_at', 'updated_at'];

    public function getStatus(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_pengajuan_proposal');
        $builder->select('simkmm_pengajuan_proposal.status_proposal');
        $builder->orderBy('simkmm_pengajuan_proposal.created_at', 'DESC');
        $builder->limit(1);
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_pengajuan_proposal.id_mhs');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get()->getResult();
        
        foreach ($query as $key => $value) {
            return $value->status_proposal;
        }
    }

    public function getProposalbyIdMahasiswa(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_pengajuan_proposal');
        $builder->select('simkmm_pengajuan_proposal.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_pengajuan_proposal.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_pengajuan_proposal.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_pengajuan_proposal.id_mitra');
        $builder->join('users','users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get()->getResult();
        return $query;
    }
    
    public function getProposalbyIdDosen(){
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_pengajuan_proposal');
        $builder->select('simkmm_pengajuan_proposal.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_pengajuan_proposal.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_pengajuan_proposal.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_pengajuan_proposal.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult(); 
    }
    
    function getFilterProposalByIdDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('simkmm_pengajuan_proposal');
        $builder->select('simkmm_pengajuan_proposal.*, mahasiswa.*, staf.*, mitra.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = simkmm_pengajuan_proposal.id_mhs');
        $builder->join('staf','staf.id_staf = simkmm_pengajuan_proposal.id_staf');
        $builder->join('mitra','mitra.id_mitra = simkmm_pengajuan_proposal.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
}