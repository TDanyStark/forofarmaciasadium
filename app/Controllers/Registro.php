<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegistroModel;

class Registro extends BaseController
{
    protected $registroModel;
    public function __construct()
    {
        $this->registroModel = new RegistroModel();
        helper(['form', 'url']);
    }

    public function create()
    {
        $redirectParam = $this->request->getGet('redirect');
        $redirectResponse = $this->redirectIfLoggedIn($redirectParam);
        if ($redirectResponse) {
            return $redirectResponse;
        }

        return view('registro/register', $this->buildAuthViewData($redirectParam));
    }

    /**
     * Show simple login form (asks only for email)
     */
    public function login()
    {
        $redirectParam = $this->request->getGet('redirect');
        $redirectResponse = $this->redirectIfLoggedIn($redirectParam);
        if ($redirectResponse) {
            return $redirectResponse;
        }

        return view('registro/login', $this->buildAuthViewData($redirectParam));
    }

    /**
     * Process email submission: if email exists in inscritos, redirect home,
     * otherwise redirect to registration with email prefilled.
     */
    public function checkEmail()
    {
        $email = $this->request->getPost('email');

        if (! $this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $found = $this->registroModel->where('email', $email)->first();

        $destination = sanitize_redirect($this->request->getPost('redirect')) ?? '/';

        if ($found) {
            // Email exists - start session and redirect home
            $this->setUserSession($found);

            return redirect()->to($destination)->with('message', 'Sesión iniciada.');
        }

        // Not found - redirect to the registration form with email prefilled
        $queryParams = ['email' => $email];

        if ($destination !== '/') {
            $queryParams['redirect'] = $destination;
        }

        $query = http_build_query($queryParams);
        $url = site_url('registro') . ($query ? '?' . $query : '');
        return redirect()->to($url);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Normalize checkbox
        $post['acepta_politica_datos'] = $this->request->getPost('acepta_politica_datos') ? 1 : 0;

        // If email already exists, redirect to home (prevent duplicate)
        $email = isset($post['email']) ? trim($post['email']) : null;
        if ($email) {
            $exists = $this->registroModel->where('email', $email)->first();
            if ($exists) {
                return redirect()->to('/')->with('message', 'El correo ya está registrado.');
            }
        }

        $rules = $this->registroModel->getRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Only save allowed fields
        $saveData = [];
        foreach ($this->registroModel->allowedFields as $field) {
            if (array_key_exists($field, $post)) {
                $saveData[$field] = $post[$field];
            }
        }

        $this->registroModel->insert($saveData);

        // Log the user in after successful registration
        $insertId = $this->registroModel->getInsertID();
        $user = $this->registroModel->find($insertId);
        if ($user) {
            $this->setUserSession($user);
        }

        $destination = sanitize_redirect($this->request->getPost('redirect')) ?? '/';

        return redirect()->to($destination)->with('message', 'Registro completado.');
    }

    /**
     * Cierra la sesión del usuario y redirige a la página principal.
     */
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/')->with('message', 'Sesión cerrada.');
    }

    private function redirectIfLoggedIn(?string $redirectParam)
    {
        $sanitizedRedirect = sanitize_redirect($redirectParam);

        if (session()->get('isLoggedIn')) {
            return redirect()->to($sanitizedRedirect ?? '/');
        }

        return null;
    }

    private function buildAuthViewData(?string $redirectParam): array
    {
        return [
            'errors' => session('errors'),
            'email' => $this->request->getGet('email') ?? null,
            'redirect' => sanitize_redirect($redirectParam),
        ];
    }

    private function setUserSession($user): void
    {
        $userData = is_object($user) && method_exists($user, 'toArray') ? $user->toArray() : (array) $user;
        session()->set([
            'isLoggedIn' => true,
            'user' => $userData,
        ]);
    }
}
