<?php

namespace BlogPhp\Engine;

use BlogPhp\Engine\Pattern\Singleton;

// include des paternes de class nécessaires
require_once __DIR__ . '/Pattern/Base.trait.php';
require_once __DIR__ . '/Pattern/Singleton.trait.php';

class Loader
{
    use Singleton; // Grace au trait, on ne duplique pas le code

    public function init()
    {
        // On enregistre la méthode du loader
        spl_autoload_register(array(__CLASS__, '_loadClasses'));
        // spl_autoload_register() enregistre une fonction dans la pile __autoload() fournie. Si la pile n'est pas encore active, elle est activée.
    }

    private function _loadClasses($sClass)
    {
        // Remplacement du  namespace et du backslash
        $sClass = str_replace(array(__NAMESPACE__, 'BlogPhp', '\\'), '/', $sClass);
        // pourrait être : de BlogPhp\Controller\Veto à //Controller/Veto.php
        // si ... ENGINE/Controller/Veto.php .... est un fichier 
        if (is_file(__DIR__ . '/' . $sClass . '.php'))
            require_once __DIR__ . '/' . $sClass . '.php'; // on l'appelle une fois
        // si ... /srv/Veterinaire//Controller/Veto.php ... est un fichier 
        if (is_file(ROOT_PATH . $sClass . '.php'))
            require_once ROOT_PATH . $sClass . '.php'; // on l'appelle une fois
    }
}
