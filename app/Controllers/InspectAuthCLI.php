<?php
require 'vendor/autoload.php';

try {
    $className = 'Myth\Auth\Authentication\LocalAuthenticator';
    echo "Inspecting $className\n";
    $ref = new ReflectionClass($className);
    $ctor = $ref->getConstructor();
    if ($ctor) {
        foreach ($ctor->getParameters() as $p) {
             $type = $p->getType();
             $typeName = $type ? $type->getName() : 'mixed';
             if ($type && $type->allowsNull()) $typeName = '?'.$typeName;
             
             echo $p->getName() . " : " . $typeName . "\n";
        }
    } else {
        echo "No constructor.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
