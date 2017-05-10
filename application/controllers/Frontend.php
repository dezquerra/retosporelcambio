<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {
	
	public function index($countryCode='')
	{
		if($countryCode != '')
		{
			set_cookie("from","ES",2592000);
			$country = 0;
		}
		else
		{
			$ip = $this->getUserIP();
			$country = $this->sessions->checkCountry($ip);
		}
		if($country != 0)
		{
			$this->load->view("warning");
		}
		else
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
			$data["username"] = $this->users->getUsernameByID($id);
			//check finished Challenges
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
			$this->showChallenges($id);
			$this->load->view('footer');
		}
	}
	
	public function opinion()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1)
		{
			$this->load->view('top_menu.php');
			$this->load->view('welcome_page');
			return;
		}
		
		$this->load->model("users");
		$data["username"] = $this->users->getUsernameByID($id);
		
		$challengeID = $this->input->post("challengeID");
		$started = $this->input->post("started");
		$opinion = $this->input->post("opinion");
		
		$this->users->addChallengeOpinion($id, $challengeID, $started, $opinion);
		
		list($finished, $succesChallenge) = $this->checkings->challenges($id);
		if ($finished)
		{
			echo "Reto terminado";
			$data["succesChallenge"] = $succesChallenge;
		}
		list($newBadges, $awardedBadges) = $this->checkings->badges($id);
		if($newBadges)
		{
			$data["newBadges"] = $awardedBadges;
		}
		$data["userID"] = $id;
		$this->load->view('top_menu', $data);
		$this->showChallenges($id);
	}
	
	public function FAQ()
	{
		$this->checkings->callMenu();
		$this->load->model('frontends');
		$data["ifaq"] = $this->frontends->getImportantFAQ();
		$data["faq"] = $this->frontends->getFAQ();
		$this->load->view('faq', $data);
		$this->load->view('footer');
	}
	
	public function contact()
	{
		if (!isset($_POST["name"]))
		{
			$this->checkings->callMenu();
			$this->load->view('contact');
			$this->load->view('footer');			
		}
		else
		{
			$name = $this->input->post('name');
			$mail = $this->input->post('mail');
			$mssg = $this->input->post('message');
			
			$this->load->model('frontends');
			$this->frontends->storeContact($name, $mail, $mssg);
			
			$data['mssg'] = 'Gracias por tu mensaje! Responderemos lo antes posible';
			$this->checkings->callMenu();
			$this->load->view('contact', $data);
			$this->load->view('footer');
			
			unset($_POST);
		}
	}
	
	public function collaborate()
	{
		$this->checkings->callMenu();
		$this->load->view('collaborate');
		$this->load->view('footer');
	}
	
	public function bills()
	{
		$this->checkings->callMenu();
		$this->load->view('bills');
		$this->load->view('footer');
	}
	
	public function thanks()
	{
		$this->checkings->callMenu();
		$this->load->model('frontends');
		list($data["sayThanks"],$data["thanks"]) = $this->frontends->getThanks();
		$this->load->view('thanks', $data);
		$this->load->view('footer');
	}
	
	public function TC()
	{
		$this->checkings->callMenu();
		$this->load->view('tyc');
		$this->load->view('footer');
	}
	
	
	//Private functions
	private function callMenu()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1)
		{
			$this->load->view('top_menu.php');
		}
		else
		{
			$this->load->model("users");
			$data["username"] = $this->users->getUsernameByID($id);
			$this->load->view('top_menu', $data);
			
		}
	}

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
		/*To clean all filters*/
		$challengeData["tag"][-1]["name"] = "todos";
		$challengeData["tag"][-1]["numChallenges"] = $this->challenges->getNumberOfChallenges();
		
		
		$challengeData["challenges"] = $challenges;
		$challengeData["numChallenges"] = $numChallenges;
		$challengeData["userID"] = $id;
		
		$this->load->view('show_challenges', $challengeData);
	}
	
	private function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}
}
?>
