<?php

namespace App\Controllers;

use App\Models\JurusanModel;
use App\Models\FakultasModel;

class Jurusan extends BaseController
{
    public function index()
    {
        $model = new JurusanModel();
        $data['jurusan'] = $model->getJurusanWithFakultas();
        return view('admin/jurusan/index', $data);
    }

    public function create()
    {
        $fakultasModel = new FakultasModel();
        $data['fakultas'] = $fakultasModel->findAll();
        return view('admin/jurusan/create', $data);
    }

    public function store()
    {
        $model = new JurusanModel();
        
        if (!$this->validate([
            'nama_jurusan' => 'required|min_length[3]',
            'id_fakultas'  => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->save([
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            'id_fakultas'  => $this->request->getPost('id_fakultas')
        ]);

        return redirect()->to('admin/jurusan')->with('message', 'Jurusan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new JurusanModel();
        $fakultasModel = new FakultasModel();

        $data['jurusan']  = $model->find($id);
        $data['fakultas'] = $fakultasModel->findAll();
        
        if (!$data['jurusan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/jurusan/edit', $data);
    }

    public function update($id)
    {
        $model = new JurusanModel();

        if (!$this->validate([
            'nama_jurusan' => 'required|min_length[3]',
            'id_fakultas'  => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_jurusan' => $this->request->getPost('nama_jurusan'),
            'id_fakultas'  => $this->request->getPost('id_fakultas')
        ]);

        return redirect()->to('admin/jurusan')->with('message', 'Jurusan berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new JurusanModel();
        try {
            $model->delete($id);
            return redirect()->to('admin/jurusan')->with('message', 'Jurusan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/jurusan')->with('error', 'Gagal menghapus data (mungkin masih digunakan oleh Prodi)');
        }
    }
}
