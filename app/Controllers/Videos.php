<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VideoModel;
use App\Models\VideoViewModel;

class Videos extends BaseController
{
    /** @var VideoModel */
    private $videoModel;
    /** @var VideoViewModel */
    private $videoViewModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
        $this->videoViewModel = new VideoViewModel();
    }

    /**
     * Save periodic video progress (AJAX)
     * Expects POST: video_id (YouTube id), seconds (int)
     */
    public function saveProgress()
    {
        $session = session();
        $user = $session->get('user');
        if (empty($user) || ! isset($user['id'])) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Unauthenticated']);
        }

        $videoYouTubeId = $this->request->getPost('video_id');
        $seconds = (int) $this->request->getPost('seconds');

        if (empty($videoYouTubeId) || $seconds < 0) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid parameters']);
        }

        $videoRow = $this->videoModel->where('id_youtube', $videoYouTubeId)->first();
        if (empty($videoRow)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Video not found']);
        }

        // Use VideoProgressModel to upsert progress
        $progressModel = new \App\Models\VideoProgressModel();

        $existing = $progressModel->where('user_id', $user['id'])
            ->where('video_id', $videoRow['id'])
            ->first();

        $data = [
            'user_id' => $user['id'],
            'video_id' => $videoRow['id'],
            'seconds' => $seconds,
        ];

        if ($existing) {
            // update existing row (use explicit primary key column `id`)
            $progressModel->update($existing['id'], $data);
        } else {
            $progressModel->insert($data);
        }

        return $this->response->setJSON(['success' => true, 'seconds' => $seconds]);
    }

    /**
     * Fetch video snippets from YouTube Data API v3
     * @param array $ids
     * @return array
     */
    /**
     * Fetch videos from the database only. Returns an array keyed by id_youtube.
     */
    private function fetchVideos(): array
    {
        $rows = $this->videoModel->orderBy('orden', 'ASC')->findAll();
        $videos = [];

        foreach ($rows as $row) {
            $id = $row['id_youtube'];
            $videos[$id] = [
                'title' => $row['nombre'],
                'author' => $row['author'],
                'thumbnail' => $row['thumbnail'] ?: ('/images/thumbnails/default.jpg'),
                'orden' => $row['orden'] ?? null,
            ];
        }

        return $videos;
    }

    /**
     * Low-level call to YouTube Data API v3 for a list of ids.
     * Returns an associative array keyed by video id with snippet-like data, or ['error'=>..].
     */
    // No external API calls — data comes from the database only.

    // Overrides removed — data is sourced exclusively from the database.

    public function index()
    {

        $videos = $this->fetchVideos();
        // Determinar qué videos ya fueron vistos por el usuario (si está logueado)
        $viewedVideos = [];
        $session = session();
        $user = $session->get('user');
        if (! empty($user) && isset($user['id'])) {
            // Obtenemos los video_id (ids de la tabla videos) que el usuario ha visto
            $views = $this->videoViewModel->where('user_id', $user['id'])->select('video_id')->distinct()->findAll();
            $videoIds = array_column($views, 'video_id');

            if (! empty($videoIds)) {
                // Convertimos esos ids a los identificadores externos (id_youtube) usados como claves en la vista
                $rows = $this->videoModel->select('id_youtube')->whereIn('id', $videoIds)->findAll();
                foreach ($rows as $r) {
                    if (! empty($r['id_youtube'])) {
                        $viewedVideos[] = $r['id_youtube'];
                    }
                }
            }
        }
        
        return view('videos/index', [
            'videos' => $videos,
            'viewedVideos' => $viewedVideos,
        ]);
    }

    public function show($id = null)
    {
        if (empty($id)) {
            return redirect()->to('/');
        }

        $row = $this->videoModel->where('id_youtube', $id)->first();
        if (empty($row)) {
            return view('videos/landing', [
                'error' => 'Video no encontrado en la base de datos',
                'video' => null,
                'id' => $id,
            ]);
        }

        $snippet = [
            'title' => $row['nombre'],
            'author' => $row['author'],
            'thumbnails' => [
                'medium' => ['url' => $row['thumbnail'] ?: ('/images/thumbnails/default.jpg')]
            ],
            'orden' => $row['orden'] ?? null,
        ];

        // Registro de vista: si el usuario está logueado, guardamos la vista
        $session = session();
        $user = $session->get('user');
        if (! empty($user) && isset($user['id'])) {
            $agent = $this->request->getUserAgent();
            $userAgent = is_object($agent) && method_exists($agent, 'getAgentString') ? $agent->getAgentString() : (string) $agent;

            // Insertamos una fila con la vista (no hacemos deduplicación aquí)
            $this->videoViewModel->insert([
                'user_id' => $user['id'],
                'video_id' => $row['id'],
                'ip' => $this->request->getIPAddress(),
                'user_agent' => $userAgent,
                'viewed_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return view('videos/landing', [
            'video' => $snippet,
            'id' => $id,
            'error' => null,
        ]);
    }
}
