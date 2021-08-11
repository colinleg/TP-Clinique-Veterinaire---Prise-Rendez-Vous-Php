<?php

namespace BlogPhp\Controller;

//Si aucun parametre a n'est spécifié dans l'url a = accueil
if (empty($_GET['a'])) {
	$_GET['a'] = 'accueil';
}

class Veto{

    #region : Propriétés

    protected $oUtil, $oModel, $oSession;
    private $_iId; 

	#endregion

	#region : Construct
    public function __construct(){
        if(empty($_SESSION))
            @session_start();

        $this->oUtil = new \BlogPhp\Engine\Util;
        
        $this->oUtil->getModel('Veto');
        $this->oModel = new \BlogPhp\Model\Veto;

        /** Récupère l'identifiant de publication dans le constructeur afin d'éviter la duplication du même code **/
        // $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);
    } 

	#endregion
	
	#region : Méthodes par vues

    public function accueil(){
        $this->oUtil->getView('accueil');
    }

    public function rdv(){

		$this->oUtil->dateDispos = $dateDispos = $this->oModel->getDateDispos();
		$i = 0;
		foreach($dateDispos as $dd){
			
			$jour = $dd->jour;
			$this->oUtil->crenos[$i] = $this->oModel->crenoDispos($jour);
			$i++;
		}
        // $this->oUtil->oCrenos = $this->oModel->creneauxDispos($dateDispos);



		if(!empty($_POST['jour']))
		{
			$aData = $_POST;
			$this->nouveauRdv($aData);
		}
		else
		{
			$this->oUtil->getView('rdv');
		}
        
    }

	public function nouveauRdv($aData){

			$this->oUtil->date = $aData['jour'];
			$this->oUtil->heureDebut = $aData['submit'];

		if(!empty($_SESSION['is_user'])){
			$this->oUtil->pseudo = $_SESSION['is_user'];
			// pour l'affichage du modal dans la view
			$this->oUtil->newUser = 0;

			$this->oUtil->getView('nouveauRdv');
		}else{
			// pour l'affichage du modal dans la view
			$this->oUtil->newUser = 1;
			
			$this->oUtil->getView('nouveauRdv');
		}
			
	}
 
	public function confirmRdv(){
		if(!empty($_POST)){
			
				
				$this->oUtil->data = $_POST;

				$data = $_POST;
				

				$this->oModel->addProprietaire($data); 

				// On recupère l'id propriétaire AI qui vient d'être crée pour l'envoyer sur Animal
				$data['idProp'] = $this->oModel->getIdPropByData($data);
				$this->oUtil->idProp = $data['idProp'];
			
				$this->oModel->addAnimal($data);

				//Recupère l'id de l'animal ---> utile pour les tables chat ou chien 
				$data['idAnimal'] = $this->oModel->getIdAnimal($data);

				$this->oUtil->idAnimal= $data['idAnimal'];
				// Toggle la colonne "Occupe" de horaireRdv
			

				$isOk = $this->oModel->addRdv($data);
				
				// On se servira de data['idAnimal'] et data['raceAnimal'] qui est une string pour l'instant 
				if($data['animal'] == 'chat'){
					if($data['raceAnimal'] !== NULL){
						$this->oModel->addRaceChat($data['raceAnimal']);
						$data['idRaceAnimal'] = $this->oModel->getIdRaceChat($data['raceAnimal']);
					}

					$this->oModel->addChat($data);

				} else if ($data['animal']== 'chien'){
					if($data['raceAnimal'] !== NULL){
						$this->oModel->addRaceChien($data['raceAnimal']);
						$data['idRaceAnimal'] = $this->oModel->getIdRaceChien($data['raceAnimal']);
					}
					
					$this->oModel->addChien($data);
				}

				

				if($isOk == 1){
					$this->oUtil->msgSuccess = 'Votre rendez-vous a bien été enregistré' ;
					$this->oUtil->getView('confirmRdv');
				}
				else{
					$this->oUtil->msgSuccess = 'Nous avons eu un problème... Veuillez réessayer ' ;
					$this->oUtil->getView('confirmRdv');
				}
				
		}
	}

    public function services(){
        $this->oUtil->getView('services');
    }

