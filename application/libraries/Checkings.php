<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Checkings {
	
	public function __construct()
	{
		$this->CI =& get_instance();
		date_default_timezone_set('Europe/Madrid');
	}
	
	public function callMenu()
	{
		$this->CI->load->library('sessions');
		$id = $this->CI->sessions->checkSession();
		if ($id == -1)
		{
			$this->CI->load->view('top_menu.php');
		}
		else
		{
			$this->CI->load->model("users");
			$data["username"] = $this->CI->users->getUsernameByID($id);
			$data["userID"] = $id;
			list($finished, $succesChallenge) = $this->challenges($id);
			if ($finished)
			{
				$data["succesChallenge"] = $succesChallenge;
			}
			list($newBadges, $awardedBadges) = $this->badges($id);
			if($newBadges)
			{
				$data["newBadges"] = $awardedBadges;
			}
			
			// update last connection
			$lastConnection = $this->CI->users->getLastConnection($id);
			$lastConnection = strtotime($lastConnection);
			if(date('Y-m-d', $lastConnection) != date('Y-m-d',time()))
			{
				$this->CI->users->updateLastConnection($id, date('Y-m-d H:i:s',time()));
			}
			// end update
			
			$this->CI->load->view('top_menu', $data);
			
		}
	}

	public function challenges($userID)
	{
		//Initialitzation
		$completed = FALSE;
		$completeChallenge = NULL;
		
		$this->CI->load->model('users');
		
		$unfinishedChallenges = $this->CI->users->getUnfinishedChallenge($userID);
		foreach ($unfinishedChallenges->result() as $uChallenge)
		{
			if ($uChallenge->duration != 0)
			{
				$duration = ($uChallenge->duration * 3600 *24);
				$started = strtotime($uChallenge->started);
				if ($started + $duration < time())
				{
					//It is finished
					$this->CI->users->finishChallenge($userID, $uChallenge->challengeID, $uChallenge->started);
					$this->CI->users->awardPoints($userID, $uChallenge->points);
					$completed = TRUE;
					$completeChallenge = $uChallenge;
					break;
				}				
			}
		}
		
		return array($completed, $completeChallenge);
	}

    public function badges($userID)
    {
		$newUnlockedBadges = [];
			$i = 0;
				
			$this->CI->load->model('badges');
			//Getting all achievementes
			$allBadges = $this->CI->badges->getAll();
			
			foreach ($allBadges->result() as $badge)
			{
				$currentLvl = $this->CI->badges->getBadgeLvl($userID, $badge->badgeID);
				$modified = false;
				
				if ($badge->name == "Comprometid@")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$acceptedChallenges = $this->CI->badges->getAcceptedChallenges($userID);
					
					if (($currentLvl == 3 && $acceptedChallenges > 99) || ($currentLvl == 2 && $acceptedChallenges > 19) || ($currentLvl == 1 && $acceptedChallenges > 4))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $acceptedChallenges > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				elseif ($badge->name == "Aplicad@")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$completedChallenges = $this->CI->badges->getCompletedChallenges($userID);
					
					if (($currentLvl == 3 && $completedChallenges > 99) || ($currentLvl == 2 && $completedChallenges > 19) || ($currentLvl == 1 && $completedChallenges > 4))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $completedChallenges > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				elseif ($badge->name == "Pratocinador(a)")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$shared = $this->CI->badges->getTimesShared($userID);
					
					if (($currentLvl == 3 && $shared > 99) || ($currentLvl == 2 && $shared > 19) || ($currentLvl == 1 && $shared > 4))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $shared > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				elseif ($badge->name == "Lector(a)" || $badge->name == "Videoaficionad@")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$docs = ($badge->name == "Lector(a)") ? $this->CI->badges->getBooksDownloaded($userID) : $this->CI->badges->getFilmsDownloaded($userID);
					
					if (($currentLvl == 3 && $docs > 19) || ($currentLvl == 2 && $docs > 9) || ($currentLvl == 1 && $docs > 2))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $docs > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				elseif ($badge->name == "Critic@")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$opinions = $this->CI->badges->getOpinions($userID);
					
					if (($currentLvl == 3 && $opinions > 99) || ($currentLvl == 2 && $opinions > 19) || ($currentLvl == 1 && $opinions > 4))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $opinions > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				elseif ($badge->name == "Colaborador(a)")
				{
					if ($currentLvl == $badge->maxlvl)
						continue;
					$help = $this->CI->badges->getCollaborations($userID);
					
					if (($currentLvl == 3 && $help > 19) || ($currentLvl == 2 && $help > 9) || ($currentLvl == 1 && $help > 2))
					{
						$this->CI->badges->upgradeBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
					elseif ($currentLvl == 0 && $help > 0)
					{
						$this->CI->badges->giveBadge($userID, $badge->badgeID);
						$modified = !$modified; 
					}
				}
				
				if($modified)
				{
					$newUnlockedBadges[$i]["name"] = $badge->name;
					$newUnlockedBadges[$i]["lvl"] = $currentLvl + 1;
					$newUnlockedBadges[$i]["img"] = $badge->img;
					$i++;
				}
				//Default case is not takking into account, probably there is a better
				//way to program this but my mind has only find this solution, so here it is
			}
			$newBadges = (empty($newUnlockedBadges)) ? FALSE : TRUE;
			return array($newBadges, $newUnlockedBadges);
    }
}

?>