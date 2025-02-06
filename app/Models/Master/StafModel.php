<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class StafModel extends Model
{
    protected $uuidFields = ['id_staf'];
    protected $table = 'staf';
    protected $primaryKey = 'id_staf';
    protected $returnType = 'object';
    protected $allowedFields = ['id_staf', 'id_user', 'nama', 'nip', 'no_telp', 'alamat', 'jenis', 'status'];
    protected $validationRules = [
        'id_staf' => 'required',
    ];

    public function getStafbyUserId()
    {
        $user_id = user()->id;
        $builder = $this->db->table('staf');
        $builder->select('*');
        $builder->join('users', 'users.id = staf.id_user');
        $builder->where('id_user', $user_id);
        $query = $builder->get();
        return $query->getResult();
    }

    public function getAllDosen()
    {
        $builder = $this->db->table('staf');
        $builder->where('jenis', 'Dosen');
        $query = $builder->get();
        return $query->getResult();
    }

    // Mendapatkan semua staf dengan jenis laboran
    public function getLaboran()
    {
        $builder = $this->db->table('staf');
        $builder->where('jenis', 'Laboran');
        $query = $builder->get();
        return $query->getResult();
    }

}
