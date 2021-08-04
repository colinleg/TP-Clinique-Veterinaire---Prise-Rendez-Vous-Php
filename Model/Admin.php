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

    /**
     * INSERT INTO
     */
    public function addSemaineLibre(array $aData){
        $date = $aData['date'];
        $jour7 = date('Y-m-d', strtotime("+7 day", strtotime($aData['date'])));

        while($date < $jour7){

            $sql = 'INSERT IGNORE INTO horaireLibre(jour, heureDebut, heureFin, idVeterinaire) VALUES(:jour, :heureDebut, :heureFin, :id)';
            $oStmt = $this->oDb->prepare($sql);
            $oStmt->bindValue(':jour', $date,\PDO::PARAM_STR);
            $oStmt->bindValue(':heureDebut', $aData['heureDebut'],\PDO::PARAM_STR);
            $oStmt->bindValue(':heureFin', $aData['heureFin'],\PDO::PARAM_STR);
            $oStmt->bindValue(':id', $aData['id'],\PDO::PARAM_INT);
            $oStmt->execute();

            $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
        }
    }
}