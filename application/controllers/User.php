<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function index()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1)
		{
			$this->load->view('top_menu.php');
			$this->load->view('welcome_page');
			$this->load->view('footer');
			return;
		}
		
		$this->load->model("users");
		$this->load->model("badges");

		$data["username"] = $this->users->getUsernameByID($id);
		list($finished, $succesChallenge) = $this->checkings->challenges($id);
		if ($finished)
		{
			$data["succesChallenge"] = $succesChallenge;
		}
		list($newBadges, $awardedBadges) = $this->checkings->badges($id);
		if($newBadges)
		{
			$data["newBadges"] = $awardedBadges;
		}
		$data["userID"] = $id;
		$this->load->view('top_menu', $data);
		
		$userData["info"] = $this->users->getUserInfo($id);
		$totalBadges = $this->badges->getNumberOfBadges();
		$userData["finishedChallenges"] = $this->users->getFinishedChallenges($id);
		$userData["finishedDistinctChallenges"] = $this->users->getDistinctFinishedChallenges($id);
		$userData["currentChallenges"] = $this->users->getActiveChallenges($id);
		list($userBadges, $userData["badges"]) = $this->users->getBadges($id);
		$userData["numberOfBadges"] = $userBadges;
		$userData["totalBadges"]  = $totalBadges;
		$userData["badgesAchieved"] = floor($userBadges / $totalBadges * 100);
		$userData["unwonBadges"] = $this->users->getUnwonBadges($id);
		
		$this->load->view("user_page", $userData);
		$this->load->view('footer');
		
	}
	
	//Only for FB purposes
	//FIXME: I can not share it Fuck off
	public function shareBadge($badgeID, $username)
	{
		$userID = $this->sessions->checkSession();
		if($userID < 1)
		{
			$this->load->view('top_menu');
			$this->load->view('login_page');
			$this->load->view('footer');
		}
		$this->load->model('users');
		$data["username"] = $username;
		$data["badge"] = $this->users->getBadgeById($badgeID, $userID);
		
		$this->load->view('badge_achieved');
	}
	
	//only with share purposes
	public function show($username)
	{
		$this->load->model('users');
		$this->load->model('badges');
		$userID = $this->users->getUserIDByName($username);
		
		$userData["info"] = $this->users->getUserInfo($userID);
		$totalBadges = $this->badges->getNumberOfBadges();
		$userData["finishedChallenges"] = $this->users->getFinishedChallenges($userID);
		$userData["finishedDistinctChallenges"] = $this->users->getDistinctFinishedChallenges($userID);
		$userData["currentChallenges"] = $this->users->getActiveChallenges($userID);
		list($userBadges, $userData["badges"]) = $this->users->getBadges($userID);
		$userData["numberOfBadges"] = $userBadges;
		$userData["totalBadges"]  = $totalBadges;
		$userData["badgesAchieved"] = floor($userBadges / $totalBadges * 100);
		$userData["unwonBadges"] = $this->users->getUnwonBadges($userID);
		
		$this->checkings->callMenu();
		$this->load->view("user_share", $userData);
		$this->load->view('footer');
	}
	
	public function register()
	{
		if(!isset($_POST["username"]))
		{
			$this->load->view("top_menu");
			$this->load->view("register_page");
			$this->load->view('footer');
		}
		else
		{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$second_password = $this->input->post("second_password");
			$mail = $this->input->post("mail");
			
			if(empty($username)|| empty($mail) || empty("password"))
			{
				$data["error"] = "Completa el formulario";
				$this->load->view("top_menu");
				$this->load->view("register_page");
				$this->load->view('footer');
			}
			else
			{
				$this->load->model("users");
				if ($this->users->exist($username))
				{
					$data["error"] = "El nombre de usuario ya está en uso";
					$this->load->view("top_menu");
					$this->load->view("register_page");
					$this->load->view('footer');
				}
				else
				{
					if ($this->users->mail_exist($mail))
					{
						$data["error"] = "El correo electronico ya se encuentra en la base de datos";
						$this->load->view("top_menu");
						$this->load->view("register_page");
						$this->load->view('view');
					}
					else
					{
						if ($password == $second_password)
						{
							$pass = hash("SHA256",$password);
							$shared = TRUE;
							$avatar = base_url("images/avatar/default.png");
							$this->users->register($username, $pass, $mail, $shared, $avatar);
							unset($_POST);
							//NEW MAIL TO TEST
							//Send confirmation email
							$mssg = '<img style="margin: 0 auto;"src="'.base_url('images/logo.png').'" width="400px"/><br/><br/><br/>';
							$mssg .= 'Gracias por registrarte en Retos por el Cambio, contigo estamos más cerca de conseguir el cambio.<br/><br/>';
							$mssg .= 'Tu nombre de usuario es:<b>'.$username.'</b>.<br/> Este es el que debes usar para acceder a la web.<br/>';
							$mssg .= '<a href="'.site_url("User/login").'">Entra y acepta tu primer reto!</a>';
							$this->sendMail($mail, "Gracias por registrarte", $mssg);
							$this->login();
						}
						else
						{
							$data["error"] = "Los passwords no coinciden";
							$this->load->view("top_menu");
							$this->load->view("register_page");
							$this->load->view('footer');
						}
					}
				}
			}
			
		}
	}
	
	public function recover($mail)
	{
		$this->load->model('users');
		$exist = $this->users->mail_exist($mail);
		
		if($exist)
		{
			$newPassword = $this->random_str(6);
			$headers = 'Content-Type: text/html\r\n';
			$mssg = '<html><body>Hola!<br/> No podemos darte la contraseña que teníamos porque por motivos de seguridad ni siquiera nosotros las conocemos.';
			$mssg .= 'Por eso hemos generado una nueva contraseña. Cambiala lo antes posible en el área de usuario, por favor!<br/>';
			$mssg .= '<strong> Nueva contraseña: </strong>'. $newPassword.'</body></html>';
			mail($mail, 'Recuperación de la contraseña',$mssg, $headers);
			
			$newPassword = hash('SHA256', $newPassword);
			$userID = $this->users->getIDFromMail($mail);
			$this->users->updatePassword($userID, $newPassword);
		}
		
		$this->load->view("top_menu");
		$this->load->view("login_page");
		$this->load->view('footer');
	}
	
	public function login()
	{
		if(!isset($_POST["username"]))
		{
			$this->load->view("top_menu");
			$this->load->view("login_page");
			$this->load->view('footer');
		}
		else
		{
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			
			$pass = hash("SHA256", $password);
			
			$this->load->model("users");
			$userID = $this->users->login($username, $pass);
			if ($userID != -1)
			{
				$this->sessions->setSession($userID);
				$menuData["username"] = $this->users->getUsernameByID($userID);
				$menuData["userID"] = $userID;
			}
			else
			{
				$data["error"] =  "Usuario y/o contraseña incorrectos";
			}
			
			if (isset($data))
			{
				$this->load->view("top_menu");
				$this->load->view("login_page", $data);
				$this->load->view('footer');
			}
			else
			{
				$this->load->view("top_menu", $menuData);
				$this->showChallenges($userID);
				$this->load->view('footer');
			}
		}
	}
	
	public function logout()
	{
		$this->sessions->destroySession();
		$this->load->view("top_menu");
		$this->load->view("welcome_page");
		$this->load->view('footer');
	}
	
	///Private functions
	private function showChallenges($id)
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		if (empty($filter))
		{
			list($challenges, $numChallenges) = $this->challenges->getAll();
		}
		else
		{
			$filter = rawurldecode($filter);
			$filterID = $this->tags->getID($filter);
			list($challenges, $numChallenges) = $challenges = $this->challenges->getFiltered($filterID);
		}		
		$tags = $this->tags->getAll();
		//getting challenges info
		foreach ($challenges->result() as $challenge)
		{
			$challengeData["challengesTags"][$challenge->challengeID] = $this->tags->getChallengeBindedTags($challenge->challengeID);
			if ($id != -1)
			{
				$timeTreshold = date('Y-m-d H:i:s', ($challenge->duration * 24 * 3600) + time());
				$inProgress = $this->challenges->isInProgress($challenge->challengeID, $id, $timeTreshold);
				if ($inProgress)
				{
					$started = $this->challenges->getStartedTime($challenge->challengeID, $id, $timeTreshold);
					$lapsed = (time() - strtotime($started)) / (3600*24);
					if ($challenge->duration != 0)
					{
						$challengeData["completed"][$challenge->challengeID] = floor($lapsed/$challenge->duration * 100);
					}
					else
					{
						$challengeData["completed"][$challenge->challengeID] = 100;
					}
				}
				$challengeData["inProgress"][$challenge->challengeID] = $inProgress;
			}
		}
		//getting tags info
		foreach ($tags->result() as $tag)
		{
			$challengeData["tag"][$tag->tagID]["name"] = $tag->name;
			$challengeData["tag"][$tag->tagID]["color"] = $tag->color;
			$challengeData["tag"][$tag->tagID]["img"] = $tag->img;
			$challengeData["tag"][$tag->tagID]["numChallenges"] = $this->challenges->getNumberOfChallengesByTag($tag->tagID);
		}
		$challengeData["tag"][-1]["name"] = "todos";
		$challengeData["tag"][-1]["numChallenges"] = $this->challenges->getNumberOfChallenges();
		
		$challengeData["challenges"] = $challenges;
		$challengeData["numChallenges"] = $numChallenges;
		
		$this->load->view('show_challenges', $challengeData);
	}
		
	private function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}
	
	private function sendMail($to, $topic, $mssg)
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'From: Retos por el Cambio <contacto@retosporelcambio.es>' . "\r\n";
		$finalMssg = "<html><head><style>
		body {
			font-size: 17px;
			font-family: 'Dosis', sans-serif;
		}
		a {
			color: #f48b52;
			text-decoration: none;
		}
		
		h1, h2, h3, h4 {
			font-family: 'Sue Ellen Francisco', cursive;
			color: #f48b52;
		}
		</style></head><body>";
		$finalMssg .= $mssg."</body></html>";
		mail($to, $topic,$mssg, $headers);
	}
	
}
?>
