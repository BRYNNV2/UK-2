<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $model = new MahasiswaModel();
        $data['mahasiswa'] = $model->getMahasiswaWithProdi();
        return view('admin/mahasiswa/index', $data);
    }

    public function create()
    {
        $prodiModel = new ProdiModel();
        $data['prodi'] = $prodiModel->findAll();
        return view('admin/mahasiswa/create', $data);
    }

    public function store()
    {
        $model = new MahasiswaModel();
        
        if (!$this->validate([
            'nim'            => 'required|min_length[5]|is_unique[mahasiswa.nim]',
            'nama_mahasiswa' => 'required|min_length[3]',
            'id_prodi'       => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Create User Account (Myth:Auth)
        $userModel = new UserModel();
        $groupModel = new GroupModel();

        $nim = $this->request->getPost('nim');
        
        $userInfo = [
            'username' => $nim,
            'email'    => $nim . '@monitor.id', // Dummy email
            'password' => $nim, // Default password = NIM
            'pass_confirm' => $nim,
            'active'   => 1,
            'nama_user'=> $this->request->getPost('nama_mahasiswa')
        ];

        $userId = $userModel->insert($userInfo);

        if (!$userId) {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }

        // 2. Assign Role 'mahasiswa'
        // Check if group exists first or just assume? Seeder should have created it.
        // Group ID for mahasiswa? Or use name. addToGroup uses group_id. We need to find group id by name 'mahasiswa'
        $group = $groupModel->where('name', 'mahasiswa')->first();
        if ($group) {
            $groupModel->addUserToGroup($userId, $group->id);
        }

        // 3. Save Mahasiswa Data
        $model->save([
            'nim'            => $nim,
            'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
            'id_prodi'       => $this->request->getPost('id_prodi'),
            'id_user'        => $userId
        ]);

        return redirect()->to('admin/mahasiswa')->with('message', 'Mahasiswa (dan Akun Login) berhasil ditambahkan');
    }

    public function edit($nim)
    {
        $model = new MahasiswaModel();
        $prodiModel = new ProdiModel();

        $data['mahasiswa'] = $model->find($nim);
        $data['prodi']     = $prodiModel->findAll();
        
        if (!$data['mahasiswa']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/mahasiswa/edit', $data);
    }

    public function update($nim)
    {
        $model = new MahasiswaModel();

        // Validasi NIM unik kecuali untuk diri sendiri
        if (!$this->validate([
            'nim'            => "required|min_length[5]|is_unique[mahasiswa.nim,nim,$nim]",
            'nama_mahasiswa' => 'required|min_length[3]',
            'id_prodi'       => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Karena primary key adalah NIM dan bukan auto-increment, update harus hati-hati jika NIM berubah
        // Tapi biasanya NIM tidak boleh berubah. Untuk kemudahan kita anggap NIM bisa diedit lewat delete-insert atau update cascade
        // CodeIgniter save() or update() works based on primary key.
        
        $data = [
            'nama_mahasiswa' => $this->request->getPost('nama_mahasiswa'),
            'id_prodi'       => $this->request->getPost('id_prodi')
        ];
        
        // Cek apakah NIM berubah
        $newNim = $this->request->getPost('nim');
        if($newNim != $nim) {
            $data['nim'] = $newNim;
        }

        $model->update($nim, $data);

        return redirect()->to('admin/mahasiswa')->with('message', 'Mahasiswa berhasil diupdate');
    }

    public function delete($nim)
    {
        $model = new MahasiswaModel();
        try {
            $model->delete($nim);
            return redirect()->to('admin/mahasiswa')->with('message', 'Mahasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/mahasiswa')->with('error', 'Gagal menghapus data');
        }
    }
}
