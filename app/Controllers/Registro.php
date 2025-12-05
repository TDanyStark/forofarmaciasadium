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
        $data = [];
        $data['errors'] = session('errors');
        // Allow pre-filling email when redirected from login
        $data['email'] = $this->request->getGet('email') ?? null;
        echo view('registro/register', $data);
    }

    /**
     * Show simple login form (asks only for email)
     */
    public function login()
    {
        $data = [];
        $data['errors'] = session('errors');
        // allow prefill from query param
        $data['email'] = $this->request->getGet('email') ?? null;
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

        if ($found) {
            // Email exists - for now redirect to home (could start a session)
            return redirect()->to('/')->with('message', 'Email encontrado.');
        }

        // Not found - redirect to the registration form with email prefilled
        $url = site_url('registro') . '?email=' . urlencode($email);
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

        return redirect()->to('/')->with('message', 'Registro completado.');
    }
}
