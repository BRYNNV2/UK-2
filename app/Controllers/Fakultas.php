<?php

namespace App\Controllers;

use App\Models\FakultasModel;

class Fakultas extends BaseController
{
    public function index()
    {
        $model = new FakultasModel();
        $data['fakultas'] = $model->findAll();
        return view('admin/fakultas/index', $data);
    }

    public function create()
    {
        return view('admin/fakultas/create');
    }

    public function store()
    {
        $model = new FakultasModel();
        
        if (!$this->validate([
            'nama_fakultas' => 'required|min_length[3]|is_unique[2301020005_fakultas.nama_fakultas]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->save([
            'nama_fakultas' => $this->request->getPost('nama_fakultas')
        ]);

        return redirect()->to('admin/fakultas')->with('message', 'Fakultas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new FakultasModel();
        $data['fakultas'] = $model->find($id);
        
        if (!$data['fakultas']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/fakultas/edit', $data);
    }

    public function update($id)
    {
        $model = new FakultasModel();

        // Note: is_unique[table.field,ignore_field,ignore_value]
        if (!$this->validate([
            'nama_fakultas' => "required|min_length[3]|is_unique[2301020005_fakultas.nama_fakultas,id_fakultas,$id]"
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_fakultas' => $this->request->getPost('nama_fakultas')
        ]);

        return redirect()->to('admin/fakultas')->with('message', 'Fakultas berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new FakultasModel();
        try {
            $model->delete($id);
            return redirect()->to('admin/fakultas')->with('message', 'Fakultas berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/fakultas')->with('error', 'Gagal menghapus data (mungkin masih digunakan oleh data lain)');
        }
    }
}
