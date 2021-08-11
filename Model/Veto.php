<?php 

namespace BlogPhp\Model;

class Veto
{
    #region : Construct
    public function __construct(){

        $this->oDb = new \BlogPhp\Engine\Db;
    }
  
  #endregion
    
    #region : Select
     

    public function getMyHoraires($id){
    
      $oStmt = $this->oDb->prepare('SELECT * FROM Horaire WHERE idVeterinaire = :idVeto');
      $oStmt->bindValue(':idVeto', $id, \PDO::PARAM_INT);
      $oStmt->execute();

      return $oStmt->fetchAll(\PDO::FETCH_OBJ);
  }
  
    public function crenoDispos($jour){
      $oStmt = $this->oDb->prepare("SELECT heureDebut, heureFin  FROM horaireRdv WHERE Occupe = 0 AND jour = :jour");
      $oStmt->bindValue(':jour', $jour, \PDO::PARAM_STR);
      $oStmt->execute();

      return $oStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function creneauxDispos(){
        
      $oStmt = $this->oDb->query("SELECT  FROM horaireRdv WHERE Occupe = 0");
      $oStmt->execute();

      return $oStmt->fetchAll(\PDO::FETCH_ASSOC);

    }

  
    // à vérifier 
    public function getIdPropByData($aData){

      $oStmt = $this->oDb->prepare('SELECT id FROM Proprietaire WHERE nom = :nom AND prenom = :prenom AND email = :email');
      $oStmt->bindValue(':nom', $aData['nom'], \PDO::PARAM_STR);
      $oStmt->bindValue(':prenom', $aData['prenom'], \PDO::PARAM_STR);
      $oStmt->bindValue(':email', $aData['email'], \PDO::PARAM_STR);
      $oStmt->execute();
      
      return $oStmt->fetch(\PDO::FETCH_BOTH);

    }


    public function getDateDispos(){
      $date = date('Y:m:d');
      // DISTINCT évite les doublons
      $oStmt = $this->oDb->prepare("SELECT DISTINCT jour FROM horaireRdv WHERE Occupe = 0 AND jour >= :date ");
      $oStmt->bindValue(":date", $date, \PDO::PARAM_STR);
      $oStmt->execute();

      return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }



    public function getIdUser($pseudo){
      $oStmt = $this->oDb->prepare('SELECT id FROM Users WHERE pseudo = :pseudo LIMIT 1');
      $oStmt->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
      $oStmt->execute();
      return $oStmt->fetch(\PDO::FETCH_NUM);
    }

    public function getIdAnimal($data){
      $oStmt = $this->oDb->prepare('SELECT id FROM Animal WHERE Nom = :nom AND idProprietaire = :idProp LIMIT 1');
      $oStmt->bindValue(':nom', $data['nomAnimal'], \PDO::PARAM_STR);
      $oStmt->bindValue(':idProp', $data['idProp'][0], \PDO::PARAM_STR);
      $oStmt->execute();
      return $oStmt->fetch(\PDO::FETCH_NUM);
    }
    
    public function getIdRaceChat($nomRace){
      $oStmt = $this->oDb->prepare('SELECT id FROM Race_chat WHERE nom = :nom LIMIT 1');
      $oStmt->bindValue(':nom', $nomRace, \PDO::PARAM_STR);
      $oStmt->execute();

      return $oStmt->fetch(\PDO::FETCH_NUM);
    }

    public function getIdRaceChien($nomRace){
      $oStmt = $this->oDb->prepare('SELECT id FROM Race_chien WHERE nom = :nom LIMIT 1');
      $oStmt->bindValue(':nom', $nomRace, \PDO::PARAM_STR);
      $oStmt->execute();
      
      return $oStmt->fetch(\PDO::FETCH_NUM);
    }

 
    #endregion

    #region : Insert 
    
     public function addProprietaire($aData){
      $sql = 'INSERT INTO Proprietaire(nom, prenom, telephone, email) VALUES (:nom, :prenom, :telephone, :email)';
        $oStmt = $this->oDb->prepare($sql);
        $oStmt->bindValue(':nom', $aData['nom'], \PDO::PARAM_STR);
        $oStmt->bindValue(':prenom', $aData['prenom'], \PDO::PARAM_STR);
        $oStmt->bindValue(':telephone', $aData['telephone'], \PDO::PARAM_STR);
        $oStmt->bindValue(':email', $aData['email'], \PDO::PARAM_STR);

        $res = $oStmt->execute();
        return $res;
     }

     public function addAnimal($aData){
      $sql = 'INSERT INTO Animal(Nom,idProprietaire) VALUES (:nomAnimal, :idProprietaire)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':nomAnimal', $aData['nomAnimal']);
      $oStmt->bindValue(':idProprietaire', $aData['idProp'][0]);
      
      $res = $oStmt->execute();
      return $res;
     }

     public function addChat($aData){
      $sql = 'INSERT INTO Chat(idAnimal, idRace) VALUES (:idAnimal, :idRace)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':idAnimal', $aData['idAnimal'][0], \PDO::PARAM_INT);
      $oStmt->bindValue(':idRace', $aData['idRaceAnimal'][0], \PDO::PARAM_INT);
      
      $oStmt->execute();
     }

     public function addChien($aData){
      $sql = 'INSERT INTO Chien(idAnimal, idRace) VALUES (:idAnimal, :idRace)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':idAnimal', $aData['idAnimal'][0], \PDO::PARAM_INT);
      $oStmt->bindValue(':idRace', $aData['idRaceAnimal'][0], \PDO::PARAM_INT);
      
      $oStmt->execute();
     }

     public function addRaceChien($raceAnimal){
      $sql = 'INSERT INTO Race_chien(nom) VALUES (:nom)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':nom', $raceAnimal, \PDO::PARAM_STR);
      
      return $oStmt->execute();
     }

     public function addRaceChat($raceAnimal){
      $sql = 'INSERT INTO Race_chat(nom) VALUES (:nom)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':nom', $raceAnimal, \PDO::PARAM_STR);
      
      return $oStmt->execute();
     }

     #endregion

    #region : Update 

     public function addRdv($data){
      
      
        $sql = 'UPDATE horaireRdv SET Occupe = 1, idProprietaire = :idProprietaire WHERE jour = :date AND heureDebut = :heureDebut';
        $oStmt = $this->oDb->prepare($sql);
        $oStmt->bindValue(':date', $data['date'], \PDO::PARAM_STR);
        $oStmt->bindValue(':heureDebut', $data['heureDebut'], \PDO::PARAM_STR);
        $oStmt->bindValue(':idProprietaire', $data['idProp'][0], \PDO::PARAM_INT);
        return $oStmt->execute();
      
     }
    
    #endregion

    #region : Inscription et Connexion
     
      #region : Connexion
    public function isAdmin($sEmail)
    {
      $oStmt = $this->oDb->prepare('SELECT * FROM Users WHERE email = :email LIMIT 1');
      $oStmt->bindValue(':email', $sEmail, \PDO::PARAM_STR);
      $oStmt->execute();
      return $oStmt->fetch(\PDO::FETCH_OBJ);
    }
  
  
    public function login($sEmail, $sPassword)
    {
      $a = [
        'email' 	  => $sEmail,
        'password' 	=> sha1($sPassword)
      ];

      $sSql = "SELECT * FROM Users WHERE email = :email AND password = :password";
      $oStmt = $this->oDb->prepare($sSql);
      $oStmt->execute($a);
      $exist = $oStmt->rowCount($sSql);
  
      return $exist;
    }
      #endregion
    
      #region : Inscription
    
    public function pseudoTaken($pseudo)
    {
      $oStmt = $this->oDb->prepare('SELECT * FROM Users WHERE pseudo = :pseudo');
      $oStmt->bindParam(':pseudo', $pseudo, \PDO::PARAM_STR);
      $oStmt->execute();
      return $oStmt->rowCount();
    }
  
  
    public function emailTaken($sEmail)
    {
      $oStmt = $this->oDb->prepare('SELECT * FROM Users WHERE email = :email');
      $oStmt->bindParam(':email', $sEmail, \PDO::PARAM_STR);
      $oStmt->execute();
      return $oStmt->rowCount();
    }
  
  
    public function addUser($aData)
    {
      $oStmt = $this->oDb->prepare('INSERT INTO Users (email, pseudo, password) VALUES(:email, :pseudo, :password)');
      return $oStmt->execute($aData);
    }

      #endregion
    
    #endregion
}
