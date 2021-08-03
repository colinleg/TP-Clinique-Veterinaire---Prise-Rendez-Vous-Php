<?php

namespace BlogPhp\Controller;

class Admin extends Veto
{

//    public function __construct(){

//         // Active la session
//         if (empty($_SESSION))
//         @session_start();

//         $this->oUtil = new \BlogPhp\Engine\Util;

//         $this->oUtil->getModel('Admin');
//         $this->oModel = new \BlogPhp\Model\Admin;
//         $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);

//    }

    public function adminBoard(){

        // $this->oUtil->getModel('Admin');
        // $this->oModel = new \BlogPhp\Model\Admin;
      if (!$this->isLogged()){
      header('Location: veto_accueil.html');
      $this->oUtil->getView('adminBoard');
      }
    }

    public function rdvs(){

        // $this->oUtil->getModel('Admin');
        // $this->oModel = new \BlogPhp\Model\Admin;

        // $this->oUtil->oRdvs = $this->oModel->getMyRdvs();
    
    }
}