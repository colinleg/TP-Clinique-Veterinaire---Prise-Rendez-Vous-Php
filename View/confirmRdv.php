<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>

<main>

    <h1 class="text-center p-12 text-4xl text-green-600"><?=$this->msgSuccess?></h1>

    <div class="container flex flex-col justify-center items-center">

        <table class="bg-white lg:w-4/6 sm:5/6 border-separate border border-gray-600 mt-32 rounded-lg p-16 ">
        <thead><h2 class="text-2xl font-bold">Récapitulatif</h2></thead>
            <tbody>
                
                <tr>
                    <td class="border border-black">Votre nom : </td>
                    <th class="border border-black"><?= $this->data['nom'] ?></th>
                </tr>

                <tr>
                    <td class="border border-black">Votre numéro de téléphone</td>
                    <th class="border border-black"><?= $this->data['telephone'] ?></th>
                </tr>

                <tr>
                    <td class="border border-black">id du propriétaire :</td>
                    <th class="border border-black"><?= $this->idProp[0];?></th>
                </tr>

            </tbody>
        </table>


    </div>
    
    <p>id Animal = <?= $this->idAnimal[0]?></p>
    
    
</main>

<?php require 'inc/footer.php' ?>