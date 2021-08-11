<?php

namespace BlogPhp\Model;

use PDO;

class Admin extends Veto
{
    /**
     ***** SELECT *****
     */
    public function getMyRdvs(){
        
        $oStmt = $this->oDb->query('SELECT * FROM Horaire');
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    
    public function getNbVeto(){

        $oStmt = $this->oDb->query('SELECT COUNT(id) FROM Veterinaire');
        return $oStmt->fetch(\PDO::FETCH_BOTH);
    }

    public function getIdVeto($pseudo){
        $oStmt = $this->oDb->prepare('SELECT idVeterinaire FROM Users WHERE pseudo = :pseudo LIMIT 1');
        $oStmt->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $oStmt->execute();
        return $oStmt->fetch(\PDO::FETCH_BOTH);
      }

    

    public function getLastAddedHoraires(){
        $oStmt = $this->oDb->query('SELECT jour, heureDebut, heureFin, idVeterinaire FROM Horaire ORDER BY createdAt DESC LIMIT 6');
        return $oStmt->fetchAll(\PDO::FETCH_ASSOC);
    }

  


    /**
     * INSERT INTO
     */

    public function addSemaineLibre($data){
        
        // $date = $aData['date'];
        $oStmt = $this->oDb->prepare('INSERT INTO Horaire(jour, heureDebut, heureFin, idVeterinaire, createdAt) VALUES (:jour, :heureDebut, :heureFin, :idVeterinaire, :createdAt)');
        $oStmt->bindValue(':jour', $data['date'], \PDO::PARAM_STR);
        $oStmt->bindValue(':heureDebut', $data['heureDebut'],\PDO::PARAM_STR);
        $oStmt->bindValue(':heureFin', $data['heureFin'], \PDO::PARAM_STR);
        $oStmt->bindValue(':idVeterinaire', $data['idVeterinaire'], \PDO::PARAM_INT);
        $oStmt->bindValue(':createdAt', $data['createdAt'], \PDO::PARAM_STR);
        $res = $oStmt->execute();
        return $res;
    }

    public function addCrenos($data){

        $oStmt = $this->oDb->prepare('INSERT INTO horaireRdv(jour, heureDebut, heureFin, idVeterinaire, Occupe) VALUES (:jour, :heureDebut, :heureFin, :idVeterinaire, :Occupe)');
        $oStmt->bindValue(':jour', $data['jour'], \PDO::PARAM_STR);
        $oStmt->bindValue(':heureDebut', $data['crenoDebut'], \PDO::PARAM_STR);
        $oStmt->bindValue(':heureFin', $data['crenoFin'], \PDO::PARAM_STR);
        $oStmt->bindValue(':idVeterinaire', $data['idVeterinaire'], \PDO::PARAM_INT);
        $oStmt->bindValue(':Occupe', $data['Occupe'], \PDO::PARAM_BOOL);
        $oStmt->execute();
    }
}