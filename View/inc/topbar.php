
<header>
	<nav class="h-40 w-f flex justify-start bg-blue-300">
		<a class=" w-4/12" href="<?=ROOT_URL?>veto_accueil.html"><img class="h-5/6 ml-10 mt-2" src="../../static/img/chat_chien.svg" alt="chat & chien"></a>
		
		

			
		<ul class="w-7/12  flex justify-around items-center list-none text-4xl">
			<li><a class="text-xl p-16 font-bold" href="<?=ROOT_URL?>veto_accueil.html">Accueil</a></li>

			<li><a class="text-xl py-16 font-bold" href="<?=ROOT_URL?>veto_rdv.html">Rendez-vous</a></li>

			<li><a class="text-xl p-16 font-bold" href="<?=ROOT_URL?>veto_services.html">Nos Services</a></li>

			<?php if (!empty($_SESSION['is_admin'])): ?>
				<li><a class="text-xl p-16 font-bold text-xl text-red-700" href="<?=ROOT_URL?>admin_adminBoard.html?pseudo=<?= $_SESSION['is_admin'] ?>">Admin</a></li>
			<?php endif ?>

			<?php
			if (empty($_SESSION['is_admin']) && empty($_SESSION['is_user'])): ?>
				<li><a href="<?=ROOT_URL?>veto_login.html" class="btn bg-pink-600 waves-effect waves-light">Connexion<i class="material-icons right">lock_open</i></a></li>
			<?php endif ?>

				
			<?php 
			if (!empty($_SESSION['is_admin']) || !empty($_SESSION['is_user'])): ?>
			<li><a href="<?=ROOT_URL?>?p=blog&amp;a=logout" class="btn red waves-effect waves-light">Déconnexion<i class="material-icons right">lock_outline</i></a></li>
			<?php endif ?> 
		
		</ul>
		
				
					
				

				<ul class="side-nav" id="mobile-menu">

					<li class="<?php echo ($_GET['a']=="accueil")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_accueil.html">Accueil</a></li>
					
					<?php if (empty($_SESSION['is_admin']) && empty($_SESSION['is_user'])): ?>
					<li class="<?php echo ($_GET['a']=="login")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_login.html">Connexion</a></li>
					<?php endif ?>

						

					<?php if (!empty($_SESSION['is_admin']) || !empty($_SESSION['is_user'])): ?>
					<li><a href="<?=ROOT_URL?>veto_login.html?p=blog&amp;a=logout">Déconnexion</a></li>
					<?php endif ?>
		
		
	</nav>
</header>
