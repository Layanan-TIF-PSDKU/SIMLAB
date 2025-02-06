<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class PermissionGroupModel extends Model
{
    protected $uuidFields       = ['group_id'];
    protected $table            = 'auth_groups_permissions';
    protected $primaryKey       = 'group_id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['group_id', 'permission_id'];
}