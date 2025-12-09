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


        // Comprobamos si el usuario fue registrado en la tabla `certificados` (elegible)
        $certModel = new \App\Models\CertificadoModel();
        $certRow = $certModel->where('user_id', $user['id'])->first();

        $certService = new \App\Libraries\CertificadoService();
        $destPath = $certService->getDestPath($user);

        if (empty($certRow)) {
            // Usuario no registrado como elegible: mostramos la vista informativa
            return view('certificado/index', [
                'viewedCount' => $viewedCount,
                'totalVideos' => $totalVideos,
                'threshold' => $threshold,
            ]);
        }

        // Usuario registrado en `certificados`: generamos (si hace falta) y servimos el PDF
        $pdfPath = $certService->ensureCertificateExists($user);
        if ($pdfPath && file_exists($pdfPath)) {
            try {
                $certModel->update($certRow['id'], [
                    'is_downloaded' => 1,
                    'download_date' => date('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $_) {
                // No bloquear la descarga si la actualización falla
            }
            return $this->response->download($pdfPath, null);
        }

        // Si no se pudo crear aún el PDF, mostramos la vista informativa
        return view('certificado/index', [
            'viewedCount' => $viewedCount,
            'totalVideos' => $totalVideos,
            'threshold' => $threshold,
        ]);
    }
}
