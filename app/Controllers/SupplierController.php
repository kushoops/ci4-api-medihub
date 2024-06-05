<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SupplierController extends BaseController
{
    public function index()
    {
        return view('supplier/profile');
    }
    
    public function list()
    {
        return view('supplier/list');
    }
    
    public function detail()
    {
        return view('supplier/detail');
    }
    
    public function edit()
    {
        return view('supplier/edit');
    }
    
    public function dataPenunjang()
    {
        return view('supplier/data_penunjang');
    }
}
