<?php

namespace App\Controllers;

use App\Models\PeriodeModel;

class Periode extends BaseController
{
    public function index()
    {
        $model = new PeriodeModel();
        $data['periode'] = $model->findAll();
        return view('admin/periode/index', $data);
    }

    public function create()
    {
        return view('admin/periode/create');
    }

    public function store()
    {
        $model = new PeriodeModel();
        
        $semester = $this->request->getPost('semester'); // Ganjil / Genap
        $tahun    = $this->request->getPost('tahun');    // 2024/2025

        $keterangan = "$semester $tahun";

        $model->save([
            'keterangan'     => $keterangan,
            'status_periode' => $this->request->getPost('status_periode') ?? 'Tidak Aktif'
        ]);

        return redirect()->to('admin/periode')->with('message', 'Periode berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new PeriodeModel();
        $data['periode'] = $model->find($id);
        
        if (!$data['periode']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Try to split keterangan back into parts for the edit form
        // Assuming format "Semester Tahun" e.g. "Ganjil 2024/2025"
        $parts = explode(' ', $data['periode']['keterangan']);
        $data['current_semester'] = $parts[0] ?? '';
        $data['current_tahun']    = $parts[1] ?? '';

        return view('admin/periode/edit', $data);
    }

    public function update($id)
    {
        $model = new PeriodeModel();

        $semester = $this->request->getPost('semester');
        $tahun    = $this->request->getPost('tahun');
        $keterangan = "$semester $tahun";

        $model->update($id, [
            'keterangan'     => $keterangan,
            'status_periode' => $this->request->getPost('status_periode')
        ]);

        return redirect()->to('admin/periode')->with('message', 'Periode berhasil diupdate');
    }

    public function delete($id)
    {
        $model = new PeriodeModel();
        try {
            $model->delete($id);
            return redirect()->to('admin/periode')->with('message', 'Periode berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('admin/periode')->with('error', 'Gagal menghapus data (mungkin ada relasi data kuisioner)');
        }
    }
}
