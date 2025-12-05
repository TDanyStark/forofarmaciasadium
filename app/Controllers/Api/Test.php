<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Test extends BaseController
{
    public function index()
    {
        // Devuelve JSON simple para demostrar una API
        return $this->response->setJSON(['message' => 'hello world']);
    }
}
