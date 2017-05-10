<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Challenge extends CI_Controller {

///Public functions
	public function index($filter='')
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		if (empty($filter) || $filter == "todos")
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
		$userID = $this->sessions->checkSession();
		if ($userID >= 0)
		{
			$data["userID"] = $userID;
		}
		foreach ($challenges->result() as $challenge)
		{
			$data["challengesTags"][$challenge->challengeID] = $this->tags->getChallengeBindedTags($challenge->challengeID);
			if ($userID != -1)
			{
				$timeTreshold = date('Y-m-d H:i:s', ($challenge->duration * 24 * 3600) + time());
				$inProgress = $this->challenges->isInProgress($challenge->challengeID, $userID, $timeTreshold);
				if ($inProgress)
				{
					$started = $this->challenges->getStartedTime($challenge->challengeID, $userID, $timeTreshold);
					$lapsed = (time() - strtotime($started)) / (3600*24);
					if ($challenge->duration != 0)
					{
						$data["completed"][$challenge->challengeID] = floor($lapsed/$challenge->duration * 100);
					}
					else
					{
						$data["completed"][$challenge->challengeID] = 100;
					}
				}
				$data["inProgress"][$challenge->challengeID] = $inProgress;
			}
			else
			{
				$data["inProgress"][$challenge->challengeID] = FALSE;
			}
		}
		//getting tags info
		foreach ($tags->result() as $tag)
		{
			$data["tag"][$tag->tagID]["name"] = $tag->name;
			$data["tag"][$tag->tagID]["color"] = $tag->color;
			$data["tag"][$tag->tagID]["img"] = $tag->img;
			$data["tag"][$tag->tagID]["numChallenges"] = $this->challenges->getNumberOfChallengesByTag($tag->tagID);
		}
		/*To clean all filters*/
		$data["tag"][-1]["name"] = "todos";
		$data["tag"][-1]["numChallenges"] = $this->challenges->getNumberOfChallenges();
		
		$data["challenges"] = $challenges;
		$data["numChallenges"] = $numChallenges;
		
		$this->checkings->callMenu();
		$this->load->view('show_challenges', $data);
		$this->load->view('footer');
		return;
	}
	
	public function challengesList($filter='')
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		if (empty($filter) || $filter == "todos")
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
		$userID = $this->sessions->checkSession();
		if ($userID >= 0)
		{
			$data["userID"] = $userID;
		}
		foreach ($challenges->result() as $challenge)
		{
			$data["challengesTags"][$challenge->challengeID] = $this->tags->getChallengeBindedTags($challenge->challengeID);
			if ($userID != -1)
			{
				$timeTreshold = date('Y-m-d H:i:s', ($challenge->duration * 24 * 3600) + time());
				$inProgress = $this->challenges->isInProgress($challenge->challengeID, $userID, $timeTreshold);
				if ($inProgress)
				{
					$started = $this->challenges->getStartedTime($challenge->challengeID, $userID, $timeTreshold);
					$lapsed = (time() - strtotime($started)) / (3600*24);
					if ($challenge->duration != 0)
					{
						$data["completed"][$challenge->challengeID] = floor($lapsed/$challenge->duration * 100);
					}
					else
					{
						$data["completed"][$challenge->challengeID] = 100;
					}
				}
				$data["inProgress"][$challenge->challengeID] = $inProgress;
			}
			else
			{
				$data["inProgress"][$challenge->challengeID] = FALSE;
			}
		}
		//getting tags info
		foreach ($tags->result() as $tag)
		{
			$data["tag"][$tag->tagID]["name"] = $tag->name;
			$data["tag"][$tag->tagID]["color"] = $tag->color;
			$data["tag"][$tag->tagID]["img"] = $tag->img;
			$data["tag"][$tag->tagID]["numChallenges"] = $this->challenges->getNumberOfChallengesByTag($tag->tagID);
		}
		/*To clean all filters*/
		$data["tag"][-1]["name"] = "todos";
		$data["tag"][-1]["numChallenges"] = $this->challenges->getNumberOfChallenges();
		
		$data["challenges"] = $challenges;
		$data["numChallenges"] = $numChallenges;
		
		$this->checkings->callMenu();
		$this->load->view('show_challenges_list', $data);
		$this->load->view('footer');
		return;
	}
	
	public function more($id, $mssg='')
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		$data["challenge"] = $this->challenges->getChallenge($id);
		$data["tags"] = $this->tags->getChallengeBindedTags($id);
		
		$userID = $this->sessions->checkSession();
		if ($userID != -1)
		{
			$duration = $data["challenge"]->duration;
			$timeTreshold = date('Y-m-d H:i:s', ($duration * 24 * 3600) + time());
			$inProgress = $this->challenges->isInProgress($id, $userID, $timeTreshold);
			if ($inProgress)
			{
				$started = $this->challenges->getStartedTime($id, $userID, $timeTreshold);
				$lapsed = (time() - strtotime($started)) / (3600*24);
				if ($duration != 0)
				{
					$data["remaining"] = ceil($duration - $lapsed);
					$data["lapsed"] = floor($lapsed);
					$data["progress"] = floor($lapsed/$duration * 100);
				}
				else
				{
					$data["userFinished"] = 1;
				}
			}
			
			$data["inProgress"] = $inProgress;
		} 
		$tagList = $data["tags"];
		list($data["availableOpinions"], $data["opinions"]) = $this->challenges->getChallengeOpinions($id);
		list($data["availableFilmography"], $data["filmography"]) = $this->challenges->getRelatedFilmography($tagList);
		list($data["availableBibliography"], $data["bibliography"]) = $this->challenges->getRelatedBibliography($tagList);
		if ($mssg != '')
		{
			$data["mssg"] = $mssg;
		}
		
		//Get related documentation
		
		$this->checkings->callMenu();
		$this->load->view("show_challenge", $data);
		$this->load->view('footer');
		
		return;
	}
	
	public function active($userID)
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		if (empty($filter))
		{
			list($challenges, $numChallenges) = $this->challenges->getAllActive($userID);
		}
		else
		{
			$filter = rawurldecode($filter);
			$filterID = $this->tags->getID($filter);
			list($challenges, $numChallenges) = $challenges = $this->challenges->getFilteredActive($filterID, $userID);
		}		
		$tags = $this->tags->getAll();
		//getting challenges info
		$userID = $this->sessions->checkSession();
		if ($userID >= 0)
		{
			$data["userID"] = $userID;
		}
		foreach ($challenges->result() as $challenge)
		{
			$data["challengesTags"][$challenge->challengeID] = $this->tags->getChallengeBindedTags($challenge->challengeID);
			$timeTreshold = date('Y-m-d H:i:s', ($challenge->duration * 24 * 3600) + time());
			$started = $this->challenges->getStartedTime($challenge->challengeID, $userID, $timeTreshold);
			$lapsed = (time() - strtotime($started)) / (3600*24);
			if ($challenge->duration != 0)
			{
				$data["completed"][$challenge->challengeID] = floor($lapsed/$challenge->duration * 100);
			}
			else
			{
				$data["completed"][$challenge->challengeID] = 100;
			}
			$data["inProgress"][$challenge->challengeID] = TRUE;
		}
		//getting tags info
		foreach ($tags->result() as $tag)
		{
			$data["tag"][$tag->tagID]["name"] = $tag->name;
			$data["tag"][$tag->tagID]["color"] = $tag->color;
			$data["tag"][$tag->tagID]["img"] = $tag->img;
			$data["tag"][$tag->tagID]["numChallenges"] = $this->challenges->getNumberOfChallengesByTag($tag->tagID);
		}
		$data["challenges"] = $challenges;
		$data["numChallenges"] = $numChallenges;
		$data["activeFlag"] = TRUE;
		
		$this->checkings->callMenu();
		$this->load->view('show_active_challenges', $data);
		$this->load->view('footer');
		return;
	}
	
	public function add()
	{
		$title = $this->input->post("title");
		$description = $this->input->post("description");
		$finalMsg = $this->input->post("final_msg");
		$duration = $this->input->post("duration");
		$dificullty = $this->input->post("dificullty");
		$points = $this->input->post("points");
		$tags = $this->input->post("tags");
		$topics = $this->input->post("topics");
		$feedback = $this->input->post("feedback");
		$continue = $this->input->post("continue");
		$only = $this->input->post("only");
		
		if ($duration == NULL)
			$duration = 0;
		
		if ($description != NULL && $points != NULL && $tags != NULL)
		{
			//Load models
			$this->load->model('challenges');
			$this->load->model('tags');
			$this->load->model('topics');
			
			//Add challenge to the database. The tags will be binded only if they exists
			$challengeID = $this->challenges->add($title, $description, $finalMsg, $duration, $dificullty, $points, $feedback, $only);
			//Add tags
			$tagsArray = explode(",", $tags);
			foreach ($tagsArray as $tag)
			{
				$this->tags->bindToChallenge($challengeID, $tag);
			}
			//Add topics. The topics will be added only if they exists already
			$topicsArray = explode(",", $tags);
			foreach ($topicsArray  as $topic)
			{
				$this->topics->bindToChallenge($challengeID, $topic);
			}
			//if we have to add more tags, continue
			if ($continue)
			{
				unset($_POST);
				//The default view is to add challenges
				$data["active"]="";
				$this->checkings->callMenu();
				$this->load->view('cms_welcome', $data);
				$this->load->view('footer');
			}
			else{
				$data["mssg"] = "Challenges added, correctly";
				$data["active"] = '';
				$this->checkings->callMenu();
				$this->load->view('cms_welcome', $data);
				$this->load->view('footer');
			}
		}
		else
		{
			$data["error"] = 'Por favor, rellena todos los campos';
			$data["active"] = '';
			$this->checkings->callMenu();
			$this->load->view('cms_welcome', $data);
			$this->load->view('footer');
		}
	}
	
	
	public function accept($id)
	{
		$mssg = '';
		$userID = $this->sessions->checkSession();
		if ($userID == -1)
		{
			$data["mssg"] = "<a href='".site_url("User/register")."'>Registrate</a> o accede a tu cuenta antes de aceptar un reto";
			$this->load->view('top_menu.php', $data);
			$this->load->view('login_page');
			$this->load->view('footer');
			return;
		}
		
		$this->load->model("challenges");
		$challenge = $this->challenges->getChallenge($id);
		$timeTreshold = date('Y-m-d H:i:s', ($challenge->duration * 24 * 3600) + time());
		if (!$this->challenges->isInProgress($id, $userID, $timeTreshold))
		{
			$this->challenges->accept($id, $userID, date('Y-m-d H:i:s', time()));
			//TODO: compartelo en facebook
			$challengeName = $challenge->title;
			$internalSrc = "Challenge/more/".$challenge->challengeID;
			$src = site_url($internalSrc);
			$mssg = "Felicidades! Has aceptado el reto ".$challengeName."&nbsp;&nbsp;&nbsp;<a class='link' onclick='shareFunction(\"".site_url("Ajax/updateShareStats")."\",\"".$src."\")'>Compartir en FB</a>";			
		}
		$this->more($id, $mssg);
	}
	
	public function finish($challengeID)
	{
		$mssg = '';
		$userID = $this->sessions->checkSession();
		if ($userID == -1)
		{
			$this->load->view('top_menu.php');
			$this->load->view('login_page');
			$this->load->view('footer');
			return;
		}
		
		$this->load->model("challenges");
		$this->load->model("users");
		
		$userID = $this->sessions->checkSession();
		if ($userID == -1)
		{
			$this->load->view('top_menu.php');
		}
		else
		{
			$challenge = $this->challenges->getUnfinisihedByID($userID, $challengeID);
			
			/* Load top menu. We can not charge it from the library because is a particular situation */
			$data["username"] = $this->users->getUsernameByID($userID);
			$data["succesChallenge"] = $challenge;
			
			list($newBadges, $awardedBadges) = $this->checkings->badges($userID);
			if($newBadges)
			{
				$data["newBadges"] = $awardedBadges;
			}
			$this->load->view('top_menu', $data);
			$this->users->finishChallenge($userID, $challenge->challengeID, $challenge->started);
			$this->users->awardPoints($userID, $challenge->points);
		}
		
		
		/*Show challenge information*/
		$this->load->model("tags");
		
		$moreData["challenge"] = $this->challenges->getChallenge($challengeID);
		$moreData["tags"] = $this->tags->getChallengeBindedTags($challengeID);
		
		$tagList = $moreData["tags"];
		list($moreData["availableOpinions"], $moreData["opinions"]) = $this->challenges->getChallengeOpinions($challengeID);
		list($moreData["availableFilmography"], $moreData["filmography"]) = $this->challenges->getRelatedFilmography($tagList);
		list($moreData["availableBibliography"], $moreData["bibliography"]) = $this->challenges->getRelatedBibliography($tagList);
		if ($mssg != '')
		{
			$data["mssg"] = $mssg;
		}
		
		//Get related documentation
		$this->load->view("show_challenge", $moreData);
		$this->load->view('footer');
		
		return;
		
	}
	
	//TODO: unused
	public function modify()
	{
		$this->load->model("challenges");
		$this->load->model("tags");
		
		$challenges = $this->challenges->getAll();
		$tags = $this->tags->getAll();
		//getting challenges info
		foreach ($challenges->result() as $challenge)
		{
			$data["challengesTags"][$challenge->challengeID] = $this->tags->getChallengeBindedTags($challenge->challengeID);
		}
		//getting tags info
		foreach ($tags->result() as $tag)
		{
			$data["tag"][$tag->tagID]["name"] = $tag->name;
			$data["tag"][$tag->tagID]["color"] = $tag->color;
			$data["tag"][$tag->tagID]["numChallenges"] = $this->challenges->getNumberOfChallengesByTag($tag->tagID);
		}
		$data["challenges"] = $challenges;
		
		$this->load->view("manage_challenges", $data);
	}
	
	
	//TODO: unused
	public function update()
	{
		$id = $this->input->post("challengeID");
		$description = $this->input->post("description");
		$duration = $this->input->post("duration");
		$impact = $this->input->post("impact");
		$dificullty = $this->input->post("dificullty");
		$points = $this->input->post("points");
		$tags = $this->input->post("tags");
		$feedback = $this->input->post("feedback");
		$only = $this->input->post("only");
		
		if ($description != NULL && $duration != NULL && $points != NULL && $tags != NULL)
		{
			$this->load->model('challenges');
			$this->load->model('tags');
			
			$this->challenges->update($description, $duration, $impact, $dificullty, $points, $feedback, $only, $id);
			
			//If a tag was binded but is not in the list we have to delete it
			$bindedTags = $this->tags->getChallengeBindedTags($challengeID);
			foreach ($bindedTags->result() as $bindedTag)
			{
				if (strpos($tags, $bindedTag->name) === FALSE)
					$this->tags->unbindChallengeTag($challengeID, $tagID);
			}
			
			$tagsArray = explode(",", $tags);
			foreach ($tagsArray as $tag)
			{
				//If a tag on the list is not binded we have to bind it
				if ($this->tags->isBindedToChallenge($challengeID, $tag))
					$this->tags->bindToChallenge($challengeID, $tag);
			}
			
			unset($_POST);
			$this->load->view('manage_challenges');
		}
		else
		{
			$data["error"] = 'Por favor, rellena todos los campos';
			$data["active"] = '';
			$this->load->view('manage_challenges', $data);
		}
	}
	
///Only for fb share purposes
public function finished($challengeID, $username)
{
	$this->load->model('challenges');
	
	$data["username"] = $username;
	$data["challenge"] = $this->challenges->getChallenge($challengeID);

	$this->checkings->callMenu();
	$this->load->view('finished_challenge', $data);
	$this->load->view('footer');
}
	
/// Private functions

	private function callMenu()
	{
		$id = $this->sessions->checkSession();
		if ($id == -1)
		{
			$this->load->view('top_menu.php');
			return;
		}
		
		$this->load->model("users");
		$data["username"] = $this->users->getUsernameByID($id);
		$this->load->view('top_menu', $data);
	}
}
?>
