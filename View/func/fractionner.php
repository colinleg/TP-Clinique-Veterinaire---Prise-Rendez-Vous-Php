<?php

function Fractionner($StartTime, $EndTime, $Duration="60"){
     
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

?>

<html>
<!-- // $out = Fractionner ("2019-06-12 08:00", "2019-06-12 15:45", "120"); ?>


//  print_r ( $out )


// Affiche :

// Array
// (
//     [0] => 8:00
//     [1] => 10:00
//     [2] => 12:00
//     [3] => 14:00
// ) -->
</html>
  
