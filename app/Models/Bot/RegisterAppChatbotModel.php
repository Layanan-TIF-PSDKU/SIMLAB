<?php

namespace App\Models\Bot;

use CodeIgniter\Model;


class RegisterAppChatbotModel extends Model
{
    protected $table            = 'bot_registered_app';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['id','registered_id', 'app_detail'];

}