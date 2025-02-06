<?php

namespace App\Models\Mbkm;

use CodeIgniter\Model;

class MbkmProdiModel extends Model
{
    protected $uuidFields = ['id_mprodi'];
    protected $table = 'mbkm_prodi';
    protected $primaryKey = 'id_mprodi';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['id_mprodi', 'id_mhs', 'id_staf', 'nama_instansi', 'surat_rekom', 'jenis_mbkm', 'status_dosen', 'status_mahasiswa', 'created_at', 'update_at'];
    protected $validationRules = [
        'id_mprodi' => 'required',
    ];

    public function getMbkmProdiByMhs()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_prodi.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_prodi.id_staf');
        $builder->join('users', 'users.id = mahasiswa.id_user');
        $builder->where(['mahasiswa.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }
    public function getMbkmProdiByDosen()
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_prodi.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_prodi.id_staf');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function mbkmProdigetMbkmFixProdiDiambil($id_mhs, $id_staf, $jenis_mbkm, $nama_instansi, $status_mahasiswa)
    {
        if ($status_mahasiswa == 'diambil') {
            $builder = $this->db->table('mbkm_prodi');
            $builder->set('status_mahasiswa', 'diambil');
            $builder->where(['mbkm_prodi.id_mhs' => $id_mhs]);
            $builder->where(['mbkm_prodi.id_staf' => $id_staf]);
            $builder->where(['mbkm_prodi.jenis_mbkm' => $jenis_mbkm]);
            $builder->where(['mbkm_prodi.nama_instansi' => $nama_instansi]);
            $builder->update();
            $query = $builder->get();
            return $query->getResult();
        }
    }

    public function mbkmProdigetMbkmFixProdiTidakDiambil($id_mprodi,$id_mhs)
    {   
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*');
        $builder->set('status_mahasiswa', 'tidak diambil');
        $builder->where(['mbkm_prodi.id_mprodi !=' => $id_mprodi]);
        $builder->where('mbkm_prodi.id_mhs', $id_mhs);
        $builder->update();
        $query = $builder->get();
        return $query->getResult();
    }

    function getFilterProdiAdm($th_masuk)
    {
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('staf','staf.id_staf = mbkm_prodi.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_prodi.id_mitra');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_prodi.id_mhs');
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }
    
    function getFilterProdiDosen($th_masuk)
    {
        $user_id = user()->id;
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs'); 
        $builder->join('mahasiswa','mahasiswa.id_mhs = mbkm_prodi.id_mhs');
        $builder->join('staf','staf.id_staf = mbkm_prodi.id_staf');
        // $builder->join('mitra','mitra.id_mitra = mbkm_prodi.id_mitra');
        $builder->join('users','users.id = staf.id_user');
        $builder->where(['staf.id_user' => $user_id]);
        $builder->where('mahasiswa.th_masuk', $th_masuk);
        return $builder->get()->getResult();
    }

    public function getDetail($id_mprodi){
        $builder = $this->db->table('mbkm_prodi');
        $builder->select('mbkm_prodi.*, mahasiswa.*, staf.*, staf.nama as nm_staf,mahasiswa.nama as nm_mhs');
        $builder->join('mahasiswa', 'mahasiswa.id_mhs = mbkm_prodi.id_mhs');
        $builder->join('staf', 'staf.id_staf = mbkm_prodi.id_staf');
        $builder->where('id_mprodi', $id_mprodi);
        $query = $builder->get();
        return $query->getRow(); 
    }
}