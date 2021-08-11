<?php

namespace BlogPhp\Controller;

class Admin extends Veto
{
    #region : Construct

    public function __construct(){
      parent::__construct();
      $this->oUtil->getModel('Admin');
      $this->oModel = new \BlogPhp\Model\Admin;
    }

    #endregion

    #region : Méthodes par vues

    public function adminBoard(){

      // si je ne suis pas connecté
      if (!$this->isLogged()){
      header('Location: veto_accueil.html');
      }
      else{
        
        $idVeto = $_SESSION['id'][0];
        $this->horaires($idVeto);
        $this->rdvs($idVeto);
        $this->nbVeto();
        $this->nowDate();
       
        $this->declare($idVeto);
       
        $this->oUtil->getView('adminBoard');
      }
    
      
    }
      #endregion
    
    #region : Méthodes Aux
    public function rdvs($idVeto){
      $this->oUtil->oRdvs = $this->oModel->getVetosRdvs($idVeto);
    }

    public function horaires($idVeto){
        $this->oUtil->oHoraires = $this->oModel->getMyHoraires($idVeto);
    }
 
    public function nbVeto(){
        $this->oUtil->oNbVeto = $this->oModel->getNbVeto();
    }

    public function nowDate(){
      $this->oUtil->oNow = date('Y-m-d');
      $date = $this->oUtil->oNow;
      return $date;
    }

    public function myIdVeto($pseudo){
      $this->oUtil->oIdVeto = $this->oModel->getIdVeto($pseudo);
    }
    #endregion
   
    #region : Gestion des horaires 

    public function declare($idVeto){

      if(!empty($_POST)){
        
        $date = $this->nowDate();

        if(isset($_POST[$date])){

          // Vu qu'il y a 3 data posts par date ( date, heuredebut, heurefin ) : 
          $post_length = count($_POST) / 3 ;

          for($i = 0; $i < $post_length; $i++){

            $strDeb = 'deb' . $i;
            $strFin = 'fin' . $i;

            $data = [];
            $data['date'] = $_POST[$date];
            $data['heureDebut'] = $_POST[$strDeb];
            $data['heureFin'] = $_POST[$strFin];
            $data['idVeterinaire'] = $idVeto;
            $data['createdAt'] = date('Y-m-d H:i:s');
            $this->oModel->addSemaineLibre($data);
            $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));

          } // fin boucle for 

          $this->convertHorToCreno();    
        }  
      }
    }


    /* appelée depuis la fonction declare */
    public function convertHorToCreno(){
      $datas = $this->oModel->getLastAddedHoraires();
      $this->oUtil->selectHoraires = $datas;
    
      for($i = 0; $i < count($datas) ; $i++){
  
        $horaire = array();
        $horaire['jour'] = $datas[$i]['jour'];
        $horaire['idVeterinaire'] = $datas[$i]['idVeterinaire'] ;
        $horaire['Occupe'] = 0;
        $horaire['heureDebut'] = $datas[$i]['heureDebut'];
        $horaire['heureFin'] = $datas[$i]['heureFin'];
        
        $horaire['crenos'][$i] = $this->oUtil->Fractionner($datas[$i]['heureDebut'],$datas[$i]['heureFin']);

        
        for($j = 0 ; $j < count($horaire['crenos'][$i]); $j++){

          $deb = $horaire['crenos'][$i][$j];
          
          if( $deb !== $horaire['heureFin']){

            $fin = date('H:i', strtotime("+1 hour", strtotime($horaire['crenos'][$i][$j])));
            $horaire['crenoDebut'] = $deb;
            $horaire['crenoFin'] = $fin;

            $this->oModel->addCrenos($horaire);
          }
        }
      }
    }
    #endregion
}

?>    
