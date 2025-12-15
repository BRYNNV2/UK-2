<?php

namespace App\Models;

use Myth\Auth\Models\UserModel as MythModel;

class UserModel extends MythModel
{
    protected $table = '2301020001_user';
    
    public function __construct()
    {
        parent::__construct();
        $this->table = '2301020001_user';
    }
    
    protected $validationRules = [
        'email'         => 'required|valid_email|is_unique[2301020001_user.email,id,{id}]',
        'username'      => 'required|alpha_numeric_space|min_length[3]|is_unique[2301020001_user.username,id,{id}]',
        'password_hash' => 'required',
    ];

    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'nama_user', 'role', // Added these
    ];
}
