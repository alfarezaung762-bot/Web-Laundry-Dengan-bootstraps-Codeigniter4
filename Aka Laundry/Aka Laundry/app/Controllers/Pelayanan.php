<?php

namespace App\Controllers;

use App\Models\PaketLayananModel;

class Pelayanan extends BaseController
{
    public function index()
    {
        $model = new PaketLayananModel();
        $data['paket'] = $model->findAll();
        return view('user/paket', $data);
    }

    public function edit($id)
    {
        $model = new PaketLayananModel();
        $data['paket'] = $model->find($id);
        return view('user/edit_paket', $data);
    }

    public function update($id)
    {
        $model = new PaketLayananModel();
        $model->update($id, [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'feature1' => $this->request->getPost('feature1'),
            'feature2' => $this->request->getPost('feature2'),
            'feature3' => $this->request->getPost('feature3'),
            'color' => $this->request->getPost('color'),

        ]);
        return redirect()->to('/user/kelola_paket');
    }

    public function kelola()
    {
        $model = new \App\Models\PaketLayananModel();
        $data['paket'] = $model->findAll();
        return view('user/kelola_paket', $data);
    }
}
