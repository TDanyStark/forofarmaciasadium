<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Videos extends BaseController
{
    private $apiKey;
    /**
     * Map of custom overrides for videos by ID.
     * Each entry can contain 'title' and/or 'author'.
     * Add or edit entries here to customize specific videos.
     * Example:
     * 'IyyZYCnzU64' => ['title' => 'Mi título', 'author' => 'Dr. Pérez']
     */
    private $overrides = [
        'IyyZYCnzU64' => ['title' => 'Hablemos de hábitos saludables: el rol educativo del dependiente', 'author' => 'Dr. Diego Aponte', 'orden' => '1'],
        'kuza3manR2w' => ['title' => 'Dispensación responsable: por qué no debemos cambiar la fórmula médica', 'author' => 'Dr. Gerardo Puentes', 'orden' => '2'],
        'VGeQnJ5tnkI' => ['title' => 'Salud digestiva en la farmacia: lo que todo dependiente debe saber', 'author' => 'Dr. William Otero', 'orden' => '3'],
        'zGhKI-FKoKA' => ['title' => 'Servicio al cliente en la farmacia: empatía y confianza como diferenciadores', 'author' => 'Gustavo Guerra', 'orden' => '4'],
        'sJ_zbIedeYs' => ['title' => 'Tecnología al servicio de la farmacia: herramientas digitales que marcan la diferencia', 'author' => 'Christian Camilo Meza', 'orden' => '5'],
        'XDIM2K8PhB0' => ['title' => 'IA en farmacias: ¿Cómo nos impactará en el futuro cercano?', 'author' => ' Juan Carlos Mejía', 'orden' => '6'],
    ];

    public function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    /**
     * Fetch video snippets from YouTube Data API v3
     * @param array $ids
     * @return array
     */
    private function fetchVideos(array $ids): array
    {
        if (empty($this->apiKey)) {
            return ['error' => 'YOUTUBE_API_KEY no configurada. Añade YOUTUBE_API_KEY en tu archivo .env'];
        }

        $idsStr = implode(',', $ids);
        $url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . urlencode($idsStr) . '&key=' . urlencode($this->apiKey);

        // Usar file_get_contents con stream context en lugar de cURL
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
                'header' => "User-Agent: foro-farmacias-adium/1.0\r\n",
            ],
            'ssl' => [
                'verify_peer' => true,
                'verify_peer_name' => true,
            ],
        ]);

        $res = @file_get_contents($url, false, $context);
        if ($res === false) {
            $errArr = error_get_last();
            $errMsg = $errArr['message'] ?? 'Error al consultar la API de YouTube';
            return ['error' => $errMsg];
        }

        $data = json_decode($res, true);
        if (!$data) {
            return ['error' => 'Respuesta inválida de la API de YouTube'];
        }

        $videos = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $id = $item['id'];
                $videos[$id] = $item['snippet'];
            }
        }

        return $videos;
    }

    /**
     * Apply overrides (custom title/author) to fetched video snippets.
     * @param array $videos  Snippets indexed by video id
     * @param array $ids     List of ids requested
     * @return array         Modified snippets with overrides applied
     */
    private function applyOverridesToVideos(array $videos, array $ids): array
    {
        foreach ($ids as $id) {
            if (!isset($videos[$id])) {
                continue;
            }

            if (isset($this->overrides[$id])) {
                $ov = $this->overrides[$id];
                if (isset($ov['title']) && !empty($ov['title'])) {
                    $videos[$id]['title'] = $ov['title'];
                }
                if (isset($ov['author']) && !empty($ov['author'])) {
                    $videos[$id]['author'] = $ov['author'];
                }
                if (isset($ov['orden']) && !empty($ov['orden'])) {
                    $videos[$id]['orden'] = $ov['orden'];
                }
            }
        }

        return $videos;
    }

    public function index()
    {
        // Lista fija de 6 videos solicitados
        $videoIds = [
            'IyyZYCnzU64',
            'kuza3manR2w',
            'VGeQnJ5tnkI',
            'zGhKI-FKoKA',
            'sJ_zbIedeYs',
            'XDIM2K8PhB0',
        ];

        $videos = $this->fetchVideos($videoIds);
        if (!isset($videos['error'])) {
            $videos = $this->applyOverridesToVideos($videos, $videoIds);
        }

        return view('videos/index', [
            'videos' => $videos,
            'videoIds' => $videoIds,
        ]);
    }

    public function show($id = null)
    {
        if (empty($id)) {
            return redirect()->to('/');
        }

        $videos = $this->fetchVideos([$id]);
        if (isset($videos['error'])) {
            return view('videos/landing', [
                'error' => $videos['error'],
                'video' => null,
                'id' => $id,
            ]);
        }

        // Apply overrides for this single video if present
        $videos = $this->applyOverridesToVideos($videos, [$id]);
        $snippet = $videos[$id] ?? null;

        return view('videos/landing', [
            'video' => $snippet,
            'id' => $id,
            'error' => null,
        ]);
    }
}
