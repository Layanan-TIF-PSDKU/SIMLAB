<?php 

namespace App\Core;

use CodeIgniter\Controller;
use Myth\Auth\Authentication\AuthenticationInterface;

class My_Controller extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
    }

    protected function getCurrentUser()
    {
        return $this->auth->user();
    }
}
