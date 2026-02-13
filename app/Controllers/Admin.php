<?php

namespace App\Controllers;

use App\Models\RegistroModel;
use App\Models\VideoModel;
use App\Models\VideoViewModel;

class Admin extends BaseController
{
    public function login()
    {
        $redirectParam = $this->request->getGet('redirect');
        $sanitizedRedirect = sanitize_redirect($redirectParam);

        if (session()->get('adminIsLoggedIn')) {
            return redirect()->to($sanitizedRedirect ?? '/admin/inscritos');
        }

        return view('admin/login', [
            'errors' => session('errors'),
            'redirect' => $sanitizedRedirect,
        ]);
    }

    public function authenticate()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        $redirect = sanitize_redirect($this->request->getPost('redirect')) ?? '/admin/inscritos';

        $expectedUser = (string) env('ADMIN_USER');
        $expectedPass = (string) env('ADMIN_PASS');

        if ($expectedUser === '' || $expectedPass === '') {
            return redirect()->back()->withInput()->with('errors', ['Credenciales de admin no configuradas.']);
        }

        if ($username === $expectedUser && $this->verifyPassword($password, $expectedPass)) {
            session()->set([
                'adminIsLoggedIn' => true,
                'adminUser' => $username,
            ]);

            return redirect()->to($redirect);
        }

