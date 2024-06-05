<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class NewsController extends BaseController
{
    public function index()
    {
        return view('news/list');
    }
    
    public function add()
    {
        return view('news/add');
    }
    
    public function edit()
    {
        return view('news/edit');
    }
}
