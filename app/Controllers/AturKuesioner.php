<?php

namespace App\Controllers;

use App\Models\PertanyaanModel;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;

class AturKuesioner extends BaseController
{
    public function index()
    {
        $periodeModel = new PeriodeModel();
        $data['periodes'] = $periodeModel->findAll();
        return view('admin/atur_kuesioner/index', $data);
    }

    public function edit($id_periode)
    {
        $periodeModel = new PeriodeModel();
        $pertanyaanModel = new PertanyaanModel();
        $db = \Config\Database::connect();
        
        // Auth Check
        $auth = service('authentication');
        $userId = $auth->id();
        $isKaprodi = service('authorization')->inGroup('kaprodi', $userId);
        $prodiModel = new ProdiModel();

        if (!$isKaprodi) {
             return redirect()->to('admin/dashboard')->with('error', 'Hanya Kaprodi yang dapat mengatur pertanyaan prodi.');
        }

        $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
        if (!$assignedProdi) {
             return redirect()->to('admin/dashboard')->with('error', 'Anda belum ditugaskan ke Prodi manapun.');
        }

        $data['periode'] = $periodeModel->find($id_periode);
        $data['prodi'] = $assignedProdi;

        // Get All Questions for this Prodi
        $allQuestions = $pertanyaanModel->where('id_prodi', $assignedProdi['id_prodi'])->findAll();

        // Get Currently Active Questions for this Period
        $activeQuestions = $db->table('pertanyaan_periode_kuisioner')
                              ->where('id_periode_kuisioner', $id_periode)
                              ->get()->getResultArray();
        
        $activeIds = array_column($activeQuestions, 'id_pertanyaan');

        // Mark 'selected'
        foreach ($allQuestions as &$q) {
            $q['selected'] = in_array($q['id_pertanyaan'], $activeIds);
        }

        $data['questions'] = $allQuestions;

        return view('admin/atur_kuesioner/edit', $data);
    }

    public function save($id_periode)
    {
        $db = \Config\Database::connect();
        $selectedQuestions = $this->request->getPost('questions'); // Array of IDs

        // 1. Clear existing questions for this period AND this Prodi's questions
        // We must be careful not to delete questions from OTHER Prodis for the same Period!
        // So step 1: Find IDs of questions belonging to CURRENT prodi
        $auth = service('authentication');
        $userId = $auth->id();
        $prodiModel = new ProdiModel();
        $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
        
        // Get IDs of questions owned by this prodi
        $pertanyaanModel = new PertanyaanModel();
        $myQuestionIds = $pertanyaanModel->where('id_prodi', $assignedProdi['id_prodi'])->findColumn('id_pertanyaan');

        if ($myQuestionIds) {
            $builder = $db->table('pertanyaan_periode_kuisioner');
            $builder->where('id_periode_kuisioner', $id_periode);
            $builder->whereIn('id_pertanyaan', $myQuestionIds);
            $builder->delete();
        }

        // 2. Insert new selections
        if ($selectedQuestions) {
            $dataToInsert = [];
            foreach ($selectedQuestions as $qid) {
                $dataToInsert[] = [
                    'id_periode_kuisioner' => $id_periode,
                    'id_pertanyaan' => $qid
                ];
            }
            if (!empty($dataToInsert)) {
                $db->table('pertanyaan_periode_kuisioner')->insertBatch($dataToInsert);
            }
        }

        return redirect()->to('admin/atur-kuesioner/edit/'.$id_periode)->with('message', 'Pertanyaan berhasil disimpan untuk periode ini.');
    }
}
