<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
    public function escarapela()
    {   
        return view('escarapela/index');
    }

    public function juegos()
    {
        return view('juegos/index');
    }
}
