<?php

namespace BlogPhp\Controller;

class Admin extends Veto
{
    

    public function __construct(){
      parent::__construct();
      $this->oUtil->getModel('Admin');
      $this->oModel = new \BlogPhp\Model\Admin;
    }


    public function adminBoard(){

      // si je ne suis pas connecté
      if (!$this->isLogged()){
      header('Location: veto_accueil.html');
      }
      else{
        $this->rdvs();
        $this->nbVeto();
        $this->nowDate();
        //oSession est défini dans la classe Veto
        $this->declare();
        $this->oSession = $_SESSION['is_admin'];
        $this->myIdVeto($this->oSession);
        $this->oUtil->getView('adminBoard');
      }
        
      
    }
    // select * from Horaire
    public function rdvs(){
        $this->oUtil->oRdvs = $this->oModel->getMyRdvs();
    }

    // select count(id) from Veterinaire
    public function nbVeto(){
        $this->oUtil->oNbVeto = $this->oModel->getNbVeto();
    }

    public function nowDate(){
      $this->oUtil->oNow = date('Y-m-d');
    }

    public function myIdVeto($pseudo){
      $this->oUtil->oIdVeto = $this->oModel->getIdVeto($pseudo);
    }

    public function declare(){
      if(!empty($_POST)){
        if($_POST['semaine']=='semaine'){
          $aData = array(
            'date' => date('Y-m-d'),
            'id' => 1,
            'heureDebut' => '10:00',
            'heureFin' => '17:00'
          );
          
          $this->oModel->addSemaineLibre($aData);
        }
      }
    }

}

?>    
