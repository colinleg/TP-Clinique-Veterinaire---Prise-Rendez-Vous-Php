<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>

<main class="h-100 w-full flex flex-col items-center">
    <h1 class="text-4xl mt-16">Bienvenue <?= $_SESSION['is_admin'] ?> dans votre espace administration </h1>

    <h2 class="text-2xl mt-16"> Vos derniers dossiers </h2>

    <h2 class="text-2xl mt-16"> Mes horaires </h2>

    <div class="mes_rendezVous">

        <tbody>
            <?php foreach ($this->oRdvs as $oRdv): ?>
                <tr>
                    <th><?= $oRdv->jour ?></th>
                    <th><?= $oRdv->heureDebut ?></th>
                    <th><?= $oRdv->heureFin ?></th>
                    <br>
                </tr>
            <?php endforeach ?>
        </tbody>
    </div>

    <h2 class="text-2xl mt-16"> Declarer mes  6 prochain jours </h2>

    <div>
        Nombre de vétérinaire dans la clinique : 

        <?php 
            //affiche nombre de vétos dans la clinique
            $int= $this->oNbVeto[0];
            echo htmlspecialchars(strval($int)) ;
            // date sera augmenté pour trouver le 7e jour après
          
        ?>


            
     
        
        mon session['is_admin'] = <?= $_SESSION['is_admin'] ?>;<br>
        mon numero id = <?= $_SESSION['id'][0] ?>

        mon idVeterinaire = <?php echo $this->oIdVeto[0]; ?>

        <!-- Déclare data - Envoi des horaires à la base de donnée -->
        <form action="#" method="post">
            <?php  
                $dateAuj = $this->oNow;
                $date = $this->oNow; 
            ?>


            <div class="flex p-8 justify-center items-center">
                <?php $z = 0; ?>
                <?php while($date < date('Y-m-d', strtotime("+6 day", strtotime($dateAuj)))): ?>

                    
                    <div class="border border-gray-500 p-12 m-6 bg-blue-200 text-bold rounded-lg shadow-lg justify-center items-center">

                        <input name="<?= $date ?>" value="<?= $date ?>" class="hidden">
                        <span><?= dateToFrench($date,'l j F Y') ?></span> <br><br>
                        <?php  
                        $date = date('Y-m-d', strtotime("+1 day", strtotime($date)));
                        $strDeb = (string) $date . '_deb';
                        $strFin = (string) $date . '_fin';
                        
                        ?>

                <label> Heure de début : </label>
                <select name="deb<?=$z?>">

                    <option value="09:00">09:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    
                </select>

                    <br>

                <label"> Heure de fin : </label>
                <select name="fin<?=$z?>">

                    <option value="17:00">17:00</option>
                    <option value="10:00">10:00</option>
                    <option value="11:00">11:00</option>
                    <option value="12:00">12:00</option>
                    <option value="13:00">13:00</option>
                    <option value="14:00">14:00</option>
                    <option value="15:00">15:00</option>
                    <option value="16:00">16:00</option>
                    
                </select>

                    </div>
                    <?php $z++; ?>
                <?php endwhile ?>
            </div>
            
            <button class="border border-gray-500 p-5 m-5 rounded bg-red-300">Déclarer ma semaine</button>
            </div>
            
        </form>

        <?php var_dump($this->selectHoraires)?>
        <br>
        selectionner le premier jour des 6 : 
        <?= $this->selectHoraires[0]['jour'] ?>
        <br>
        selectionner l'heure de debut du 3e jour des 6 : 
        <?= $this->selectHoraires[2]['heureDebut'] ?>

        <br>

        test boucle 
        <br>
<?php
    $datas = $this->selectHoraires;
    
    for($j = 0; $j < count($datas) ; $j++){

        $horaire = array();
        $horaire['jour'] = $datas[$j]['jour'];
        $horaire['idVeterinaire'] = $datas[$j]['idVeterinaire'] ;
        $horaire['Occupe'] = 0;
        $horaire['heureDebut'] = $datas[$j]['heureDebut'];
        $horaire['heureFin'] = $datas[$j]['heureFin'];
        
        $horaire['crenos'][$j] = Fractionner($datas[$j]['heureDebut'],$datas[$j]['heureFin']);
        for($i = 0 ; $i < count($horaire['crenos'][$j]); $i++){
                $deb = $horaire['crenos'][$j][$i];
                $fin = date('H:i', strtotime("+1 hour", strtotime($horaire['crenos'][$j][$i])));

                echo "deb = " . $deb . "<br>";
                echo "fin = " . $fin . "<br>"; 
            }

        echo '<br>';
    }
    
?>

    </div>
</main>


<?php require 'inc/footer.php' ?>