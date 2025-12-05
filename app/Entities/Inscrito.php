<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Inscrito extends Entity
{
    protected $dates = ['fecha_nacimiento', 'registration_date'];

    protected $casts = [
        'acepta_politica_datos' => 'int',
        'status' => 'int',
    ];
}
