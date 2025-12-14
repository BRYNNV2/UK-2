<?php

namespace App\Controllers;

use App\Models\PertanyaanModel;
use App\Models\ProdiModel;
use App\Models\PilihanJawabanModel;

class Pertanyaan extends BaseController
{
    public function index()
    {
        $model = new PertanyaanModel();
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);

        if ($isKaprodi) {
            // Find Prodi assigned to this Kaprodi
            $prodiModel = new ProdiModel();
            $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
            
            if ($assignedProdi) {
                // Filter questions for this Prodi
                // Note: getPertanyaanWithProdi joins prodi table. We can filter on prodi.id_prodi
                $data['pertanyaan'] = $model->select('pertanyaan.*, prodi.nama_prodi')
                                            ->join('prodi', 'prodi.id_prodi = pertanyaan.id_prodi')
                                            ->where('pertanyaan.id_prodi', $assignedProdi['id_prodi'])
                                            ->findAll();
            } else {
                $data['pertanyaan'] = [];
            }
        } else {
            $data['pertanyaan'] = $model->getPertanyaanWithProdi();
        }
        
        return view('admin/pertanyaan/index', $data);
    }

    public function create()
    {
        $prodiModel = new ProdiModel();
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);
        
        if ($isKaprodi) {
             $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
             $data['prodi'] = $assignedProdi ? [$assignedProdi] : [];
             $data['isKaprodi'] = true;
             $data['lockedProdiId'] = $assignedProdi['id_prodi'] ?? null;
        } else {
             $data['prodi'] = $prodiModel->findAll();
             $data['isKaprodi'] = false;
        }

        return view('admin/pertanyaan/create', $data);
    }

    public function store()
    {
        $model = new PertanyaanModel();
        $opsiModel = new PilihanJawabanModel();
        
        // Security: If Kaprodi, ensure id_prodi matches their assignment
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);
        $inputProdiId = $this->request->getPost('id_prodi');

        if ($isKaprodi) {
            $prodiModel = new ProdiModel();
            $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
            if (!$assignedProdi || $assignedProdi['id_prodi'] != $inputProdiId) {
                 return redirect()->back()->withInput()->with('error', 'Anda tidak memiliki hak akses ke prodi ini.');
            }
        }


        if (!$this->validate([
            'pertanyaan' => 'required|min_length[5]',
            'id_prodi'   => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Simpan Pertanyaan
        $id_pertanyaan = $model->insert([
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'id_prodi'   => $inputProdiId
        ]);

        // 2. Auto-generate Opsi Jawaban (Template 5 Skala Likert)
        $opsiStandard = ['Sangat Baik', 'Baik', 'Cukup', 'Kurang', 'Sangat Kurang'];
        
        foreach ($opsiStandard as $opsi) {
            $opsiModel->insert([
                'id_pertanyaan' => $id_pertanyaan,
                'deskripsi_pilihan' => $opsi
            ]);
        }

        return redirect()->to('admin/pertanyaan')->with('message', 'Pertanyaan (dan opsi otomatis) berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new PertanyaanModel();
        $prodiModel = new ProdiModel();

        $data['pertanyaan'] = $model->find($id);
        
        // Security check for edit
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);
        
        if ($isKaprodi) {
             $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
             if (!$assignedProdi || $assignedProdi['id_prodi'] != $data['pertanyaan']['id_prodi']) {
                  return redirect()->to('admin/pertanyaan')->with('error', 'Akses ditolak.');
             }
             $data['prodi'] = [$assignedProdi];
        } else {
             $data['prodi'] = $prodiModel->findAll();
        }

        
        if (!$data['pertanyaan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/pertanyaan/edit', $data);
    }

    public function update($id)
    {
        $model = new PertanyaanModel();

        if (!$this->validate([
            'pertanyaan' => 'required|min_length[5]',
            'id_prodi'   => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            'id_prodi'   => $this->request->getPost('id_prodi')
        ]);

        return redirect()->to('admin/pertanyaan')->with('message', 'Pertanyaan berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new PertanyaanModel();
        try {
            $model->delete($id);
            return redirect()->to('admin/pertanyaan')->with('message', 'Pertanyaan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/pertanyaan')->with('error', 'Gagal menghapus data');
        }
    }
}
