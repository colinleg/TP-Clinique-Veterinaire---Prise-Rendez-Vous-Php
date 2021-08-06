<?php

namespace BlogPhp\Controller;

//Si aucun parametre a n'est spécifié dans l'url a = accueil
if (empty($_GET['a'])) {
	$_GET['a'] = 'accueil';
}



class Veto{

    // Propriétés 

    protected $oUtil, $oModel, $oSession;
    private $_iId; 

    // Méthodes 

    public function __construct(){
        if(empty($_SESSION))
            @session_start();

        $this->oUtil = new \BlogPhp\Engine\Util;
        
        $this->oUtil->getModel('Veto');
        $this->oModel = new \BlogPhp\Model\Veto;

        /** Récupère l'identifiant de publication dans le constructeur afin d'éviter la duplication du même code **/
        // $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);
    }

    // accueil.php
    public function accueil(){
        $this->oUtil->getView('accueil');
    }

    // rdv.php
    public function rdv(){
        $this->oUtil->oCrenos = $this->oModel->creneauxDispos();
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

	// nouveauRdv.php
	public function nouveauRdv($aData){

		
			$this->oUtil->date = $aData['jour'];
			$this->oUtil->heureDeb = $aData['heureDebut'];
			$this->oUtil->heureFin = $aData['heureFin'];

			$this->oUtil->getView('nouveauRdv');

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
				// $this->oModel->addRdv($bData);

				$this->oUtil->msgSuccess = 'Votre rendez-vous a bien été enregistré' ;
				$this->oUtil->getView('confirmRdv');
		}
	}

    // veterinaires.php
    public function veterinaires(){
        $this->oUtil->getView('veterinaires');
    }

    // notFound.php
    public function notFound(){
        header('HTTP/1.0 404 Not Found');
        $this->oUtil->getView('notFound');
    }

    // error.php
    public function error(){
        $this->oUtil->getView('error');
    }
    
    // **** Systeme de compte administrateur  ****

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

						$_SESSION['id'] = $this->oModel->getIdVeto($oPseudo);
						header('Location: ' . ROOT_URL . 'veto_accueil.html');
						exit;
					}
					else
					{
						$_SESSION['is_user'] = $oIsAdmin->pseudo; // user est connecté maintenant
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
}

