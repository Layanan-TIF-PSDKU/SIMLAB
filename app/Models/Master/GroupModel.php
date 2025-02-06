<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $uuidFields       = ['id'];
    protected $table            = 'auth_groups';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $allowedFields    = ['id', 'name', 'description'];
}