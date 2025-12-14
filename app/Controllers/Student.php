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
        $questions = $db->table('pertanyaan')
                        ->select('pertanyaan.*')
                        ->join('pertanyaan_periode_kuisioner', 'pertanyaan.id_pertanyaan = pertanyaan_periode_kuisioner.id_pertanyaan')
                        ->where('pertanyaan.id_prodi', $mahasiswa['id_prodi'])
                        ->where('pertanyaan_periode_kuisioner.id_periode_kuisioner', $activePeriode['id_periode'])
                        ->get()->getResultArray();
        
        // Attach Options to Questions
        foreach ($questions as &$q) {
            $q['options'] = $pilihanModel->where('id_pertanyaan', $q['id_pertanyaan'])->findAll();
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
        $mahasiswaModel = new MahasiswaModel();
        $periodeModel = new PeriodeModel();
        $jawabanModel = new JawabanModel();

        $userId = user_id();
        $mahasiswa = $mahasiswaModel->where('id_user', $userId)->first();
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();

        $validation = $this->validateRequirement($mahasiswa, $activePeriode);
        if ($validation !== true) {
            return $validation;
        }

        $answers = $this->request->getPost('jawaban'); // Array of [id_pertanyaan => id_opsi]

        if ($answers) {
            foreach ($answers as $id_pertanyaan => $id_opsi) {
                // Remove ID check from delete to allow bulk delete if needed, or delete specifically?
                // Simplest: Delete existing answer for this Q and Period and Student
                $jawabanModel->where('nim', $mahasiswa['nim'])
                             ->where('id_periode', $activePeriode['id_periode'])
                             ->where('id_pertanyaan', $id_pertanyaan)
                             ->delete();

                $jawabanModel->insert([
                    'nim' => $mahasiswa['nim'],
                    'id_pertanyaan' => $id_pertanyaan,
                    'id_pilihan_jawaban_pertanyaan' => $id_opsi,
                    'id_periode' => $activePeriode['id_periode']
                ]);
            }
        }

        return redirect()->to('student')->with('message', 'Terima kasih telah mengisi kuesioner!');
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
