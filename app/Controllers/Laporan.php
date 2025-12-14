<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;
use App\Models\PertanyaanModel;
use App\Models\PilihanJawabanModel;
use App\Models\JawabanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        $prodiModel = new ProdiModel();
        $auth = service('authentication');
        $userId = $auth->id();
        
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);
        $assignedProdi = null;

        if ($isKaprodi) {
            // Find Prodi assigned to this Kaprodi
            $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
        }

        $data = [
            'periodes' => $periodeModel->findAll(),
            // If Kaprodi, only show their Prodi. If Admin/Pimpinan, show all.
            'prodis' => ($isKaprodi && $assignedProdi) ? [$assignedProdi] : $prodiModel->findAll(),
            'isKaprodi' => $isKaprodi,
            'assignedProdi' => $assignedProdi
        ];

        return view('admin/laporan/index', $data);
    }

    public function result()
    {
        $id_periode = $this->request->getVar('id_periode');
        $id_prodi = $this->request->getVar('id_prodi');

        // Security Check for Kaprodi
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);

        if ($isKaprodi) {
            $prodiModel = new ProdiModel();
            $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
            
            // If no prodi assigned or trying to access other prodi
            if (!$assignedProdi || $assignedProdi['id_prodi'] != $id_prodi) {
                return redirect()->back()->with('error', 'Anda hanya dapat mengakses laporan Prodi Anda sendiri.');
            }
        }

        if (!$id_periode || (!$id_prodi && !$isKaprodi)) { // Logic tweak: if Kaprodi but no ID sent? 
             // Actually form sends ID. If ID missing, error.
             if (!$id_prodi) return redirect()->back()->with('error', 'Silakan pilih Periode dan Prodi.');
        }

        $pertanyaanModel = new PertanyaanModel();
        $pilihanModel = new PilihanJawabanModel();
        $jawabanModel = new JawabanModel();
        $periodeModel = new PeriodeModel();
        $prodiModel = new ProdiModel(); // Re-instantiate if needed

        $data['periode'] = $periodeModel->find($id_periode);
        $data['prodi'] = $prodiModel->find($id_prodi);
        
        // Fetch Questions for this Prodi
        // Note: Questions are linked to Prodi.
        $questions = $pertanyaanModel->where('id_prodi', $id_prodi)->findAll();

        // Calculate Stats
        foreach ($questions as &$q) {
            $q['options'] = $pilihanModel->where('id_pertanyaan', $q['id_pertanyaan'])->findAll();
            $q['total_responden'] = 0;
            
            foreach ($q['options'] as &$opt) {
                // Count answers matching this option and period
                $count = $jawabanModel->where('id_pilihan_jawaban_pertanyaan', $opt['id_pilihan_jawaban'])
                                      ->where('id_periode', $id_periode)
                                      ->countAllResults();
                $opt['count'] = $count;
                $q['total_responden'] += $count;
            }
        }

        $data['questions'] = $questions;

        return view('admin/laporan/result', $data);
    }
}
