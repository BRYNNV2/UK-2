<?php

namespace App\Controllers;

use App\Models\ProdiModel;
use App\Models\JurusanModel;

class Prodi extends BaseController
{
    public function index()
    {
        $model = new ProdiModel();
        $data['prodi'] = $model->getProdiWithJurusan();
        return view('admin/prodi/index', $data);
    }

    public function create()
    {
        $jurusanModel = new JurusanModel();
        
        // Fetch Kaprodis - users with 'kaprodi' role
        $db = \Config\Database::connect();
        $kaprodis = $db->table('2301020001_user')
                       ->select('2301020001_user.id, 2301020001_user.nama_user')
                       ->join('auth_groups_users', 'auth_groups_users.user_id = 2301020001_user.id')
                       ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                       ->where('auth_groups.name', 'kaprodi')
                       ->get()->getResultArray();

        $data = [
            'jurusan' => $jurusanModel->findAll(),
            'kaprodis' => $kaprodis
        ];
        return view('admin/prodi/create', $data);
    }

    public function store()
    {
        $model = new ProdiModel();
        
        if (!$this->validate([
            'nama_prodi' => 'required|min_length[3]',
            'jenjang'    => 'required',
            'id_jurusan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->save([
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'jenjang'    => $this->request->getPost('jenjang'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
            'id_kaprodi' => $this->request->getPost('id_kaprodi')
        ]);

        return redirect()->to('admin/prodi')->with('message', 'Prodi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new ProdiModel();
        $jurusanModel = new JurusanModel();

        $data['prodi']   = $model->find($id);
        $data['jurusan'] = $jurusanModel->findAll();

        // Fetch Kaprodis - users with 'kaprodi' role (and pimpinan for flexibility if needed, or just kaprodi)
        // Or users who CAN be kaprodi. For now fetch 'kaprodi' group.
        $db = \Config\Database::connect();
        $data['kaprodis'] = $db->table('2301020001_user')
                       ->select('2301020001_user.id, 2301020001_user.nama_user')
                       ->join('auth_groups_users', 'auth_groups_users.user_id = 2301020001_user.id')
                       ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
                       ->whereIn('auth_groups.name', ['kaprodi'])
                       ->get()->getResultArray();
        
        if (!$data['prodi']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/prodi/edit', $data);
    }

    public function update($id)
    {
        $model = new ProdiModel();

        if (!$this->validate([
            'nama_prodi' => 'required|min_length[3]',
            'jenjang'    => 'required',
            'id_jurusan' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'jenjang'    => $this->request->getPost('jenjang'),
            'id_jurusan' => $this->request->getPost('id_jurusan'),
            'id_kaprodi' => $this->request->getPost('id_kaprodi')
        ]);

        return redirect()->to('admin/prodi')->with('message', 'Prodi berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new ProdiModel();
        try {
            $model->delete($id);
            return redirect()->to('admin/prodi')->with('message', 'Prodi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/prodi')->with('error', 'Gagal menghapus data');
        }
    }
}
