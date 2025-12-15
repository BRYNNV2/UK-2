<?php
namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        echo "<h1>Auth Debug</h1>";
        
        // 1. Check Config
        $config = config('Auth');
        echo "Config User Model: " . ($config->userModel ?? 'Not Set (Default)') . "<br>";
        
        // 2. Check Service
        // $auth = service('authentication'); 
        // echo "Auth Class: " . get_class($auth) . "<br>";
        
        // 3. Check Model inside Auth
        // Skipped because we can't instantiate it
        
        /*
        $ref = new \ReflectionClass($auth);
        if ($ref->hasProperty('userModel')) {
            $prop = $ref->getProperty('userModel');
            $prop->setAccessible(true);
            $model = $prop->getValue($auth);
            
            if ($model) {
                echo "Actual Model Class: " . get_class($model) . "<br>";
                
                // 4. Check Table in Model
                $refM = new \ReflectionClass($model);
                if ($refM->hasProperty('table')) {
                    $propT = $refM->getProperty('table');
                    $propT->setAccessible(true);
                    echo "Actual Table Name: " . $propT->getValue($model) . "<br>";
                } else {
                    echo "Model has no 'table' property??<br>";
                }
            } else {
                echo "Auth Service has NO userModel instance.<br>";
            }
        } else {
             echo "Auth Service has no userModel property.<br>";
        }
        */
        
        // 5. Inspect Constructor
        $className = 'Myth\Auth\Authentication\LocalAuthenticator';
        if (class_exists($className)) {
            $refClass = new \ReflectionClass($className);
            $constructor = $refClass->getConstructor();
            echo "<hr>Constructor Params:<br>";
            foreach ($constructor->getParameters() as $param) {
                echo $param->getName() . "<br>";
            }
        } else {
            echo "LocalAuthenticator class not found.<br>";
        }
    }
}
