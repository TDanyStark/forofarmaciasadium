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

        $destPath = WRITEPATH . 'uploads/certificados/certificado_user_' . $user['id'] . '.pdf';

        if ($totalVideos > 0 && $viewedCount >= $threshold && file_exists($destPath)) {
            // Forzamos la descarga del certificado
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
