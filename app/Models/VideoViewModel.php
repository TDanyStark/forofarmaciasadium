<?php
namespace App\Models;

use CodeIgniter\Model;

class VideoViewModel extends Model
{
    protected $table = 'video_views';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'video_id', 'ip', 'user_agent', 'viewed_at'];
    protected $useTimestamps = false;

    public function fetchViewsByUsers(array $userIds, array $filters): array
    {
        if (empty($userIds)) {
            return [];
        }

        $builder = $this->db->table($this->table . ' vv');
        $builder->select('vv.user_id, vv.video_id, vv.viewed_at, v.nombre AS video_name');
        $builder->join('videos v', 'v.id = vv.video_id', 'left');
        $builder->whereIn('vv.user_id', $userIds);

        if (! empty($filters['video_id'])) {
            $builder->where('vv.video_id', (int) $filters['video_id']);
        }

        if (! empty($filters['date_from'])) {
            $builder->where('vv.viewed_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (! empty($filters['date_to'])) {
            $builder->where('vv.viewed_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $builder->orderBy('vv.viewed_at', 'DESC');

        $rows = $builder->get()->getResultArray();
        $grouped = [];

        foreach ($rows as $row) {
            $grouped[$row['user_id']][] = $row;
        }

        return $grouped;
    }

    public function fetchVideoViewsReport(array $filters): array
    {
        $builder = $this->db->table($this->table . ' vv');
        $builder->select('vv.viewed_at, vv.ip, i.id AS user_id, i.nombres, i.apellidos, i.email, v.id AS video_id, v.nombre AS video_name');
        $builder->join('inscritos i', 'i.id = vv.user_id', 'left');
        $builder->join('videos v', 'v.id = vv.video_id', 'left');

        if (! empty($filters['video_id'])) {
            $builder->where('vv.video_id', (int) $filters['video_id']);
        }

        if (! empty($filters['date_from'])) {
            $builder->where('vv.viewed_at >=', $filters['date_from'] . ' 00:00:00');
        }

        if (! empty($filters['date_to'])) {
            $builder->where('vv.viewed_at <=', $filters['date_to'] . ' 23:59:59');
        }

        if (! empty($filters['q'])) {
            $builder->groupStart()
                ->like('i.nombres', $filters['q'])
                ->orLike('i.apellidos', $filters['q'])
                ->orLike('i.email', $filters['q'])
                ->groupEnd();
        }

        $builder->orderBy('vv.viewed_at', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function fetchInscritosVideosReport(): array
    {
        $builder = $this->db->table('inscritos i');
        $builder->select([
            'i.id AS inscrito_id',
            'i.nombres AS inscrito_nombres',
            'i.apellidos AS inscrito_apellidos',
            "COALESCE(i.email, 'NN') AS inscrito_email",
            "COALESCE(i.ciudad, 'NN') AS ciudad",
            "COALESCE(i.nombre_cadena_distribuidor, 'NN') AS nombre_cadena_distribuidor",
            "COALESCE(i.fecha_nacimiento, '1900-01-01') AS fecha_nacimiento",
            'COALESCE(v.id, 0) AS video_id',
            "COALESCE(v.nombre, 'NN') AS video_titulo",
            "COALESCE(MAX(vv.viewed_at), '1900-01-01 00:00:00') AS ultima_vez_visto",
        ]);
        $builder->join('video_views vv', 'vv.user_id = i.id', 'left');
        $builder->join('videos v', 'v.id = vv.video_id', 'left');
        $builder->groupBy([
            'i.id',
            'i.nombres',
            'i.apellidos',
            'i.email',
            'i.ciudad',
            'i.nombre_cadena_distribuidor',
            'i.fecha_nacimiento',
            'v.id',
            'v.nombre',
        ]);
        $builder->orderBy('i.id', 'ASC');
        $builder->orderBy('ultima_vez_visto', 'DESC');

        return $builder->get()->getResultArray();
    }
}
