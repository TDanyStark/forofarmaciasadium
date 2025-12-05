<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Videos extends BaseController
{
    private $apiKey;

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

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $res = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($res === false) {
            return ['error' => $err ?: 'Error al consultar la API de YouTube'];
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

        $snippet = $videos[$id] ?? null;

        return view('videos/landing', [
            'video' => $snippet,
            'id' => $id,
            'error' => null,
        ]);
    }
}
