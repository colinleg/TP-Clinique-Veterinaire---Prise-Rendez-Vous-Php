<?php

namespace BlogPhp;

use BlogPhp\Engine as E;

// On déclare les constants (root server path + root URL)
define('PROT', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://'); // Si on passe en https
define('ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))) . '/'); // On supprime les backslashes Pour la compatibilité Windows
define('ROOT_PATH', __DIR__ . '/');

try
{
    require ROOT_PATH . 'Engine/Loader.php';
    E\Loader::getInstance()->init(); // Charge les class nécessaires
    // des paramètres qu'on enverra à la fonction run() dans router.php
    $aParams = ['ctrl' => (!empty($_GET['p']) ? $_GET['p'] : 'veto'), 'act' => (!empty($_GET['a']) ? $_GET['a'] : 'accueil')]; // si p est vide : p=blog, si a est vide : a=index
    E\Router::run($aParams); // Le routeur va lancer le Loader qui chargera le controller et l'action nécessaire
}
catch (\Exception $oE)
{
    echo $oE->getMessage();
}
