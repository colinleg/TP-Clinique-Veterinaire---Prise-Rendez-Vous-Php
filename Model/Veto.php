<?php 

namespace BlogPhp\Model;

class Veto
{

    // protected $oDb;

    public function __construct(){

        $this->oDb = new \BlogPhp\Engine\Db;
    }

    /**
     ***** SELECT *****
     */

    public function getMyRdvs(){
      $id=1;
      $oStmt = $this->oDb->query('SELECT * FROM Horaire');
      $oStmt->bindValue(':id', $id, \PDO::PARAM_INT);
      return $oStmt->execute();
  }
  
    public function creneauxDispos(){

        $oStmt = $this->oDb->query("SELECT * FROM horaireRdv WHERE Occupe = 0");
        $oStmt->execute();

        return $oStmt->fetchAll(\PDO::FETCH_OBJ);

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

    /**
     ***** INSERT *****
     */
    //vérifiée
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

    //vérifiée
     public function addAnimal($aData){
      $sql = 'INSERT INTO Animal(Nom,idProprietaire) VALUES (:nomAnimal, :idProprietaire)';
      $oStmt = $this->oDb->prepare($sql);
      $oStmt->bindValue(':nomAnimal', $aData['nomAnimal']);
      $oStmt->bindValue(':idProprietaire', $aData['idProp'][0]);
      
      $res = $oStmt->execute();
      return $res;
     }

    /**
     ***** UPDATE *****
     */

     public function addRdv($aData){
      
      
        $sql = 'UPDATE Occupe FROM horaireRdv WHERE date = :date AND heureDebut = :heureDebut';
        $oStmt = $this->oDb->prepare($sql);
        $oStmt->bindValue(':date', $aData['date'], ':heureDebut', $aData['creno']);
        $isOk = $oStmt->execute();
      
        return $isOk; 

     }
     

    /**
     ***** DELETE *****
     */

    
    /**
     ***** LOGIN *****
     */
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


}
