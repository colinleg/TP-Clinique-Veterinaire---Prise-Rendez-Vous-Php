<?php

namespace BlogPhp\Model;

class Admin extends Veto
{
    /**
     ***** SELECT *****
     */
    public function getMyRdvs(){
        $id=1;
        $oStmt = $this->oDb->query('SELECT * FROM horaire WHERE idVeterinaire = :id');
        $oStmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $oStmt->execute();
    }
}