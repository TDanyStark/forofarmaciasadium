<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    /**
     * This method runs before the controller.
     * If user is not logged in, redirect to /login
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Expect a boolean session key 'isLoggedIn'
        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    /**
     * This method runs after the controller.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no-op
    }
}
