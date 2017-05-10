<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {
	
	public function index($active='')
	{
		$id = $this->sessions->checkSession();
		if ($id == -1 || $id != 4)
		{
			$this->load->view('top_menu.php');
			$this->load->view('welcome_page');
			return;
		}
		
		$cmsData["active"] = $active;
		
		$this->load->model("users");
		$data["username"] = $this->users->getUsernameByID($id);
		$this->load->view('top_menu', $data);
		$this->load->view('cms_welcome', $cmsData);
	}
	
	public function statistics()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1 || $id != 4)
		{
			$this->load->view('top_menu.php');
			$this->load->view('welcome_page');
			return;
		}
		
		/** 
		*	Checking inactive users and sending mails
		**/
		$inactiveUsers = $this->warnInactiveUsers();
		$halfChallenges = $this->warnActiveChallenges();
		$endChallenges = $this->warnFinishedChallenges();
		
		$top3 = $this->top3();
		
		$this->load->model('statistics');
		
		$statisticsData["top3"] = $top3;
		$statisticsData["registeredUsers"] = $this->statistics->getRegisteredUsers();
		$statisticsData["currentChallenges"] = $this->statistics->getCurrentChallenges();
		$statisticsData["allChallenges"] = $this->statistics->getNumberOfChallenges();
		$statisticsData["sharedChallenges"] = $this->statistics->getSharedChallenges();
		$statisticsData["Opinions"] = $this->statistics->getOpinions();
		$statisticsData["booksDownloads"] = $this->statistics->getBooksDownloads();
		$statisticsData["totalBooks"] = $this->statistics->getBooks();
		$statisticsData["filmsDownloads"] = $this->statistics->getFilmsDownloads();
		$statisticsData["totalFilms"] = $this->statistics->getFilms();
		$statisticsData["sendedEmails"] = $inactiveUsers + $halfChallenges + $endChallenges;
		
		/**
		* Get details of people contacting to the app
		**/
		$statisticsData["ContactsInfo"] = $this->statistics->getContactInfo();
		
		$this->load->model('users');
		$data["username"] = $this->users->getUsernameByID($id);
		$this->load->view('top_menu', $data);
		$this->load->view('statistics', $statisticsData);
	}
	
	
	public function addThanks()
	{
		$this->load->model('frontends');
		
		$name = $this->input->post('name');
		$reason = $this->input->post('reason');
		$this->frontends->setThanks($name, $reason);
		
		$this->index('thanks');
	}
	
	/**
		Private functions, the main aim of this functions is to automate some necessary processes for all users
		like send mails to every user with a finished challenge or similar	
	*/
	
	private function warnInactiveUsers()
	{
		$warned = 0;
		$this->load->model('statistics');
		
		//TIME TRESHOLD: how many days can a user be inactive without warning
		$DAYS = 20;
		$timeTreshold = date('Y-m-d H:i:s' ,time() - ($DAYS*3600*24));
		//-------------
		
		$inactiveUsers = $this->statistics->getInactiveUsers($timeTreshold);
		$warned = $inactiveUsers->num_rows();
		if ($warned > 0)
		{
			//Prepare the mail
			$topic = 'Te acuerdas de retos por el cambio?';
			$mssg = ' te hechamos de menos.<br/>En Retos por el Cambio hace mucho que no te vemos y es una lástima, porque es el esfuerzo de gente como tu';
			$mssg .= 'el que hace posible que nos movamos hacia un mundo mejor. <br/> Por que no te pasas por <a href="'.site_url().'">Retos por el Cambio</a> y aceptas algun reto?<br/>';
			$mssg .= ' <h3>Tu esfuerzo es muy importante para nosotros y tu ejemplo lo es aún más para los demás.</h3>';
			//Send the email to users
			foreach ($inactiveUsers->result() as $iUser)
			{
				$finalMssg = $iUser->username.$mssg;
				$this->sendMail($iUser->mail, $topic, $finalMssg);
				$this->statistics->updateNotified($iUser->userID);
			}
		}
		
		return $warned;
	}
	
	private function warnActiveChallenges()
	{
		$this->load->model('statistics');
		$this->load->model('challenges');
		
		$warned = 0;

		//preparing the message
		$topic = '¡Buen trabajo!';
		
		//getting all challenges
		$allChallenges = $this->challenges->getAll();
		foreach ($allChallenges[0]->result() as $challenge)
		{
				if ($challenge->duration == 0)
					continue;
				$duration = floor($challenge->duration/2) - 1; //le restamos 1 porque haremos una comparación de estrictamente menor
				$remaining = $challenge->duration - floor($challenge->duration/2);
				$timeTreshold = date('Y-m-d H:i:s', time() - ($duration * 24 * 3600));
				$activeChallenges = $this->statistics->getChallengesToNotify($timeTreshold, $challenge->challengeID, 0);
				$warned += $activeChallenges->num_rows();
				if ($activeChallenges->num_rows > 0)
				{
					$mssg = $challenge->middleMessage;
					$finalMssg = '<img style="margin: 0 auto;"src="'.base_url('images/logo.png').'" width="400px"/><br/><br/>';
					$finalMssg .= 'Estás haciendo un gran trabajo con el reto '.$challenge->title.'.<br/><br/>'.$mssg;
					$finalMssg .= 'Muchos ánimos para estos '.$remaining.' días que te quedan. <br/><h3 style="color: #f48b52;"> ¡No abandones ahora!</h3>';
					
					foreach($activeChallenges->result() as $activeChallenge)
					{
						if ($activeChallenge->mailing == 1)
						{
							$this->sendMail($activeChallenge->mail, $topic, $finalMssg);
							$this->statistics->updateMiddleNotified($challenge->challengeID, $activeChallenge->userID, $activeChallenge->started);							
						}
					}	
				}
		}
		
		return $warned;
	}
	
	private function warnFinishedChallenges()
	{
		$this->load->model('statistics');
		$this->load->model('challenges');
		
		$topic = '¡Reto completado!';
		$warned = 0;
			
		$allChallenges = $this->challenges->getAll();
		foreach ($allChallenges[0]->result() as $challenge)
		{
			$duration = $challenge->duration;
			$timeTreshold = date('Y-m-d H:i:s', time() - ($duration * 24 * 3600));
			$activeChallenges = $this->statistics->getChallengesToNotify($timeTreshold, $challenge->challengeID, 1);
			$warned += $activeChallenges->num_rows();
			if ($activeChallenges->num_rows > 0)
			{
				$finalMssg = '<img style="margin: 0 auto;"src="'.base_url('images/logo.png').'" width="400px"/><br/><br/>';
				$finalMssg .= '<h2 style="color:#f48b52; font-family: \'Sue Ellen Francisco\', cursive;">Enhorabuena!</h2> Has completado el reto '.$challenge->title.'.<br/>';
				$finalMssg .= 'Nos encantaría que te pasases por la <a style="color: #f48b52; text-decoration: none;" href="'.site_url().'">web</a> para dejar tu opinión como fuente de inspiración a los demás.<br/>';
				$finalMssg .= ' También sería fantástico que nos enviases un vídeo o audio explicando tu experiencia a nuestro Facebook, estamos muy orgullosos de';
				$finalMssg .= 'poder mostrar todos los retos finalizados<br/>';
				$finalMssg .= '¡Muchas gracias por luchar junto a nosotros por el cambio!';
				foreach ($activeChallenges->result() as $activeChallenge)
				{	
					if ($activeChallenge->mailing == 1)
					{
						$this->sendMail($activeChallenge->mail, $topic, $finalMssg);
						$this->statistics->updateEndNotified($challenge->challengeID, $activeChallenge->userID, $activeChallenge->started);						
					}
				}
			}
		}
		
		return $warned;
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
	
	private function top3()
	{
		$this->load->model('users');
		$this->load->model('statistics');
		
		/* Delete deprecate points */
		$treshold = time() - (24*3600*30*2);
		$this->statistics->removeOldPoints(date('Y-m-d H:i:s',$treshold));
		
		/* foreach user get points */
		$max[0] = 0;
		$max[1] = 0;
		$max[2] = 0;
		$top[0] = '';
		$top[1] = '';
		$top[2] = '';
		$users = $this->users->getAll();
		foreach ($users->result() as $user)
		{
			$points = $this->users->getPoints($user->userID);
			if ($points > $max[0])
			{
				$max[0] = $points;
				$top[0] = ($user->shared == 1) ? $user->username : "Contribuidor Anónimo";
			}
			elseif ($points > $max[1])
			{
				$max[1] = $points;
				$top[1] = ($user->shared == 1) ? $user->username : "Contribuidor Anónimo";
			}
			elseif ($points > $max[2])
			{
				$max[2] = $points;
				$top[2] = ($user->shared == 1) ? $user->username : "Contribuidor Anónimo";
			}
		}
		
		return $top;
	}
}
?>
