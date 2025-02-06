<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class UserModel1 extends Model
{
    // Nama Tabel
    protected $table    = 'users';
    // protected $primaryKey    = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['email', 'username','password_hash','active'];

    public function getUsers()
    {
        return $this->select('email', 'username', 'active')
            ->join('auth_groups_users gs','users.id=gs.user_id' )
            ->findAll();
    }
}