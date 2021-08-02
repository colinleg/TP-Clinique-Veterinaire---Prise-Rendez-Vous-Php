<?php

namespace BlogPhp\Controller;

//Si aucun parametre a n'est spécifié dans l'url a = accueil
if (empty($_GET['a'])) {
	$_GET['a'] = 'accueil';
}

// private $_iId; 

class Veto{

    // Propriétés 

    protected $oUtil, $oModel;

    // Méthodes 

    public function __construct(){
        if(empty($_SESSION))
            @session_start();

        $this->oUtil = new \BlogPhp\Engine\Util;
        
        $this->oUtil->getModel('Veto');
        $this->oModel = new \BlogPhp\Model\Veto;

        /** Récupère l'identifiant de publication dans le constructeur afin d'éviter la duplication du même code **/
        $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);
    }

    // accueil.php
    public function accueil(){
        $this->oUtil->getView('accueil');
    }

    // rdv.php
    public function rdv(){
        $this->oUtil->getView('rdv');
    }

    // veterinaires.php
    public function veterinaires(){
        $this->oUtil->getView('veterinaires');
    }

    public function login(){
        $this->oUtil->getView('login');
    }

    // notFound.php
    public function notFound(){
        header('HTTP/1.0 404 Not Found');
        $this->oUtil->getView('notFound');
    }

    // error.php
    public function error(){
        $this->oUtil->getView('error');
    }
}

?>