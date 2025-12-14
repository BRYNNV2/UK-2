<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;

class Auth extends \Myth\Auth\Controllers\AuthController
{
    /**
     * Attempt to log the user in.
     */
    public function loginAction()
    {
        // Validate
        $rules = [
            'login'    => 'required',
            'password' => 'required',
        ];

        if ($this->config->validFields === ['email']) {
            $rules['login'] .= '|valid_email';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool)$this->request->getPost('remember');

        // Determine credential type
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Try to log them in...
        if (! $this->auth->attempt([$type => $login, 'password' => $password], $remember)) {
            return redirect()->back()->withInput()->with('error', $this->auth->error() ?? lang('Auth.badAttempt'));
        }

        // --- CUSTOM REDIRECT LOGIC ---
        // Ignore session('redirect_url') to prevent permission errors
        // Force redirect based on Role
        
        $redirectURL = '/'; // Fallback
        
        $authorize = service('authorization');
        $userId = $this->auth->id();

        if ($authorize->inGroup('admin', $userId) || $authorize->inGroup('pimpinan', $userId) || $authorize->inGroup('kaprodi', $userId)) {
            $redirectURL = 'admin';
        } elseif ($authorize->inGroup('mahasiswa', $userId)) {
            $redirectURL = 'student';
        }

        return redirect()->to($redirectURL)->withCookies();
    }
}
