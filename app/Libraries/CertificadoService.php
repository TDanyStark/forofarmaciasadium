<?php
namespace App\Libraries;

use App\Models\VideoModel;
use App\Models\VideoViewModel;
use setasign\Fpdi\Fpdi;

class CertificadoService
{
    protected VideoModel $videoModel;
    protected VideoViewModel $videoViewModel;

    public function __construct()
    {
        $this->videoModel = new VideoModel();
        $this->videoViewModel = new VideoViewModel();
    }

    protected function sanitizePart(string $str, $userId): string
    {
        $s = (string) $str;
        $trans = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        if ($trans !== false) {
            $s = $trans;
        }
        $s = preg_replace('/[^A-Za-z0-9]+/', '_', $s);
        $s = trim($s, '_');
        return $s === '' ? 'user' . ($userId ?? '0') : $s;
    }

    public function getNameParts(array $user): array
    {
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

        $safeFirst = $this->sanitizePart($primerNombre, $user['id'] ?? 0);
        $safeLast = $this->sanitizePart($primerApellido, $user['id'] ?? 0);

        $nombreImpreso = trim($primerNombre . ' ' . $primerApellido);

        return [
            'safeFirst' => $safeFirst,
            'safeLast' => $safeLast,
            'printed' => $nombreImpreso,
        ];
    }

    public function getDestPath(array $user): string
    {
        $parts = $this->getNameParts($user);
        $dir = WRITEPATH . 'uploads/certificados/' . ($user['id'] ?? '0') . '/';
        return $dir . 'certificado_foro_' . $parts['safeFirst'] . '_' . $parts['safeLast'] . '.pdf';
    }

    public function isEligible(array $user): bool
    {
        $totalVideos = (int) $this->videoModel->countAll();
        if ($totalVideos <= 0) {
            return false;
        }
        $views = $this->videoViewModel->where('user_id', $user['id'])->select('video_id')->distinct()->findAll();
        $viewedVideoIds = array_unique(array_column($views, 'video_id'));
        $viewedCount = count($viewedVideoIds);
        $threshold = (int) ceil($totalVideos * 0.6);
        return $viewedCount >= $threshold;
    }

    /**
     * Ensure certificate PDF exists for user. Returns path or null on failure.
     * This will create parent directory if needed.
     */
    public function ensureCertificateExists(array $user): ?string
    {
        $destPath = $this->getDestPath($user);
        if (file_exists($destPath)) {
            return $destPath;
        }

        $src = FCPATH . 'certificado_template/foroAdium2025.pdf';
        if (! file_exists($src)) {
            return null;
        }

        $destDir = dirname($destPath);
        if (! is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $parts = $this->getNameParts($user);
        $nombreImpreso = $parts['printed'];

        try {
            $pdf = new Fpdi();
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

            $fontDefFile = 'Montserrat-Medium.php';
            $fontDefPath = FCPATH . 'fonts/' . $fontDefFile;
            $fontFamily = 'Montserrat';
            if (file_exists($fontDefPath)) {
                $pdf->AddFont($fontFamily, '', $fontDefFile, FCPATH . 'fonts/');
                $pdf->SetFont($fontFamily, '', 55);
            } else {
                $pdf->SetFont('helvetica', 'B', 55);
            }
            $pdf->SetTextColor(34, 49, 63);

            $x = 30;
            $y = 114;
            $w = 311;
            $h = 30;

            $pdf->SetXY($x, $y);
            $pdf->Cell($w, $h, $nombreImpreso, 0, 1, 'C');

            $pdf->Output('F', $destPath);
        } catch (\Throwable $e) {
            // Fallback: copy template so the user has at least a certificate file
            try {
                copy($src, $destPath);
            } catch (\Throwable $_) {
                return null;
            }
        }

        return file_exists($destPath) ? $destPath : null;
    }
}
