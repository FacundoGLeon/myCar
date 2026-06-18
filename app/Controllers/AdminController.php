<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'titulo' => 'Panel de Control - MyCar'
        ];
        
        return view('admin/dashboard', $data);
    }
}