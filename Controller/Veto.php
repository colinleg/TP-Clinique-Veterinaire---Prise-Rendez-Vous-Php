<?php

namespace BlogPhp\Controller;

//Si aucun parametre a n'est spécifié dans l'url a = accueil
if (empty($_GET['a'])) {
	$_GET['a'] = 'accueil';
}



class Veto{

    // Propriétés 

    protected $oUtil, $oModel;
    private $_iId; 

    // Méthodes 

    public function __construct(){
        if(empty($_SESSION))
            @session_start();

        $this->oUtil = new \BlogPhp\Engine\Util;
        
        $this->oUtil->getModel('Veto');
        $this->oModel = new \BlogPhp\Model\Veto;

        /** Récupère l'identifiant de publication dans le constructeur afin d'éviter la duplication du même code **/
        $this->_iId = (int) (!empty($_GET['id']) ? $_GET['id'] : 0);
    }

    // accueil.php
    public function accueil(){
        $this->oUtil->getView('accueil');
    }

    // rdv.php
    public function rdv(){
        $this->oUtil->oCrenos = $this->oModel->creneauxDispos();
        foreach($this->oUtil->oCrenos as $oCreno){
        
        }
        $this->oUtil->getView('rdv');
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

    // si admin est connecté return true
	protected function isLogged()
	{
		return !empty($_SESSION['is_admin']);
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

