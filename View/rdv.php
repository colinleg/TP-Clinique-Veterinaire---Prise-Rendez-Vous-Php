<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>

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
        $i=0;
       
        if(isset($_POST['voirPlus'])) {
            $i = $i + 6;
        }
            
        foreach ($this->oCrenos as $creno): ?>
            <form action="#" method="post">

            <!-- On envoie le jour et la date au controlleur, en post -->
            <input class="hidden" name="jour" value="<?= $creno->jour ?>">
            <input class="hidden" name="heureDebut" value="<?= $creno->heureDebut ?>">
            <input class="hidden" name="heureFin" value="<?= $creno->heureFin ?>">

            <button type="submit">
                <div class="h-48 w-64 border border-grey-700 rounded-lg shadow-lg  hover:bg-blue-100 m-6 z-0">
                
                    <!-- affiche la date  -->
                    <div class="flex justify-center items-center text-white h-16 bg-blue-500 w-100 p-4 rounded-lg shadow-lg font-bold">
                        <a href="#" class="my-8"><?= dateToFrench($creno->jour,'l j F Y') ?> 
                    </div>

                    <!-- affiche l'heure  -->
                    <div class="flex h-1/2 justify-center items-center">
                    <p> de <?= date('H:i',strtotime($creno->heureDebut)) ?> à <?= date('H:i',strtotime($creno->heureFin)) ?></p> <br>
                    </div>
                    
                </div>
            </button>  

            </form>
            
        
        <?php if (++$i == 3) break; endforeach ?>

        
        </div>

        <form method="post">
            <input class="cursor-pointer bg-white" type="submit" name="voirPlus" value="voir plus">
        </form>
        
    </div>

</main>
<?php require 'inc/footer.php' ?>