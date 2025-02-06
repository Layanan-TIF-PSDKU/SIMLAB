<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class MitraModel extends Model
{
    protected $uuidFields       = ['id_mitra'];
    protected $table            = 'mitra';
    protected $primaryKey       = 'id_mitra';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id_mitra', 'id_user', 'nama_instansi', 'nama_pimpinan', 'nama_mentor', 'jenis_mitra', 'alamat', 'no_telp', 'created_at', 'updated_at'];

    public function getMitraKMM(){
        $builder = $this->db->table('mitra');
        $builder->join('mitra_detail', 'mitra_detail.id_mitra = mitra.id_mitra');
        $builder->where('mitra_detail.jenis', 'KMM');
        $query = $builder->get();
        return $query->getResult();
    }
    
    public function getMitra($id_mitra){
        $builder = $this->db->table('mitra');
        $builder->join('users', 'users.id = mitra.id_user');
        $builder->join('mitra_detail', 'mitra_detail.id_mitra = mitra.id_mitra');
        $builder->where('mitra.id_mitra', $id_mitra);
        $query = $builder->get();
        return $query->getRow();
    }
    
    public function getIDMitra($id_mitra){
        $builder = $this->db->table('mitra');
        $builder->join('users', 'users.id = mitra.id_user');
        $builder->join('mitra_detail', 'mitra_detail.id_mitra = mitra.id_mitra');
        $builder->where('mitra.id_mitra', $id_mitra);
        $query = $builder->get();
        return $query->getResultArray();
    }
}