<?php

namespace Config;

use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function authentication(string $lib = 'local', ?\CodeIgniter\Model $userModel = null, ?\CodeIgniter\Model $loginModel = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('authentication', $lib, $userModel, $loginModel, false);
        }

        $config = config('Auth');
        $config->userModel = 'App\Models\UserModel';

        $class = $config->authenticationLibs[$lib];
        $instance = new $class($config);
        
        // Force set userModel dengan reflection
        $userModelInstance = new \App\Models\UserModel();
        
        $ref = new \ReflectionClass($instance);
        if ($ref->hasProperty('userModel')) {
            $prop = $ref->getProperty('userModel');
            $prop->setAccessible(true);
            $prop->setValue($instance, $userModelInstance);
        }
        
        // Force set loginModel juga
        $loginModelInstance = model('Myth\Auth\Models\LoginModel');
        
        if ($ref->hasProperty('loginModel')) {
            $prop = $ref->getProperty('loginModel');
            $prop->setAccessible(true);
            $prop->setValue($instance, $loginModelInstance);
        }
        
        return $instance;
    }
}
