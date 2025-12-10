<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VideoDocumentsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'video_youtube_id' => 'IyyZYCnzU64',
                'file' => '05-12-2025 Infografía_El papel del farmaceuta en la vida del paciente.pdf',
                'title' => 'Infografía: El papel del farmaceuta en la vida del paciente'
            ],
            [
                'video_youtube_id' => 'kuza3manR2w',
                'file' => '05-12-2025 Infografía Dispensación responsable.pdf',
                'title' => 'Infografía: Dispensación responsable'
            ],
            [
                'video_youtube_id' => 'VGeQnJ5tnkI',
                'file' => '05-12-2025 Infografía_Salud Digestiva en la farmacia.pdf',
                'title' => 'Infografía: Salud Digestiva en la farmacia'
            ],
            [
                'video_youtube_id' => 'zGhKI-FKoKA',
                'file' => '04-12-2025 Infografía - Gustavo Guerra _ Servicio al Cliente_ “Empatía y confianza como diferenciadores”.pdf',
                'title' => 'Infografía: Servicio al Cliente - Empatía y confianza'
            ],
            [
                'video_youtube_id' => 'sJ_zbIedeYs',
                'file' => '04-12-2025 Infografía - Christian Cuello _ Tecnologías al servicio de la farmacia.pdf',
                'title' => 'Infografía: Tecnologías al servicio de la farmacia'
            ],
            [
                'video_youtube_id' => 'XDIM2K8PhB0',
                'file' => '05-12-2025 Infografía_La nueva formula del exito_IA.pdf',
                'title' => 'Infografía: La nueva fórmula del éxito - IA'
            ],
        ];

        $videoModel = new \App\Models\VideoModel();
        $docModel = new \App\Models\VideoDocumentModel();

        foreach ($data as $item) {
            $video = $videoModel->where('id_youtube', $item['video_youtube_id'])->first();
            if ($video) {
                // Check if exists
                $exists = $docModel->where('video_id', $video['id'])
                                   ->where('file_path', 'infografias/' . $item['file'])
                                   ->first();
                
                if (!$exists) {
                    $docModel->insert([
                        'video_id' => $video['id'],
                        'title' => $item['title'],
                        'file_path' => 'infografias/' . $item['file'],
                    ]);
                }
            }
        }
    }
}
