<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class Certificado extends BaseController
{
    public function index()
    {
        $session = session();
        $user = $session->get('user');
        if (empty($user) || ! isset($user['id'])) {
            return redirect()->to('/login');
        }

        // Modelos para contar videos y vistas
        $videoModel = new \App\Models\VideoModel();
        $videoViewModel = new \App\Models\VideoViewModel();

        $totalVideos = (int) $videoModel->countAll();
        $views = $videoViewModel->where('user_id', $user['id'])->select('video_id')->distinct()->findAll();
        $viewedCount = count(array_unique(array_column($views, 'video_id')));
        $threshold = (int) ceil($totalVideos * 0.6);

        // Construir ruta donde el certificado personalizado debería haberse guardado
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

        // Use centralized service to compute path and eligibility
        $certService = new \App\Libraries\CertificadoService();
        $destPath = $certService->getDestPath($user);

        if ($totalVideos > 0 && $viewedCount >= $threshold && file_exists($destPath)) {
            return $this->response->download($destPath, null);
        }

        // No es elegible o aún no se creó el PDF: mostramos una vista informativa
        return view('certificado/index', [
            'viewedCount' => $viewedCount,
            'totalVideos' => $totalVideos,
            'threshold' => $threshold,
        ]);
    }
}
