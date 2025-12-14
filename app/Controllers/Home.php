<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        helper('auth');
        if (logged_in()) {
            if (in_groups(['admin', 'pimpinan', 'kaprodi'])) {
                return redirect()->to('/admin');
            } elseif (in_groups('mahasiswa')) {
                return redirect()->to('/student');
            } else {
                // Default fallback if role unknown
                return redirect()->to('/login'); 
            }
        }
        return redirect()->to('login');
    }

    public function logout()
    {
        helper('auth');
        service('authentication')->logout();
        session()->destroy();
        return redirect()->to('login');
    }
}
