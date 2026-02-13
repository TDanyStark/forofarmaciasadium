<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        log_message('error', 'ADMIN PATH: ' . $request->getUri()->getPath());

        $path = trim($request->getUri()->getPath(), '/');
        if ($path === 'admin/login') {
            return null;
        }

        if (! $session->get('adminIsLoggedIn')) {
            $uri = $request->getUri();

            $redirectPath = $uri->getPath();
            $queryString = $uri->getQuery();

            if ($queryString !== '') {
                $redirectPath .= '?' . $queryString;
            }

            $redirectTarget = '/' . ltrim($redirectPath, '/');

            return redirect()->to('/admin/login?redirect=' . rawurlencode($redirectTarget));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
