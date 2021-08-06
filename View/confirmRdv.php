<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>

<main>
    <?= $this->data['nom'] ?>
    <?= $this->data['telephone'] ?>
    <?= $this->idProp[0];?>
</main>

<?php require 'inc/footer.php' ?>