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
        $userModel = new UserModel();
        $prodiModel = new ProdiModel();
        $mhsModel = new MahasiswaModel();

        $data = [
            'count_users' => $userModel->countAll(),
            'count_prodi' => $prodiModel->countAll(),
            'count_mhs'   => $mhsModel->countAllResults() // countAllResults is safer for non-autoinc sometimes, or countAll is fine
        ];

        return view('admin/overview', $data);
    }

    public function users()
    {
        $userModel = new \App\Models\UserModel();
        $db = \Config\Database::connect();
        
        // Manual join because MythAuth model sometimes tricky with relations if not set up
        // Joining users with auth_groups_users and auth_groups to get role names
        $query = $db->table('users')
                    ->select('users.*, auth_groups.name as role_name')
                    ->join('auth_groups_users', 'auth_groups_users.user_id = users.id', 'left')
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
            'username' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
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
    
    public function deleteUser($id)
    {
        $userModel = new \App\Models\UserModel();
        $userModel->delete($id);
        return redirect()->to('admin/users')->with('message', 'User berhasil dihapus');
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
            'username' => "required|alpha_numeric_space|min_length[3]|is_unique[users.username,id,$id]",
            'email'    => "required|valid_email|is_unique[users.email,id,$id]",
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

        $userModel->update($id, $data);

        // Update Role
        $groupId = $this->request->getPost('role');
        $db->table('auth_groups_users')->where('user_id', $id)->delete();
        $db->table('auth_groups_users')->insert([
            'group_id' => $groupId,
            'user_id'  => $id
        ]);

        return redirect()->to('admin/users')->with('message', 'User berhasil diupdate');
    }
}
