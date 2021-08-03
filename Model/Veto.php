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

    public function creneauxDispos(){
        $oStmt = $this->oDb->query("SELECT * FROM creneauxDispos");
        $oStmt->execute();
        return $oStmt->fetchAll(\PDO::FETCH_OBJ);
      }

    /**
     ***** INSERT *****
     */

    /**
     ***** UPDATE *****
     */

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
