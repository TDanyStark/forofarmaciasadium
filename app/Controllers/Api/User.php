<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    /**
     * Devuelve el email del usuario activo en JSON.
     * GET /api/user/email
     */
    public function email()
    {
        $session = session();

        $user = $session->get('user');

        if (empty($user) || ! is_array($user) && ! is_object($user)) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_NO_CONTENT)->setJSON(['email' => null]);
        }

        // Manejar entity u array
        $email = null;
        if (is_array($user) && isset($user['email'])) {
            $email = $user['email'];
        } elseif (is_object($user) && isset($user->email)) {
            $email = $user->email;
        } elseif (is_object($user) && method_exists($user, 'toArray')) {
            $arr = $user->toArray();
            $email = $arr['email'] ?? null;
        }

        return $this->response->setJSON(['email' => $email]);
    }
}
