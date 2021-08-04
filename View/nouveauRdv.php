<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>

<?php 
// Calcule toutes les horaires dispo
$dTimeDebut = $this->date . ' ' . $this->heureDeb;
$dTimeFin = $this->date . ' ' . $this->heureFin;
$creneaux = Fractionner($dTimeDebut, $dTimeFin, 60);
?>


<main class="h-100">
<h1 class="text-4xl flex justify-center m-10">Prendre rendez-vous le  <?= dateToFrench($this->date,'l j F Y') ?></h1>

<div class="container flex flex-col justify-center items-center w-4/6">

<form action="#" method="post" class="w-100 flex flex-col justify-center items-center">

    <label for="creno">Choisissez votre horaire</label>

    <select class="w-2/6" name="creno">
        <?php for($i = 0; $i < count($creneaux); $i++): ?>
            <option value="<?= $creneaux[$i] ?>"><?= $creneaux[$i] ?></option>
        <?php endfor ?>
    </select>

    <hr class="mb-8">
    
    <div class="w-2/6">
        <label for="nom"> Nom : </label>
        <input type="text" name="nom">

        <label for="prenom"> Prenom : </label>
        <input type="text" name="prenom">

        <label for="mail"> Adresse email : </label>
        <input type="email" name="mail">

        <label for="telephone"> N° de téléphone : </label>
        <input type="text" class="mb-24">   
    </div>
    <div class="w-full flex justify-center mt-24">
    <button class="btn" type="submit">Prendre rendez-vous</button>
    </div>
    
</form>
</div>

</main>
<?php require 'inc/footer.php' ?>