        return redirect()->back()->withInput()->with('errors', ['Credenciales invalidas.']);
    }

    public function logout()
    {
        session()->remove(['adminIsLoggedIn', 'adminUser']);
        return redirect()->to('/admin/login')->with('message', 'Sesion cerrada.');
    }

    public function inscritos()
    {
        $filters = $this->getFiltersFromRequest();

        $registroModel = new RegistroModel();
        $videoModel = new VideoModel();
        $videoViewModel = new VideoViewModel();

        $inscritos = $registroModel->fetchAdminInscritos($filters);
        $videos = $videoModel->orderBy('orden', 'ASC')->findAll();

        $viewsByUser = [];
        $userIds = array_column($inscritos, 'id');
        if (! empty($userIds)) {
            $viewsByUser = $videoViewModel->fetchViewsByUsers($userIds, $filters);
        }

        return view('admin/inscritos', [
            'inscritos' => $inscritos,
            'viewsByUser' => $viewsByUser,
            'filters' => $filters,
            'videos' => $videos,
        ]);
    }

    public function videoViews()
    {
        $filters = $this->getFiltersFromRequest();

        $videoModel = new VideoModel();
        $videoViewModel = new VideoViewModel();

        $videos = $videoModel->orderBy('orden', 'ASC')->findAll();
        $rows = $videoViewModel->fetchVideoViewsReport($filters);

        return view('admin/video_views', [
            'rows' => $rows,
            'filters' => $filters,
            'videos' => $videos,
        ]);
    }

    public function exportInscritos()
    {
        $filters = $this->getFiltersFromRequest();

        $registroModel = new RegistroModel();
        $videoViewModel = new VideoViewModel();

        $inscritos = $registroModel->fetchAdminInscritos($filters);
        $userIds = array_column($inscritos, 'id');
        $viewsByUser = ! empty($userIds) ? $videoViewModel->fetchViewsByUsers($userIds, $filters) : [];

        $filename = 'inscritos_' . date('Ymd_His') . '.csv';

        return $this->buildCsvResponse(
            $filename,
            [
                'id',
                'nombres',
                'apellidos',
                'email',
                'celular',
                'ciudad',
                'nombre_farmacia',
                'viewed_videos',
                'last_viewed_at',
                'videos',
            ],
            $inscritos,
            static function (array $row) use ($viewsByUser): array {
                $views = $viewsByUser[$row['id']] ?? [];
                $videoList = [];
                foreach ($views as $view) {
                    $videoList[] = ($view['video_name'] ?? 'N/A') . ' | ' . ($view['viewed_at'] ?? '');
                }

                return [
                    $row['id'] ?? '',
                    $row['nombres'] ?? '',
                    $row['apellidos'] ?? '',
                    $row['email'] ?? '',
                    $row['celular'] ?? '',
                    $row['ciudad'] ?? '',
                    $row['nombre_farmacia'] ?? '',
                    $row['viewed_videos'] ?? 0,
                    $row['last_viewed_at'] ?? '',
                    implode('; ', $videoList),
                ];
            }
        );
    }

    public function exportVideoViews()
    {
        $filters = $this->getFiltersFromRequest();

        $videoViewModel = new VideoViewModel();
        $rows = $videoViewModel->fetchVideoViewsReport($filters);

        $filename = 'video_views_' . date('Ymd_His') . '.csv';

        return $this->buildCsvResponse(
            $filename,
            [
                'video_id',
                'video_name',
                'user_id',
                'nombres',
                'apellidos',
                'email',
                'viewed_at',
                'ip',
            ],
            $rows,
            static function (array $row): array {
                return [
                    $row['video_id'] ?? '',
                    $row['video_name'] ?? '',
                    $row['user_id'] ?? '',
                    $row['nombres'] ?? '',
                    $row['apellidos'] ?? '',
                    $row['email'] ?? '',
                    $row['viewed_at'] ?? '',
                    $row['ip'] ?? '',
                ];
            }
        );
    }

    public function exportInscritosVideos()
    {
        $videoViewModel = new VideoViewModel();
        $rows = $videoViewModel->fetchInscritosVideosReport();
        $filename = 'inscritos_videos_' . date('Ymd_His') . '.csv';

        return $this->buildCsvResponse(
            $filename,
            [
                'inscrito_id',
                'inscrito_nombres',
                'inscrito_apellidos',
                'inscrito_email',
                'ciudad',
                'nombre_cadena_distribuidor',
                'fecha_nacimiento',
                'video_id',
                'video_titulo',
                'ultima_vez_visto',
            ],
            $rows,
            static function (array $row): array {
                return [
                    $row['inscrito_id'] ?? '',
                    $row['inscrito_nombres'] ?? '',
                    $row['inscrito_apellidos'] ?? '',
                    $row['inscrito_email'] ?? 'NN',
                    $row['ciudad'] ?? 'NN',
                    $row['nombre_cadena_distribuidor'] ?? 'NN',
                    $row['fecha_nacimiento'] ?? '1900-01-01',
                    $row['video_id'] ?? 0,
                    $row['video_titulo'] ?? 'NN',
                    $row['ultima_vez_visto'] ?? '1900-01-01 00:00:00',
                ];
            }
        );
    }

    private function buildCsvResponse(string $filename, array $headers, array $rows, callable $rowMapper)
    {
        $csv = fopen('php://temp', 'r+');
        fputcsv($csv, $headers);

        foreach ($rows as $row) {
            fputcsv($csv, $rowMapper($row));
        }

        rewind($csv);
        $output = stream_get_contents($csv);
        fclose($csv);

        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }

    private function getFiltersFromRequest(): array
    {
        $filters = [
            'date_from' => $this->normalizeDate($this->request->getGet('date_from')),
            'date_to' => $this->normalizeDate($this->request->getGet('date_to')),
            'video_id' => $this->normalizeInt($this->request->getGet('video_id')),
            'q' => trim((string) $this->request->getGet('q')),
            'watched' => $this->normalizeWatched($this->request->getGet('watched')),
        ];

        return $filters;
    }

    private function normalizeDate($value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return '';
        }

        return $value;
    }

    private function normalizeInt($value): string
    {
        $value = trim((string) $value);
        if ($value === '' || ! ctype_digit($value)) {
            return '';
        }

        return $value;
    }

    private function normalizeWatched($value): string
    {
        $value = trim((string) $value);
        if ($value === '1' || $value === '0') {
            return $value;
        }

        return '';
    }

    private function verifyPassword(string $input, string $expected): bool
    {
        if (preg_match('/^\$2y\$/', $expected) || str_starts_with($expected, '$argon2')) {
            return password_verify($input, $expected);
        }

        return hash_equals($expected, $input);
    }
}
