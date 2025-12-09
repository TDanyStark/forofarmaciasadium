<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Pages extends BaseController
{
    public function escarapela()
    {   
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $user = $session->get('user');
        
        // Extract first name
        $nombres = explode(' ', trim($user['nombres'] ?? ''));
        $primerNombre = $nombres[0] ?? '';

        // Extract first surname
        $apellidos = explode(' ', trim($user['apellidos'] ?? ''));
        $primerApellido = $apellidos[0] ?? '';

        $data = [
            'nombre' => $primerNombre,
            'apellido' => $primerApellido,
            'ciudad' => $user['ciudad'] ?? '',
            'farmacia' => $user['nombre_farmacia'] ?? ''
        ];

        return view('escarapela/index', $data);
    }

    public function juegos()
    {
        return view('juegos/index');
    }
}
