<?php
namespace App\Models;

use CodeIgniter\Model;

class InscritoModel extends Model
{
    protected $table = 'inscritos';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Inscrito';
    protected $allowedFields = [
        'user_id',
        'nombres',
        'apellidos',
        'cedula',
        'fecha_nacimiento',
        'genero',
        'email',
        'celular',
        'nombre_farmacia',
        'ciudad',
        'direccion_farmacia',
        'nombre_cadena_distribuidor',
        'acepta_politica_datos',
        'status',
        'registration_date',
    ];

    protected $useTimestamps = false;

    // Centraliza las reglas de validación para evitar duplicación
    protected $validationRules = [
        'nombres' => 'required|alpha_space|min_length[2]|max_length[255]',
        'apellidos' => 'required|alpha_space|min_length[2]|max_length[255]',
        'cedula' => 'permit_empty|alpha_numeric_punct|max_length[50]',
        'fecha_nacimiento' => 'permit_empty|valid_date[Y-m-d]',
        'genero' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[255]',
        'celular' => 'permit_empty|max_length[50]',
        'nombre_farmacia' => 'permit_empty|max_length[255]',
        'ciudad' => 'permit_empty|max_length[100]',
        'direccion_farmacia' => 'permit_empty',
        'nombre_cadena_distribuidor' => 'permit_empty|max_length[255]',
        'acepta_politica_datos' => 'required|in_list[0,1]',
    ];

    public function getRules(): array
    {
        return $this->validationRules;
    }
}
