
<header>
	<nav class="orange">
		<div class="container">
			<div class="nav-wrapper">

				<a href="<?=ROOT_URL?>veto_accueil.html" class="brand-logo">Clinique Veterinaire</a>

				<a href="#" data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>

				<ul class="right hide-on-med-and-down">
					

					<li class="<?php echo ($_GET['a']=="accueil")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_accueil.html">Accueil</a></li>

					<li class="<?php echo ($_GET['a']=="rdv")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_rdv.html">Prendre un Rendez-vous</a></li>

					<li class="<?php echo ($_GET['a']=="veterinaires")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_veterinaires.html">Nos Vétérinaires</a></li>

					<?php if (empty($_SESSION['is_admin']) && empty($_SESSION['is_user'])): ?>
					<li><a href="<?=ROOT_URL?>veto_login.html" class="btn green waves-effect waves-light">Connexion<i class="material-icons right">lock_open</i></a></li>
					<?php endif ?>

				
					<?php if (!empty($_SESSION['is_admin']) || !empty($_SESSION['is_user'])): ?>
					<li><a href="<?=ROOT_URL?>?p=veto&amp;a=logout" class="btn red waves-effect waves-light">Déconnexion<i class="material-icons right">lock_outline</i></a></li>
					<?php endif ?> 
					<!-- il faudra faire une fonction logout dans veto  -->
				</ul>
						
				<ul class="side-nav" id="mobile-menu">

					<li class="<?php echo ($_GET['a']=="accueil")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_accueil.html">Accueil</a></li>
					
					<?php if (empty($_SESSION['is_admin']) && empty($_SESSION['is_user'])): ?>
					<li class="<?php echo ($_GET['a']=="login")?"active" : ""; ?>"><a href="<?=ROOT_URL?>veto_login.html">Connexion</a></li>
					<?php endif ?>

						

					<?php if (!empty($_SESSION['is_admin']) || !empty($_SESSION['is_user'])): ?>
					<li><a href="<?=ROOT_URL?>?p=blog&amp;a=logout">Déconnexion</a></li>
					<?php endif ?>
				</ul>

			</div>
		</div>
	</nav>
</header>
