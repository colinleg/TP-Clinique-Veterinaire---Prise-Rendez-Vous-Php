<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>

<main class="h-100 w-full flex flex-col items-center">
    <h1 class="text-4xl mt-16">Bienvenue <?= $_SESSION['is_admin'] ?> dans votre espace administration </h1>

    <h2 class="text-2xl mt-16"> Vos derniers dossiers </h2>

    <h2 class="text-2xl mt-16"> Mes rendez vous </h2>

    <div class="mes_rendezVous">

        <tbody>
            <?php foreach ($this->oRdvs as $oRdv): ?>
                <tr>
                    <th><?= $oRdv->jour ?></th>
                    <th><?= $oRdv->heureDebut ?></th>
                    <th><?= $oRdv->heureFin ?></th>
                </tr>
            <?php endforeach ?>
        </tbody>
    </div>

    <h2 class="text-2xl mt-16"> Mon planning sur 7 jours </h2>

    <div>
        Nombre de vétérinaire dans la clinique : 

        <?php 
            //affiche nombre de vétos dans la clinique
            $int= $this->oNbVeto[0];
            echo htmlspecialchars(strval($int)) ;
            // date sera augmenté pour trouver le 7e jour après
            $dateAuj = $this->oNow;
            $date = $this->oNow;
        ?>

        <tbody>
            <div class=" flex p-8">
                <?php while($date < date('Y-m-d', strtotime("+6 day", strtotime($dateAuj)))): ?>
                    <div class="border border-gray-500 p-12 m-6 bg-blue-200 text-bold rounded-lg shadow-lg">
                        <?php 
                        echo dateToFrench($date,'l j F Y');
                        $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
                        ?>

                        <div class="">
                        Mes rendez vous : <br>
                        </div>
                    </div>
                <?php endwhile ?>
                </div>
        </tbody>
        
        mon session['is_admin'] = <?= $_SESSION['is_admin'] ?>;

        mon idVeterinaire = <?php echo $this->oIdVeto[0]; ?>

        <form action="#" method="post">
            
            <input name="semaine" value="semaine" >
            <button class="border border-gray-500 p-5 m-5 rounded bg-red-300" type="submit" name="declare" value="declare">Déclarer ma semaine</button>
            </div>
            
        </form>

    </div>
</main>


<?php require 'inc/footer.php' ?>