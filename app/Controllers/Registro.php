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
        $sanitizedRedirect = $this->sanitizeRedirect($redirectParam);

        // If already logged in, send to destination or home
        if (session()->get('isLoggedIn')) {
            return redirect()->to($sanitizedRedirect ?? '/');
        }
        $data = [];
        $data['errors'] = session('errors');
        // Allow pre-filling email when redirected from login
        $data['email'] = $this->request->getGet('email') ?? null;
        $data['redirect'] = $sanitizedRedirect;
        echo view('registro/register', $data);
    }

    /**
     * Show simple login form (asks only for email)
     */
    public function login()
    {
        $redirectParam = $this->request->getGet('redirect');
        $sanitizedRedirect = $this->sanitizeRedirect($redirectParam);

        // If already logged in, send to destination or home
        if (session()->get('isLoggedIn')) {
            return redirect()->to($sanitizedRedirect ?? '/');
        }
        $data = [];
        $data['errors'] = session('errors');
        // allow prefill from query param
        $data['email'] = $this->request->getGet('email') ?? null;
        $data['redirect'] = $sanitizedRedirect;
        echo view('registro/login', $data);
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

        $destination = $this->sanitizeRedirect($this->request->getPost('redirect')) ?? '/';

        if ($found) {
            // Email exists - start session and redirect home
            $session = session();
            // store minimal user info; entity -> toArray()
            $userData = is_object($found) && method_exists($found, 'toArray') ? $found->toArray() : (array) $found;
            $session->set([
                'isLoggedIn' => true,
                'user' => $userData,
            ]);

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
            $session = session();
            $userData = is_object($user) && method_exists($user, 'toArray') ? $user->toArray() : (array) $user;
            $session->set([
                'isLoggedIn' => true,
                'user' => $userData,
            ]);
        }

        $destination = $this->sanitizeRedirect($this->request->getPost('redirect')) ?? '/';

        return redirect()->to($destination)->with('message', 'Registro completado.');
    }

    private function sanitizeRedirect(?string $target): ?string
    {
        if ($target === null) {
            return null;
        }

        $candidate = rawurldecode($target);
        $candidate = trim($candidate);

        if ($candidate === '') {
            return null;
        }

        if (! str_starts_with($candidate, '/') || str_starts_with($candidate, '//') || strpos($candidate, '://') !== false) {
            return null;
        }

        return $candidate;
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
}
