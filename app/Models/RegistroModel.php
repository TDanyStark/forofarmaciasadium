<?php
namespace App\Models;

use CodeIgniter\Model;

class RegistroModel extends Model
{
    protected $table = 'inscritos';
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Inscrito';
    protected $allowedFields = [
        'id',
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

    public function fetchAdminInscritos(array $filters): array
    {
        $builder = $this->db->table($this->table . ' i');
        $builder->select('i.*, COUNT(DISTINCT vv.video_id) AS viewed_videos, MAX(vv.viewed_at) AS last_viewed_at');

        $joinOn = 'vv.user_id = i.id';

        if (! empty($filters['video_id'])) {
            $joinOn .= ' AND vv.video_id = ' . (int) $filters['video_id'];
        }

        if (! empty($filters['date_from'])) {
            $joinOn .= ' AND vv.viewed_at >= ' . $this->db->escape($filters['date_from'] . ' 00:00:00');
        }

        if (! empty($filters['date_to'])) {
            $joinOn .= ' AND vv.viewed_at <= ' . $this->db->escape($filters['date_to'] . ' 23:59:59');
        }

        $builder->join('video_views vv', $joinOn, 'left');

        if (! empty($filters['q'])) {
            $builder->groupStart()
                ->like('i.nombres', $filters['q'])
                ->orLike('i.apellidos', $filters['q'])
                ->orLike('i.email', $filters['q'])
                ->groupEnd();
        }

        $builder->groupBy('i.id');

        if ($filters['watched'] === '1') {
            $builder->having('viewed_videos >', 0);
        } elseif ($filters['watched'] === '0') {
            $builder->having('viewed_videos', 0);
        }

        $builder->orderBy('i.registration_date', 'DESC');

        return $builder->get()->getResultArray();
    }
}
