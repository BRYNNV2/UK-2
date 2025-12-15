<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\UserModel;
use App\Models\ProdiModel;
use App\Models\MahasiswaModel;

class Admin extends BaseController
{
    public function index()
    {
        helper('auth');
        $userModel = new UserModel();
        $prodiModel = new ProdiModel();
        $mhsModel = new MahasiswaModel();
        
        $fakultasModel = new \App\Models\FakultasModel();
        $jurusanModel = new \App\Models\JurusanModel();
        
        // Check if user is kaprodi
        $userId = user_id();
        $isKaprodi = in_groups('kaprodi');
        
        $data = [
            'count_users' => $userModel->countAll(),
            'count_prodi' => $prodiModel->countAll(),
            'count_mhs'   => $mhsModel->countAllResults(),
            'count_fakultas' => $fakultasModel->countAll(),
            'count_jurusan' => $jurusanModel->countAll(),
            'is_kaprodi' => $isKaprodi
        ];
        
        // Add kaprodi-specific data
        if ($isKaprodi) {
            // Get kaprodi's prodi
            $assignedProdi = $prodiModel->where('id_kaprodi', $userId)->first();
            
            if ($assignedProdi) {
                // Count mahasiswa in this prodi
                $data['kaprodi_prodi'] = $assignedProdi;
                $data['kaprodi_mhs_count'] = $mhsModel->where('id_prodi', $assignedProdi['id_prodi'])->countAllResults();
                
                // Get active periode
                $periodeModel = new \App\Models\PeriodeModel();
                $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();
                $data['active_periode'] = $activePeriode;
                
                if ($activePeriode) {
                    // Count respondents for this periode and prodi
                    $jawabanModel = new \App\Models\JawabanModel();
                    $db = \Config\Database::connect();
                    
                    // Get distinct mahasiswa who submitted
                    $respondents = $db->table($jawabanModel->table)
                        ->distinct()
                        ->select($jawabanModel->table . '.nim')
                        ->join('2301020111_mahasiswa', '2301020111_mahasiswa.nim = ' . $jawabanModel->table . '.nim')
                        ->where($jawabanModel->table . '.id_periode', $activePeriode['id_periode'])
                        ->where('2301020111_mahasiswa.id_prodi', $assignedProdi['id_prodi'])
                        ->countAllResults();
                    
                    $data['kaprodi_respondents'] = $respondents;
                }
            }
        }
        
        // Add analytics data for admin
        if (!$isKaprodi) {
            $db = \Config\Database::connect();
            $periodeModel = new \App\Models\PeriodeModel();
            $jawabanModel = new \App\Models\JawabanModel();
            
            // Get active periode
            $activePeriode = $periodeModel->where('status_periode', 'Aktif')->first();
            
            if ($activePeriode) {
                // Response rate per prodi
                $prodiStats = $db->query("
                    SELECT 
                        p.nama_prodi,
                        COUNT(DISTINCT m.nim) as total_mhs,
                        COUNT(DISTINCT j.nim) as responded,
                        ROUND((COUNT(DISTINCT j.nim) / NULLIF(COUNT(DISTINCT m.nim), 0)) * 100, 1) as response_rate
                    FROM {$prodiModel->table} p
                    LEFT JOIN {$mhsModel->table} m ON p.id_prodi = m.id_prodi
                    LEFT JOIN {$jawabanModel->table} j ON m.nim = j.nim AND j.id_periode = ?
                    WHERE p.id_prodi IS NOT NULL
                    GROUP BY p.id_prodi, p.nama_prodi
                    ORDER BY response_rate DESC
                    LIMIT 5
                ", [$activePeriode['id_periode']])->getResultArray();
                
                $data['prodi_stats'] = $prodiStats;
                $data['active_periode'] = $activePeriode;
            }
        }

        return view('admin/overview', $data);
    }

    public function users()
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();
        
        // Manual join because MythAuth model sometimes tricky with relations if not set up
        // Joining users with auth_groups_users and auth_groups to get role names
        $query = $db->table('2301020001_user')
                    ->select('2301020001_user.*, auth_groups.name as role_name')
                    ->join('auth_groups_users', 'auth_groups_users.user_id = 2301020001_user.id', 'left')
                    ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left')
                    ->get();
        
        $data['users'] = $query->getResultArray();

        return view('admin/users/index', $data);
    }

