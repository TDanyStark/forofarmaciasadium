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
        echo view('registro/register', $data);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Normalize checkbox
        $post['acepta_politica_datos'] = $this->request->getPost('acepta_politica_datos') ? 1 : 0;

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

        return redirect()->to('/registro/thankyou');
    }

    public function thankyou()
    {
        echo view('registro/thankyou');
    }
}
