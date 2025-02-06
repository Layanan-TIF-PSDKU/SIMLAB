<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class MsibModel extends Model
{
    protected $uuidFields = ['id_msib'];
    protected $table = 'mbkm_msib';
    protected $primaryKey = 'id_msib';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_msib', 'id_mhs', 'id_staf', 'nama_instansi', 'link_msib', 'jenis_mbkm', 'surat_rekom', 'sptjm', 'status_dosen', 'status_mahasiswa', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_msib' => 'required',
    ];

    public function getMsibByUser()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_msib.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();

    }
    public function getDetail($id_msib){
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_msib.id_staf');
        $builder->where('id_msib', $id_msib);
        $query = $builder->get();
        return $query->getRow(); 
    }
    public function getMsibByDosen()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_msib.id_staf');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function mbkmProdigetMbkmFixMsib($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa)
    {
        $builder = $this->db->table('mbkm_msib');
        $builder->set('status_mahasiswa', 'tidak diambil');
        $builder->where(['mbkm_msib.id_mhs' => $id_mhs]);
        $builder->where(['mbkm_msib.id_staf' => $id_staf]);
        $builder->where(['mbkm_msib.jenis_mbkm' => $jenis_mbkm]);
        $builder->where(['mbkm_msib.nama_instansi !=' => $nama_instansi]);
        $builder->where(['mbkm_msib.status_mahasiswa' => $status_mahasiswa]);
        $builder->update();
        $query = $builder->get();
        return $query->getResult();
    }

    public function mbkmMsibgetMbkmFixMsibDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa)
    {
        if ($status_mahasiswa == 'diambil') {
            $builder = $this->db->table('mbkm_msib');
            $builder->set('status_mahasiswa', 'diambil');
            $builder->where(['mbkm_msib.id_mhs' => $id_mhs]);
            $builder->where(['mbkm_msib.id_staf' => $id_staf]);
            $builder->where(['mbkm_msib.jenis_mbkm' => $jenis_mbkm]);
            $builder->where(['mbkm_msib.nama_instansi' => $nama_instansi]);
            $builder->update();
            $query = $builder->get();
            return $query->getResult();
        }
    }

    public function mbkmMsibgetMbkmFixMsibTidakDiambil($id_msib, $id_mhs)
    {   
        // $user_id = user()->id;
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*');
        // $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->set('status_mahasiswa', 'tidak diambil');
        $builder->where('mbkm_msib.id_msib !=', $id_msib);
        $builder->where('mbkm_msib.id_mhs', $id_mhs);
        $builder->update();
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getFilterMsibAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_msib.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_msib.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterMsibDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_msib');
        $builder->select('mbkm_msib.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_msib.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_msib.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_msib.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    

    // public function MsibTdk($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa)
    // {
    //     if ($status_mahasiswa == 'diambil') {
    //         $builder = $this->db->table('mbkm_prodi');
    //         $builder->set('status_mahasiswa', 'tidak diambil');
    //         $builder->where(['mbkm_prodi.id_mhs' => $id_mhs]);
    //         $builder->where(['mbkm_prodi.id_staf' => $id_staf]);
    //         $builder->where(['mbkm_prodi.jenis_mbkm' => $jenis_mbkm]);
    //         $builder->where(['mbkm_prodi.nama_instansi =!' => $nama_instansi]);
    //         $builder->update();
    //         $query = $builder->get();
    //         return $query->getResult();
    //     }
    // }
}