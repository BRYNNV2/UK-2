<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\PeriodeModel;
use App\Models\PertanyaanModel;
use App\Models\PilihanJawabanModel;
use App\Models\JawabanModel;

class Student extends BaseController
{
    public function index()
    {
        helper('auth');
        $model = new MahasiswaModel();
        $periodeModel = new PeriodeModel();
        $jawabanModel = new JawabanModel();

        $userId = user_id();
        $mahasiswa = $model->where('id_user', $userId)->first();

        // Get Active Periode
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();
        
        // Check if student has submitted for this period
        $hasSubmitted = false;
        if ($activePeriode && $mahasiswa) {
            $check = $jawabanModel->where('nim', $mahasiswa['nim'])
                                  ->where('id_periode', $activePeriode['id_periode'])
                                  ->first();
            if ($check) {
                $hasSubmitted = true;
            }
        }

        $data = [
            'mahasiswa' => $mahasiswa,
            'activePeriode' => $activePeriode,
            'hasSubmitted' => $hasSubmitted
        ];

        return view('student/dashboard', $data);
    }

    public function profile()
    {
        helper('auth');
        $model = new MahasiswaModel();
        $userId = user_id();
        $mahasiswa = $model->where('id_user', $userId)->first();
        
        $prodiModel = new \App\Models\ProdiModel();
        $prodi = null;
        if ($mahasiswa && isset($mahasiswa['id_prodi'])) {
            $prodi = $prodiModel->find($mahasiswa['id_prodi']);
        }
        
        $data = [
            'mahasiswa' => $mahasiswa,
            'prodi' => $prodi,
            'user' => user()
        ];
        
        return view('student/profile', $data);
    }

    public function kuesioner()
    {
        helper('auth');
        $mahasiswaModel = new MahasiswaModel();
        $periodeModel = new PeriodeModel();
        $pertanyaanModel = new PertanyaanModel(); // Need to join options manually or loop
        $pilihanModel = new PilihanJawabanModel();

        $userId = user_id();
        $mahasiswa = $mahasiswaModel->where('id_user', $userId)->first();
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();

        // Debugging Block
        $validation = $this->validateRequirement($mahasiswa, $activePeriode);
        if ($validation !== true) {
            return $validation;
        }

        // Get Questions for Student's Prodi assigned to Active Periode
        $db = \Config\Database::connect();
        $questions = $db->table('2301020088_pertanyaan')
                        ->select('2301020088_pertanyaan.*')
                        ->join('2301020104_pertanyaan_periode_kuisioner', '2301020088_pertanyaan.id_pertanyaan = 2301020104_pertanyaan_periode_kuisioner.id_pertanyaan')
                        ->where('2301020088_pertanyaan.id_prodi', $mahasiswa['id_prodi'])
                        ->where('2301020104_pertanyaan_periode_kuisioner.id_periode_kuisioner', $activePeriode['id_periode'])
                        ->get()->getResultArray();
        
        // Attach Options to Questions
        foreach ($questions as &$q) {
            $q['options'] = $pilihanModel->where('id_pertanyaan', $q['id_pertanyaan'])->findAll();
        }
        
        // Fetch existing answers for this student in this period (for pre-filling)
        $jawabanModel = new JawabanModel();
        $existingAnswers = $jawabanModel->where('nim', $mahasiswa['nim'])
                                        ->where('id_periode', $activePeriode['id_periode'])
                                        ->findAll();
        
        // Create a map: id_pertanyaan => id_pilihan_jawaban_pertanyaan
        $answerMap = [];
        foreach ($existingAnswers as $ans) {
            $answerMap[$ans['id_pertanyaan']] = $ans['id_pilihan_jawaban_pertanyaan'];
        }
        
        // Attach existing answer to each question (if exists)
        foreach ($questions as &$q) {
            if (isset($answerMap[$q['id_pertanyaan']])) {
                $q['existing_answer_option_id'] = $answerMap[$q['id_pertanyaan']];
            }
        }

        $data = [
            'mahasiswa' => $mahasiswa,
            'periode' => $activePeriode,
            'questions' => $questions
        ];

        return view('student/formulir', $data);
    }

    public function submit()
    {
        helper('auth');
        $model = new MahasiswaModel();
        $periodeModel = new PeriodeModel();
        $jawabanModel = new JawabanModel();

        $userId = user_id();
        $mahasiswa = $model->where('id_user', $userId)->first();
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();

        if (!$mahasiswa) {
            return redirect()->to('student')->with('error', 'Data mahasiswa tidak ditemukan!');
        }

        if (!$activePeriode) {
            return redirect()->to('student')->with('error', 'Tidak ada periode kuesioner yang aktif!');
        }

        $answers = $this->request->getPost('answer');
        
        if (!$answers || empty($answers)) {
            return redirect()->back()->with('error', 'Mohon jawab semua pertanyaan!');
        }

        try {
            $dataToSave = [];
            
            // Delete existing answers for this periode
            $jawabanModel->where('nim', $mahasiswa['nim'])
                        ->where('id_periode', $activePeriode['id_periode'])
                        ->delete();
            
            // Prepare batch data
            foreach ($answers as $id_pertanyaan => $id_opsi) {
                $dataToSave[] = [
                    'nim' => $mahasiswa['nim'],
                    'id_pertanyaan' => $id_pertanyaan,
                    'id_pilihan_jawaban_pertanyaan' => $id_opsi,
                    'id_periode' => $activePeriode['id_periode']
                ];
            }

            // Save answers
            if (!empty($dataToSave)) {
                $result = $jawabanModel->insertBatch($dataToSave);
                
                if (!$result) {
                    log_message('error', 'Failed to insert jawaban batch: ' . json_encode($dataToSave));
                    return redirect()->back()->with('error', 'Gagal menyimpan jawaban. Silakan coba lagi.');
                }
                
                log_message('info', "Successfully saved {count($dataToSave)} answers for NIM {$mahasiswa['nim']} periode {$activePeriode['id_periode']}");
            }

            // Clear cache
            cache()->clean();
            
            // Redirect with success
            return redirect()->to('student')->with('success', 'Terima kasih telah mengisi kuesioner!');
            
        } catch (\Exception $e) {
            log_message('error', 'Submit error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function debug()
    {
        helper('auth');
        $mahasiswaModel = new MahasiswaModel();
        $userId = user_id();
        $mahasiswa = $mahasiswaModel->where('id_user', $userId)->first();
        
        echo "<h1>Debug Student</h1>";
        echo "User ID from Session: " . $userId . "<br>";
        echo "Looking for id_user = $userId in table 'mahasiswa'<br>";
        echo "Result:<pre>";
        print_r($mahasiswa);
        echo "</pre>";
        
        // Check DB directly
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM mahasiswa WHERE id_user = ?", [$userId]);
        echo "Raw Query Result:<pre>";
        print_r($query->getRowArray());
        echo "</pre>";

        $periodeModel = new PeriodeModel();
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();
        echo "Active Periode:<pre>";
        print_r($activePeriode);
        echo "</pre>";
    }

    private function validateRequirement($mahasiswa, $activePeriode)
    {
        if (!$mahasiswa) {
            return redirect()->to('student')->with('message', 'Error: Data Mahasiswa tidak ditemukan untuk akun ini.');
        }
        if (!$activePeriode) {
            return redirect()->to('student')->with('message', 'Info: Tidak ada periode kuesioner yang aktif saat ini.');
        }
        return true;
    }
}
