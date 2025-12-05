<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InscritoModel;

class Inscritos extends BaseController
{
    protected $inscritoModel;

    public function __construct()
    {
        $this->inscritoModel = new InscritoModel();
        helper(['form', 'url']);
    }

    public function create()
    {
        $data = [];
        $data['errors'] = session('errors');
        echo view('inscritos/register', $data);
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Normalize checkbox
        $post['acepta_politica_datos'] = $this->request->getPost('acepta_politica_datos') ? 1 : 0;

        $rules = $this->inscritoModel->getRules();

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Only save allowed fields
        $saveData = [];
        foreach ($this->inscritoModel->allowedFields as $field) {
            if (array_key_exists($field, $post)) {
                $saveData[$field] = $post[$field];
            }
        }

        $this->inscritoModel->insert($saveData);

        return redirect()->to('/inscritos/thankyou');
    }

    public function thankyou()
    {
        echo view('inscritos/thankyou');
    }
}
