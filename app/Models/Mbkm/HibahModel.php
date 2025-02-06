<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class HibahModel extends Model
{
    protected $uuidFields = ['id_hibah'];
    protected $table = 'mbkm_hibah';
    protected $primaryKey = 'id_hibah';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_hibah', 'id_mhs', 'nama_instansi', 'id_staf', 'judul', 'jenis_mbkm', 'proposal', 'surat_rekom', 'status_dosen', 'status_mahasiswa', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_hibah' => 'required',
    ];

    public function getMbkmHibahByMhs()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_hibah.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_hibah.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    public function getHibahByDosen()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_hibah.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_hibah.id_staf');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();

    }
    public function mbkmHibahgetMbkmFixHibahDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa)
    {
        if ($status_mahasiswa == 'diambil') {
            $builder = $this->db->table('mbkm_hibah');
            $builder->set('status_mahasiswa', 'diambil');
            $builder->where(['mbkm_hibah.id_mhs' => $id_mhs]);
            $builder->where(['mbkm_hibah.id_staf' => $id_staf]);
            $builder->where(['mbkm_hibah.jenis_mbkm' => $jenis_mbkm]);
            $builder->where(['mbkm_hibah.nama_instansi' => $nama_instansi]);
            $builder->update();
            $query = $builder->get();
            return $query->getResult();
        }
    }

    public function mbkmHibahgetMbkmFixHibahTidakDiambil($id_hibah, $id_mhs)
    {   
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*');
        $builder->set('status_mahasiswa', 'tidak diambil');
        $builder->where(['mbkm_hibah.id_hibah !=' => $id_hibah]);
        $builder->where('mbkm_hibah.id_mhs', $id_mhs);
        $builder->update();
        $query = $builder->get();
        return $query->getResult();
    }
    
    function getFilterHibahAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_hibah.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_hibah.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_hibah.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterHibahDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_hibah.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_hibah.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_hibah.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    public function getDetail($id_hibah){
        $builder = $this->db->table('mbkm_hibah');
        $builder->select('mbkm_hibah.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_hibah.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_hibah.id_staf');
        $builder->where('id_hibah', $id_hibah);
        $query = $builder->get();
        return $query->getRow(); 
    }
}