    public function createUser()
    {
        // Get all groups for the dropdown
        $db = \Config\Database::connect();
        $data['groups'] = $db->table('auth_groups')->get()->getResultArray();
        
        return view('admin/users/create', $data);
    }
    
    public function storeUser()
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();
        
        // Validation rules
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[2301020001_user.username]',
            'email'    => 'required|valid_email|is_unique[2301020001_user.email]',
            'password' => 'required|min_length[8]',
            'role'     => 'required',
            'nama_user'=> 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 1. Save User
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Entity will hash this? No, using Model directly might not if allowedFields used raw.
                                                               // Myth:Auth UserModel uses PasswordHash entity, let's verify.
                                                               // The safest way with the library is to use the entity or manually hash.
                                                               // Since we extended the model, let's check. 
                                                               // Actually, simpler to use the Auth Library's user creation flow?
                                                               // But here we want custom fields too.
            'nama_user'=> $this->request->getPost('nama_user'),
            'role'     => $this->request->getPost('role'), // Redundant column
            'active'   => 1,
        ];
        
        // Manual Hashing to be safe given our previous issues
        $data['password_hash'] = \Myth\Auth\Password::hash($data['password']);
        unset($data['password']);

        $userModel->insert($data);
        $userId = $userModel->getInsertID();

        // 2. Assign Role (Auth Group)
        $groupId  = $this->request->getPost('role'); // Assuming value passed is group ID
        // Wait, did we pass ID or Name? Let's assume ID for robustness.
        
        $db->table('auth_groups_users')->insert([
            'group_id' => $groupId,
            'user_id'  => $userId
        ]);

        return redirect()->to('admin/users')->with('message', 'User berhasil ditambahkan');
    }
    
    
    public function editUser($id)
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();
        
        $data['user'] = $userModel->find($id);
        $data['groups'] = $db->table('auth_groups')->get()->getResultArray();
        
        // Get current group
        $currentGroup = $db->table('auth_groups_users')->where('user_id', $id)->get()->getRowArray();
        $data['current_group_id'] = $currentGroup ? $currentGroup['group_id'] : null;

        return view('admin/users/edit', $data);
    }

    public function updateUser($id)
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();

        $rules = [
            'username' => "required|alpha_numeric_space|min_length[3]|is_unique[2301020001_user.username,id,$id]",
            'email'    => "required|valid_email|is_unique[2301020001_user.email,id,$id]",
            'nama_user'=> 'required',
            'role'     => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'nama_user'=> $this->request->getPost('nama_user'),
            'role'     => $this->request->getPost('role'),
        ];

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password_hash'] = \Myth\Auth\Password::hash($password);
        }

        // Use DB builder instead of model to bypass potential issues
        $db->table('2301020001_user')->where('id', $id)->update($data);

        // Update Role
        $groupId = $this->request->getPost('role');
        $db->table('auth_groups_users')->where('user_id', $id)->delete();
        $db->table('auth_groups_users')->insert([
            'group_id' => $groupId,
            'user_id'  => $id
        ]);

        return redirect()->to('admin/users')->with('message', 'User berhasil diupdate');
    }

    public function deleteUser($id)
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();
        
        // Check if request is AJAX
        if ($this->request->isAJAX()) {
            try {
                // Delete from auth_groups_users first (foreign key)
                $db->table('auth_groups_users')->where('user_id', $id)->delete();
                
                // Hard delete user (purge permanently)
                // Use delete with second parameter true to force hard delete
                $userModel->delete($id, true);
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'User berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Gagal menghapus user: ' . $e->getMessage()
                ]);
            }
        }
        
        // Fallback for non-AJAX request
        $db->table('auth_groups_users')->where('user_id', $id)->delete();
        $userModel->delete($id, true); // Hard delete
        return redirect()->to('admin/users')->with('message', 'User berhasil dihapus');
    }
}
