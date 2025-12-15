<?php

namespace App\Controllers;

class DebugStudent extends BaseController
{
    public function checkSubmission()
    {
        helper('auth');
        $mahasiswaModel = new \App\Models\MahasiswaModel();
        $periodeModel = new \App\Models\PeriodeModel();
        $jawabanModel = new \App\Models\JawabanModel();
        
        $userId = user_id();
        $user = user();
        $mahasiswa = $mahasiswaModel->where('id_user', $userId)->first();
        $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();
        
        $output = "<h3>Debug Submission Check</h3>";
        $output .= "<p><strong>Logged in User ID:</strong> {$userId}</p>";
        $output .= "<p><strong>User Object:</strong> " . json_encode($user) . "</p>";
        $output .= "<hr>";
        $output .= "<p><strong>Mahasiswa Found:</strong> " . json_encode($mahasiswa) . "</p>";
        
        // Check all mahasiswa to see if there's a mismatch
        $allMahasiswa = $mahasiswaModel->findAll();
        $output .= "<h4>All Mahasiswa Records (checking id_user):</h4>";
        $output .= "<table border='1' style='border-collapse: collapse;'>";
        $output .= "<tr><th>NIM</th><th>Nama</th><th>id_user</th></tr>";
        foreach ($allMahasiswa as $m) {
            $highlight = ($m['id_user'] == $userId) ? "style='background: yellow;'" : "";
            $output .= "<tr $highlight><td>{$m['nim']}</td><td>{$m['nama_mahasiswa']}</td><td>{$m['id_user']}</td></tr>";
        }
        $output .= "</table>";
        
        $output .= "<hr>";
        $output .= "<p><strong>Active Periode:</strong> " . json_encode($activePeriode) . "</p>";
        
        if ($activePeriode && $mahasiswa) {
            $check = $jawabanModel->where('nim', $mahasiswa['nim'])
                                  ->where('id_periode', $activePeriode['id_periode'])
                                  ->first();
            
            $output .= "<h4>Submission Check Query:</h4>";
            $output .= "<p>WHERE nim = '{$mahasiswa['nim']}' AND id_periode = '{$activePeriode['id_periode']}'</p>";
            $output .= "<p><strong>Result:</strong> " . json_encode($check) . "</p>";
            
            $hasSubmitted = $check ? 'TRUE ✅' : 'FALSE ❌';
            $output .= "<h4>Has Submitted: {$hasSubmitted}</h4>";
        } else {
            $output .= "<h4 style='color: red;'>❌ Cannot check submission - Mahasiswa or Periode is NULL</h4>";
        }
        
        // Get all jawaban
        $allJawaban = $jawabanModel->findAll();
        $output .= "<h4>All Jawaban Records:</h4>";
        $output .= "<pre>" . json_encode($allJawaban, JSON_PRETTY_PRINT) . "</pre>";
        
        return $output;
    }
}
