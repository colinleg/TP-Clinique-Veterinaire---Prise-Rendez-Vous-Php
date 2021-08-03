<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<main class="h-100 w-full flex flex-col items-center">
    <h1 class="text-4xl mt-16">Bienvenue dans votre espace administration </h1>

    <h2 class="text-2xl mt-16"> Vos derniers dossiers </h2>

    <h2 class="text-2xl mt-16"> Mes rendez vous </h2>

    <div class="mes_rendezVous">

        <tbody>
            
            <?php foreach($this->oRdvs as $oRdv): ?>
                <tr>
                    <th><?= $oRdv->jour ?></th>
                    <th><?= $oRdv->heureDebut ?></th>
                    <th><?= $oRdv->heureFin ?></th>
                </tr>
                
            <?php endforeach?>
            
        </tbody>
    </div>
</main>


<?php require 'inc/footer.php' ?>