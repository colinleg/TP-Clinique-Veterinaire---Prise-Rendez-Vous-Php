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
    
    
    <h2 class="text-4xl my-4 mb-10"> Les prochaines horaires disponibles</h2>


    <div id="ctnr_dates" class="w-100 flex justify-around " style="flex-wrap : wrap;">
    <?php 
    $i=0;
    $z = 0;
    if(isset($_POST['voirPlus'])) {
        $i = $i + 12;
    }
    
    foreach($this->dateDispos as $dd): 
    ?>
        <form action="#" method="post">
            <div class="h-auto w-96 border border-grey-700 rounded-lg shadow-lg  hover:bg-blue-100 m-6 z-0 relative pt-20">

                <!-- Affichage des dates dispos -->
                <div class="flex justify-center items-center text-white  bg-blue-500 p-4 absolute top-0 right-0  w-full rounded-lg shadow-lg font-bold">
                <?= dateToFrench($dd->jour,'l j F Y') ?>
                </div>

                <!-- Affichage des créneaux dispos -->
                <div class="flex flex-col justify-center items-center font-bold">
               

                <?php 
                for ($d = 0; $d < count($this->crenos[$z]); $d++){
                    echo '<a href="" class="py-2 px-4 hover:bg-blue-300"> de ' . date('H', strtotime($this->crenos[$z][$d]['heureDebut'])) . ' h à ' . date('H', strtotime($this->crenos[$z][$d]['heureFin'])) . ' h' ;
                }
                ?>

                </div>
               
            </div>
        </form>
        
            <?php    
                $z++;
                if (++$i == 6) break;
                endforeach;
            ?>
    </div>

    <form method="post">
            <input class="cursor-pointer bg-white" type="submit" name="voirPlus" value="voir plus">
    </form>
        
</main>
<?php require 'inc/footer.php' ?>