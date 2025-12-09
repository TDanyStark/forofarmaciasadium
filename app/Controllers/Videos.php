<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\VideoModel;
use App\Models\VideoViewModel;
use setasign\Fpdi\Fpdi;

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

      // Después de registrar la vista, comprobamos si el usuario alcanza el 60% de sesiones
      try {
        // Conteo de sesiones vistas (distintas)
        $views = $this->videoViewModel->where('user_id', $user['id'])->select('video_id')->distinct()->findAll();
        $viewedVideoIds = array_unique(array_column($views, 'video_id'));
        $viewedCount = count($viewedVideoIds);

        // Total de videos disponibles
        $totalVideos = (int) $this->videoModel->countAll();
        $threshold = (int) ceil($totalVideos * 0.6);

        if ($totalVideos > 0 && $viewedCount >= $threshold) {
          // Crear certificado personalizado en subcarpeta por usuario
          $destDir = WRITEPATH . 'uploads/certificados/' . $user['id'] . '/';
          if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
          }

          // Preparar nombres (primer nombre + primer apellido) y sanitizar para filename
          $nombres = trim($user['nombres'] ?? '');
          $apellidos = trim($user['apellidos'] ?? '');
          $primerNombre = '';
          $primerApellido = '';
          if ($nombres !== '') {
            $parts = preg_split('/\s+/', $nombres);
            $primerNombre = $parts[0] ?? '';
          }
          if ($apellidos !== '') {
            $parts = preg_split('/\s+/', $apellidos);
            $primerApellido = $parts[0] ?? '';
          }

          // Sanitizar para evitar caracteres inválidos en filename
          $sanitize = function ($str) use ($user) {
            $s = (string) $str;
            // intentar transliterar a ASCII
            $trans = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
            if ($trans !== false) {
              $s = $trans;
            }
            // reemplazar todo lo que no sea letra/dígito por guión bajo
            $s = preg_replace('/[^A-Za-z0-9]+/', '_', $s);
            $s = trim($s, '_');
            return $s === '' ? 'user' . ($user['id'] ?? '0') : $s;
          };

          $safeFirst = $sanitize($primerNombre);
          $safeLast = $sanitize($primerApellido);

          $filename = 'certificado_foro_' . $safeFirst . '_' . $safeLast . '.pdf';
          $destPath = $destDir . $filename;

          if (! file_exists($destPath)) {
            $src = FCPATH . 'certificado_template/foroAdium2025.pdf';
            if (file_exists($src)) {
              try {
                $nombreImpreso = trim($primerNombre . ' ' . $primerApellido);

                // Usar FPDI para importar la plantilla y escribir el nombre
                $pdf = new \setasign\Fpdi\Fpdi();
                $pageCount = $pdf->setSourceFile($src);
                $tplId = $pdf->importPage(1);
                $size = $pdf->getTemplateSize($tplId);
                $orientation = (isset($size['width']) && isset($size['height']) && $size['width'] > $size['height']) ? 'L' : 'P';
                if (isset($size['width']) && isset($size['height'])) {
                  $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                } else {
                  $pdf->AddPage($orientation);
                }
                $pdf->useTemplate($tplId);

                // Ajustes de estilo y posición: puede necesitarse ajuste fino según la plantilla
                $pdf->SetFont('Arial', 'B', 28);
                $pdf->SetTextColor(34, 49, 63);

                // Intentamos centrar el nombre en la zona aproximada. Ajusta Y según plantilla.
                $pageWidth = $pdf->GetPageWidth();
                $yPosition = 95; // posición vertical estimada; ajustar si es necesario
                $pdf->SetXY(0, $yPosition);
                $pdf->Cell($pageWidth, 10, $nombreImpreso, 0, 1, 'C');

                // Guardar PDF personalizado
                $pdf->Output('F', $destPath);
              } catch (\Throwable $e) {
                // Si hay cualquier fallo (falta la librería, error, etc.), hacemos copia simple como respaldo
                copy($src, $destPath);
              }
            }
          }
        }
      } catch (\Exception $e) {
        // No interrumpimos la experiencia si hay error en la generación
      }
    }

    return view('videos/landing', [
      'video' => $snippet,
      'id' => $id,
      'error' => null,
    ]);
  }
}
