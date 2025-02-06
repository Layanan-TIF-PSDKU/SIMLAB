<?php namespace App\Models\Master;

use CodeIgniter\Model;

class UsersModel extends Model 
{

    protected $table          = 'users';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $allowedFields  = ['email', 'username', 'password_hash', 'active'];
    protected $useTimestamps   = true;
    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username'      => 'required|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'password_hash' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $afterInsert        = ['addToGroup'];

    /**
     * The id of a group to assign.
     * Set internally by withGroup.
     *
     * @var int|null
     */
    protected $assignGroup;

    /**
     * Logs a password reset attempt for posterity sake.
     */

    
    public function getUsers()
    {
        return $this->select('email, username, active, gs.group_id, g.name group_name')
            ->join('auth_groups_users gs', 'users.id=gs.user_id' )
            ->join('auth_groups g','g.id = gs.group_id')
            ->findAll();
    }
    public function getUserById($id) {
        return $this->find($id);
    }

    public function createUser($data) {
        $this->insert($data);
        $user_id = $this->insertID();
        $group_id = $data['group_id'];
        $this->db->table('auth_groups_users')->insert(['group_id' => $group_id, 'user_id' => $user_id]);
    }

    public function updateUser($id, $data) {
        $this->update($id, $data);
        $group_id = $data['group_id'];
        $this->db->table('auth_groups_users')->where('user_id', $id)->update(['group_id' => $group_id]);
    }

    public function deleteUser($id) {
        $this->delete($id);
        $this->db->table('auth_groups_users')->where('user_id', $id)->delete();
    }
}
