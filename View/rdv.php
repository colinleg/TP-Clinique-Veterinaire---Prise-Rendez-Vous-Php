<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<main class="h-100 flex flex-col items-center ">


    <div class="container mt-24 flex flex-col justify-center bg-white p-10 rounded-lg">

    <h1 class="text-5xl flex justify-center m-10"> Prendre un rendez-vous </h1>
    
    <h2 class="text-4xl my-4 mb-10">Les horaires</h2>

    <p class="mb-10">La clinique vétérinaire est ouverte de 10h à 17h du lundi au vendredi. <br>
        Les visites sans rendez-vous sont assurées le vendredi matin de 08 à 12h. Cependant,
        nous vous conseillons d'appeler avant pour toute visite. </p>

    <h2 class="text-4xl my-4 mb-10"> Service de garde </h2>

    <p class="mb-10"> Si votre animal est un cas d'urgence, vous pouvez également faire appel à notre service
        de garde vétérinaire disponible 24/24
    </p>

    <h2 class="text-4xl my-4 mb-10">Les prochaines dates disponibles</h2>

    <!-- Il faut connaitre les horaires disponibles, et donc connaîtrer les horaires non dispo -->
        <div id="ctnr_dates" class="w-100 flex justify-around" style="flex-wrap : wrap;">
            <?php

                function dateToFrench($date, $format) {
                $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
                $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
                return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
                }
            ?>

        <?php
        $i=0;
       
        if(isset($_POST['voirPlus'])) {
            $i = $i + 6;
        }
            
        foreach ($this->oCrenos as $creno): ?>

            <div class="h-48 w-64 border border-grey-700 rounded-lg shadow-lg ml-16 hover:bg-blue-100 cursor-pointer my-28 mx-24">

                <!-- affiche la date  -->
                <div class="flex justify-center items-center text-white h-16 bg-blue-500 w-100 p-4 rounded-lg shadow-lg font-bold">
                    <a href="#" class=" cursor-pointer my-8"><?= dateToFrench($creno->jour,'l j F Y') ?> 
                </div>

                <!-- affiche l'heure  -->
                <div class="flex h-1/2 justify-center items-center">
                   <p> de <?= date('H:i',strtotime($creno->heureDebut)) ?> à <?= date('H:i',strtotime($creno->heureFin)) ?></p> <br>
                </div>

                
             
            </div>
        
        <?php if (++$i == 3) break; endforeach ?>

        
        </div>

        <form method="post">
            <input class="cursor-pointer bg-white" type="submit" name="voirPlus" value="voir plus">
        </form>
        
    </div>

</main>
<?php require 'inc/footer.php' ?>