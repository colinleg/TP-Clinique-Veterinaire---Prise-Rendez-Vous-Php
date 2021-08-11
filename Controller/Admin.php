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
        $this->oUtil->isTodaySet = $isTodaySet = $this->isTodaySet($idVeto);
        if ($isTodaySet == false){
          $this->declare($idVeto);
        } else {
          $this->updateHoraires($idVeto);
        }
        
        
       
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

    public function updateHoraires($idVeto){

      if(!empty($_POST)){
        
        $date = $this->nowDate();

        if(isset($_POST[$date])){

           // Si on est lundi ...
           if($this->isMonday($date) == true ){
            $post_length = count($_POST) / 3 + 1 ;
          }else{
            // Vu qu'il y a 3 data posts par date ( date, heuredebut, heurefin ) : 
          $post_length = count($_POST) / 3 + 2 ;
          }

          for($i = 0; $i < $post_length; $i++){

            if($this->isWeekend($date) == false){

              $strDeb = 'deb' . $i;
              $strFin = 'fin' . $i;

              $data = [];
              $data['jour'] = $_POST[$date];
              $data['heureDebut'] = $_POST[$strDeb];
              $data['heureFin'] = $_POST[$strFin];
              $data['idVeto'] = $idVeto;
              $data['createdAt'] = date('Y-m-d H:i:s');
              
              // Si il y a deja dans la table horaire, une horaire à cette date ..
              $isAlready = $this->oModel->checkDaySet($data);
              if ($isAlready == true){
                $this->oModel->updateJour($data);
              } else if ($isAlready == false){
                $this->oModel->addSemaineLibre($data);
              }

              $this->oModel->deleteHorairesByDate($data);
              $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            
            } //fin if weekend
            else if ($this->isWeekend($date) == true){
              $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }
          } // fin boucle for 

          $this->convertHorToCreno();    
        }  
      }
    }

    public function isTodaySet($idVeto){
      $date = $this->nowDate();

        $data = [
          'jour' => $date,
          'idVeto' => $idVeto
        ];
        
        $obj = $this->oModel->checkDaySet($data);

        if($obj == false){
          return false ;
        } else {
          return true;
        }

    }

    public function declare($idVeto){

      if(!empty($_POST)){
        
        $date = $this->nowDate();

        if(isset($_POST[$date])){

          // Si on est lundi ...
          if($this->isMonday($date) == true ){
            $post_length = count($_POST) / 3 + 1 ;
          }else{
            // Vu qu'il y a 3 data posts par date ( date, heuredebut, heurefin ) : 
          $post_length = count($_POST) / 3 + 2 ;
          }
           

          for($i = 0; $i < $post_length; $i++){

            if($this->isWeekend($date) == false){

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
            
            } else if ($this->isWeekend($date) == true){
              $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
            }
          } // fin boucle for 

          $this->convertHorToCreno();    
        }  
      }
    }

      /**
     * Date : la date a vérifier 
     * Vérifie si la date fait partie du weekend : renvoie true si c'est le we, sinon false 
     */
    public function isWeekend($date) {
      return (date('N', strtotime($date)) >= 6);
    }

    public function isMonday($date) {
      return (date('N', strtotime($date)) == 1);
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
        
        if($datas[$i]['heureDebut'] != '0'){

        
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
        } // end if heuredebut = 0
      }
    } // fin function
    
    #endregion
}
  
?>    
