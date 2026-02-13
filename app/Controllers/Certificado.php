<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Certificado extends BaseController
{
    public function index()
    {
        $user = $this->getSessionUser();
        if ($user === null) {
            return redirect()->to('/login');
        }

        // Modelos para contar videos y vistas
        $videoModel = new \App\Models\VideoModel();
        $videoViewModel = new \App\Models\VideoViewModel();

        $stats = $videoViewModel->fetchUserViewStats((int) $user['id']);
        $totalVideos = $stats['totalVideos'];
        $viewedCount = $stats['viewedCount'];
        $threshold = $stats['threshold'];

        // Comprobamos si el usuario fue registrado en la tabla `certificados` (elegible)
        $certModel = new \App\Models\CertificadoModel();
        $certRow = $certModel->where('user_id', $user['id'])->first();

        $isEligible = !empty($certRow);

        return view('certificado/index', [
            'viewedCount' => $viewedCount,
            'totalVideos' => $totalVideos,
            'threshold' => $threshold,
            'isEligible' => $isEligible,
        ]);
    }

    public function download()
    {
        return $this->serveFile(true);
    }

    public function preview()
    {
        return $this->serveFile(false);
    }

    private function serveFile($download = true)
    {
        $user = $this->getSessionUser();
        if ($user === null) {
            return redirect()->to('/login');
        }

        $certModel = new \App\Models\CertificadoModel();
        $certRow = $certModel->where('user_id', $user['id'])->first();

        if (empty($certRow)) {
            return redirect()->to('/certificado');
        }

        $certService = new \App\Libraries\CertificadoService();
        $pdfPath = $certService->ensureCertificateExists($user);

        if ($pdfPath && file_exists($pdfPath)) {
            if ($download) {
                try {
                    $certModel->update($certRow['id'], [
                        'is_downloaded' => 1,
                        'download_date' => date('Y-m-d H:i:s'),
                    ]);
                } catch (\Exception $_) {
                    // No bloquear la descarga si la actualización falla
                }
                return $this->response->download($pdfPath, null);
            } else {
                // Serve inline
                $fileContent = file_get_contents($pdfPath);
                return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'inline; filename="certificado.pdf"')
                    ->setBody($fileContent);
            }
        }

        return redirect()->to('/certificado')->with('error', 'No se pudo generar el certificado.');
    }
}
