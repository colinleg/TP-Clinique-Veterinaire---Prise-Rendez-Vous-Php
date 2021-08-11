<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>

<main class="h-100 w-full flex flex-col items-center">
    <h1 class="text-4xl mt-16">Bienvenue <?= $_SESSION['is_admin'] ?> dans votre espace administration </h1>


    <!-- #region : Les rendez-vous déja réservés par un client  -->
        <h2 class="text-2xl my-16"> Mes rendez-vous </h2>

        <div class="mes_rendezVous font-bold text-xl">
            <tbody>
                    <?php foreach ($this->oRdvs as $rdv): ?>
                        <tr>
                            <th><?= dateToFrench($rdv->jour,'l j F Y') ?></th>
                            de
                            <th><?= date('H:i', strtotime($rdv->heureDebut)) ?></th>
                            à
                            <th><?= date('H:i', strtotime($rdv->heureFin)) ?></th>
                            h.
                            <br><br>
                        </tr>
                    <?php endforeach ?>
            </tbody>
        </div>
    <!-- #endregion  -->

    <!-- #region : Les horaires maximales que le vétérinaire s'est attribué -->
        <h2 class="text-2xl mt-16"> Mes horaires </h2>

        <div class="mes_horaires">

            <tbody>
                <?php foreach ($this->oHoraires as $oHoraire): ?>
                    <tr>
                        <th><?= dateToFrench($oHoraire->jour,'l j F Y') ?></th>
                        <th><?= $oHoraire->heureDebut ?></th>
                        <th><?= $oHoraire->heureFin ?></th>
                        <br>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </div>
    <!-- #endregion -->

    <!-- #region : Le vétérinaire déclare les horaires de sa semaine  -->

        <h2 class="text-2xl mt-16"> Declarer mes  6 prochain jours </h2>

        <div class="declare_horaire_semaine">

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
        
                
            </form>
        </div>
    <!-- #endregion  -->

    <!-- #region : Informations complémentaires -->

        <div class="infos_complementaires">
            mon session['is_admin'] = <?= $_SESSION['is_admin'] ?>;<br>
            mon numero id = <?= $_SESSION['id'][0] ?><br>
            Nombre de vétérinaire dans la clinique : 
                <?php 
                //affiche nombre de vétos dans la clinique
                $int= $this->oNbVeto[0];
                echo htmlspecialchars(strval($int)) ;
                // date sera augmenté pour trouver le 7e jour après
                ?>
        </div>

    <!-- #endregion  -->
   
</main>


<?php require 'inc/footer.php' ?>