    public function notFound(){
        header('HTTP/1.0 404 Not Found');
        $this->oUtil->getView('notFound');
    }

    public function error(){
        $this->oUtil->getView('error');
    }

	#endregion
    
    #region : Inscription et connexion 

    public function login()
	{
			if ($this->isLogged())
					header('Location: ' . ROOT_URL . 'veto_accueil.html');

			if (isset($_POST['submit']))
			{
				$sEmail = htmlspecialchars(trim($_POST['email']));
				$sPassword = htmlspecialchars(trim($_POST['password']));
				$oIsAdmin = $this->oModel->isAdmin($_POST['email']);

				if (empty($sEmail) || empty($sPassword))
				{
					$this->oUtil->sErrMsg = "Tous les champs n'ont pas été remplis !";
				}
				elseif($this->oModel->login($sEmail, $sPassword) == 0)
				{
					$this->oUtil->sErrMsg = "Identifiant ou mot de passe incorrect!";
				}
				else
				{
					if ($oIsAdmin->admin != null)
					{

						$_SESSION['is_admin'] = $oIsAdmin->pseudo; // Admin est connecté maintenant
						//automatiser l'accès à l'id
						$oPseudo = $oIsAdmin->pseudo;

						//On se reconnecte à la classe Admin, pour avoir accès à la fonction getIdVeto
						$this->oUtil->getModel('Admin');
      					$this->oModel = new \BlogPhp\Model\Admin;


						// On stocke l'idVeterinaire
						$_SESSION['id'] = $this->oModel->getIdVeto($oPseudo);
						header('Location: ' . ROOT_URL . 'veto_accueil.html');
						exit;
					}
					else
					{
						$_SESSION['is_user'] = $oIsAdmin->pseudo; // user est connecté maintenant
						$oPseudo = $oIsAdmin->pseudo;
						$_SESSION['id'] = $this->oModel->getIdUser($oPseudo);
						header('Location: ' . ROOT_URL . 'veto_accueil.html');
						exit;
					}
				}
			} 
			
			$this->oUtil->getView('login');
	}
	
	// set la variable global $oSession qui sera accessible dans la class Admin
	public function setOSession($pseudo){
		$this->oSession = $pseudo;
	}


    // si admin est connecté return true
	protected function isLogged()
	{
		return !empty($_SESSION['is_admin']);
	}

	protected function userIsLogged()
	{
		return !empty($_SESSION['is_user']);
	}

    public function logout()
	{
		if (!$this->isLogged())
			header('Location: blog_accueil.html');

		if (!empty($_SESSION))
		{
			$_SESSION = array();
			session_unset();
			session_destroy();
		}

		// Redirection à la page d'accueil
		header('Location: ' . ROOT_URL);
		exit;
	}


	public function registration()
	{
			if ($this->isLogged())
				header('Location: blog_index.html');

			if (isset($_POST['submit']))
			{
				$sPassword = htmlspecialchars(trim($_POST['password']));
				$sPassword_again = htmlspecialchars(trim($_POST['password_again']));
				$sEmail = htmlspecialchars(trim($_POST['email']));
				$sPseudo = htmlspecialchars(trim($_POST['pseudo']));

				if (empty($sPassword) || empty($sPassword_again))
				{
					$this->oUtil->sErrMsg = "Tous les champs n'ont pas été remplis";
				}

				elseif ($sPassword != $sPassword_again)
				{
					$this->oUtil->sErrMsg = "Les mots de passe sont différents";
				}

				elseif ($this->oModel->emailTaken($sEmail))
				{
					$this->oUtil->sErrMsg = "Cette adresse email est déjà utilisée";
				}

				elseif ($this->oModel->pseudoTaken($sPseudo))
				{
					$this->oUtil->sErrMsg = "Ce pseudo est déjà utilisé";
				}

				else
				{
					$aData = array('email' => $sEmail, 'pseudo' => $sPseudo, 'password' => sha1($sPassword));
					$this->oModel->addUser($aData);
					?> 
					<script>window.location.replace('blog_login.html');</script> 
					<?php
					$this->oUtil->sSuccMsg = 'Votre compte a été créé, vous pouvez maintenant vous connecter'; //ne fonctionne pas 
				}

			}

			$this->oUtil->getView('registration');
	}
	#endregion
}