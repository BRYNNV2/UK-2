<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthDebug extends BaseController
{
    public function index()
    {
        $auth = service('authentication');

        echo "<h1>Auth Debug</h1>";

        // Test 1: Check User Existence
        $userModel = model('App\Models\UserModel');
        $user = $userModel->where('username', 'admin')->first();
        
        echo "<h3>User Check</h3>";
        if ($user) {
            echo "User found: " . $user->username . " (ID: " . $user->id . ")<br>";
            echo "Hash: " . $user->password_hash . "<br>";
            echo "Active: " . $user->active . "<br>";
        } else {
            echo "User 'admin' NOT found via Model!<br>";
        }

        // Test 2: Attempt Login via Service (Username)
        echo "<h3>Attempt Login (Username: admin)</h3>";
        $creds = ['username' => 'admin', 'password' => 'admin123'];
        
        if ($auth->attempt($creds, false)) {
            echo "Login SUCCESS!<br>";
        } else {
            echo "Login FAILED!<br>";
            echo "Error: " . $auth->error() . "<br>";
        }
        
        // Test 3: Attempt Login via Service (Email)
        echo "<h3>Attempt Login (Email: admin@uk2.com)</h3>";
        $creds2 = ['email' => 'admin@uk2.com', 'password' => 'admin123'];
        
        if ($auth->attempt($creds2, false)) {
            echo "Login (Email) SUCCESS!<br>";
        } else {
            echo "Login (Email) FAILED!<br>";
            echo "Error: " . $auth->error() . "<br>";
        }

        // Native Password Check
        if (password_verify('admin123', $user->password_hash)) {
             echo "<h3>Native Password Verification: SUCCESS</h3>";
        } else {
             echo "<h3>Native Password Verification: FAILED</h3>";
        }

    }
}
