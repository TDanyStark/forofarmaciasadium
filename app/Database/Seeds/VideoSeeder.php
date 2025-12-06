<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'Hablemos de hábitos saludables: el rol educativo del dependiente',
                'orden' => 1,
                'id_youtube' => 'IyyZYCnzU64',
                'author' => 'Dr. Diego Aponte',
                'thumbnail' => 'public\images\thumbnails\Diego Aponte.avif',
            ],
            [
                'nombre' => 'Dispensación responsable: por qué no debemos cambiar la fórmula médica',
                'orden' => 2,
                'id_youtube' => 'kuza3manR2w',
                'author' => 'Dr. Gerardo Puentes',
                'thumbnail' => 'public\images\thumbnails\Gerardo puentes.avif',
            ],
            [
                'nombre' => 'Salud digestiva en la farmacia: lo que todo dependiente debe saber',
                'orden' => 3,
                'id_youtube' => 'VGeQnJ5tnkI',
                'author' => 'Dr. William Otero',
                'thumbnail' => 'public\images\thumbnails\William Otero.avif',
            ],
            [
                'nombre' => 'Servicio al cliente en la farmacia: empatía y confianza como diferenciadores',
                'orden' => 4,
                'id_youtube' => 'zGhKI-FKoKA',
                'author' => 'Gustavo Guerra',
                'thumbnail' => 'public\images\thumbnails\Gustavo Guerra.avif',
            ],
            [
                'nombre' => 'Tecnología al servicio de la farmacia: herramientas digitales que marcan la diferencia',
                'orden' => 5,
                'id_youtube' => 'sJ_zbIedeYs',
                'author' => 'Christian Camilo Meza',
                'thumbnail' => 'public\images\thumbnails\Chirstian Camilo.avif',
            ],
            [
                'nombre' => 'IA en farmacias: ¿Cómo nos impactará en el futuro cercano?',
                'orden' => 6,
                'id_youtube' => 'XDIM2K8PhB0',
                'author' => 'Juan Carlos Mejía',
                'thumbnail' => 'public\images\thumbnails\Juan Carlos.avif',
            ],
        ];

        $this->db->table('videos')->insertBatch($data);
    }
}
