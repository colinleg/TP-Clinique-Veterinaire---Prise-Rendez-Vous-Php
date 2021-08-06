<?php

namespace BlogPhp\Engine;

class Util
{
    public function getView($sViewName)
    {
        $this->_get($sViewName, 'View');
    }

    public function getModel($sModelName)
    {
        $this->_get($sModelName, 'Model');
    }

    /**
     * Cette méthode est utile pour éviter la duplication de code (crée presque la même méthode pour "getView" et "getModel")
     */
    private function _get($sFileName, $sType)
    {
        $sFullPath = ROOT_PATH . $sType . '/' . $sFileName . '.php';
        if (is_file($sFullPath))
            require $sFullPath;
        else
            exit('The "' . $sFullPath . '" file doesn\'t exist');
    }

    /**
     * Défini les variables pour les template views.
     */
    public function __set($sKey, $mVal)
    {
        $this->$sKey = $mVal;
    }

    /**
     ***** Mes fonctions ****
     */

    public function Fractionner($StartTime, $EndTime, $Duration="60"){
       
     
            $ReturnArray = array ();
            $StartTime    = strtotime ($StartTime); // Timestamp
            $EndTime      = strtotime ($EndTime); // Timestamp
         
            $AddMins  = $Duration * 60;
         
            while ($StartTime <= $EndTime)
            {
                $ReturnArray[] = date ("G:i", $StartTime);
                $StartTime += $AddMins;
            }
            return $ReturnArray;
    }
    
}
