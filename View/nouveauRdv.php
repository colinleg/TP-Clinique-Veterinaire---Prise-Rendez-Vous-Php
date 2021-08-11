<?php require 'inc/header.php' ?>
<?php require 'inc/topbar.php' ?>
<?php require 'func/frenchDate.php' ?>
<?php require 'func/fractionner.php' ?>


<input type="text" class="hidden" id="isAdmin" value="<?= $this->newUser ?>">
  <!-- 1 si c'est un nouvel Utilisateur, sinon 0 ( invisible ) -->
<input type="text" class="hidden" id="isUser" value="<?= $this->newUser ?>">

  <!-- Modal Trigger ( invisible ) -->
  <a id="modalBtn" class="modal-trigger hidden" href="#modal1">Modal</a>

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      
      <p>Vous n'êtes pas encore inscrit ? Inscrivez vous gratuitement en 1 minute pour accéder à un suivi personnalisé !</p>

    </div>
    <div class="modal-footer">

      <a href="<?=ROOT_URL?>veto_registration.html" class="modal-close waves-effect waves-green btn-flat">S'inscrire</a>
      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Continuer sans s'inscrire</a>
    </div>
  </div>

<main class="h-100">

<!-- Titre  -->
<h1 class="text-4xl flex justify-center m-10">Prendre rendez-vous le  <?= dateToFrench($this->date,'l j F Y') ?></h1>
<h1 class="text-4xl flex justify-center m-10"> à <?= date('H:i', strtotime($this->heureDebut)) ?></h1>
<div class="container flex flex-col justify-center items-center w-4/6">

<form action="veto_confirmRdv.html" method="post" class="w-100 flex flex-col justify-center items-center my-16">
    <input type="text" class="hidden" name="date" value="<?=$this->date?>">
    <input type="text" class="hidden" name="heureDebut" value="<?=$this->heureDebut?>">
    <input class="hidden" name="date" value="<?= $this->date ?>">


    <hr class="mb-8">
    
    <div class="w-2/6">
        
        <input type="text" name="nom">
        <label for="nom"> Nom </label>
        
        <input type="text" name="prenom">
        <label for="prenom"> Prenom  </label>

        
        <input type="email" name="email">
        <label for="mail"> Adresse email  </label>

        
        <input type="text" class="mb-24" name="telephone">   
        <label for="telephone"> N° de téléphone  </label>

        
        <input type="text" class="mb-12" name="nomAnimal"> 
        <label for="nomAnimal">Nom de l'animal </label><br>
        
     
        <select class="mt-12" name="animal">
       

            <option value="chat">Chat</option>
            <option value="chien">Chien</option>
            <option value="autre">Autre</option>
            
        </select>

        
        <input type="text" name="raceAnimal">
        <label for="raceAnimal">Race de votre animal</label>
        
    </div>
    <div class="w-full flex justify-center mt-24">
    <button class="btn" type="submit">Prendre rendez-vous</button>
    </div>
    
</form>
</div>

</main>

<?php require 'inc/footer.php' ?>

<script>


  let isUser = document.querySelector('#isUser').value;
  let trigger = document.querySelector('#modalBtn');
  console.log(isUser);

  if(isUser == 1 ){
    setTimeout(function(){
      trigger.click();
    },1000)
   
  }

</script>
