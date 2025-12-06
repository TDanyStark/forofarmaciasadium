<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VideoModel;

class Videos extends BaseController
{
    /** @var VideoModel */
    private $videoModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
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

        return view('videos/index', [
            'videos' => $videos,
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

        return view('videos/landing', [
            'video' => $snippet,
            'id' => $id,
            'error' => null,
        ]);
    }
}
