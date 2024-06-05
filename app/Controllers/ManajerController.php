<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ManajerController extends BaseController
{
    public function index()
    {
        return view('manajer/list');
    }
    
    public function register()
    {
        return view('manajer/register');
    }
}
