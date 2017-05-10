<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bibliography extends CI_Controller {
	
	public function index($filter='')
	{
		$this->load->model("bibliographies");
		$this->load->model("tags");
		$this->load->model("topics");
		
		if (!empty($filter))
		{
			$filter = rawurldecode($filter);
			$filterID = $this->topics->getID($filter);
			list($data["availableDocuments"], $data["documents"]) = $this->bibliographies->getFiltered($filterID);
			
			$topics = $this->topics->getAll();
			//getting topics info
			foreach ($topics->result() as $topic)
			{
				$data["topics"][$topic->topicID]["name"] = $topic->name;
				$data["topics"][$topic->topicID]["color"] = $topic->color;
				$data["topics"][$topic->topicID]["img"] = $topic->img;
			}
			$data["flag"] = "book";
	
			$this->checkings->callMenu();
			$this->load->view('show_by_topic', $data);
			$this->load->view('footer');
		}
		else
		{
			$topics = $this->topics->getAll();
			//getting topics info
			foreach ($topics->result() as $topic)
			{
				$data["topics"][$topic->topicID]["name"] = $topic->name;
				$data["topics"][$topic->topicID]["color"] = $topic->color;
				$data["topics"][$topic->topicID]["img"] = $topic->img;
			}
			
			$data['flag'] = 'book';
			
			$this->checkings->callMenu();
			$this->load->view('show_documents', $data);
			$this->load->view('footer');
		}
	}
	
	public function add()
	{
		$name = $this->input->post("name");
		$pages = $this->input->post("pages");
		$author = $this->input->post("author");
		$description = $this->input->post("description");
		$src = $this->input->post("src");
		$topics = $this->input->post("topic");
		$tags = $this->input->post("tags");
		$continue = $this->input->post("continue");
		
		if ($name != NULL && $pages != NULL && $author != NULL && $src != NULL)
		{
			$this->load->model('bibliographies');
			$this->load->model('tags');
			$this->load->model('topics');
			
			//TODO: upload src before add loaction to database
			$bibliographyID = $this->bibliographies->add($name, $pages, $author, $description, $src);
			
			//Adding tags
			$tagsArray = explode(",", $tags);
			foreach ($tagsArray as $tag)
			{
				$this->tags->bindToBibliography($bibliographyID, $tag);
			}
			
			//Adding topics
			$topicsArray = explode(",", $topics);
			foreach ($topicsArray as $topic)
			{
				$this->topics->bindToBibliography($bibliographyID, $topic);
			}
			
			if ($continue)
			{
				unset($_POST);
				$this->checkings->callMenu();
				$data["active"] = 'bibliography';
				$this->load->view('cms_welcome',$data);
				$this->load->view('footer');
			}
			else{
				$this->checkings->callMenu();
				$data["mssg"] = "Challenges added, correctly";
				$this->load->view('cms_welcome', $data);
				$this->load->view('footer');
			}
		}
		else
		{
			$this->checkings->callMenu();
			$data["active"] = 'bibliography';
			$data["error"] = 'Por favor, rellena todos los campos';
			$this->load->view('cms_welcome', $data);
			$this->load->view('footer');
		}
	}
	
	//TODO: check validity
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
	
	//TODO: check validity
	public function update()
	{
		$id = $this->input->post("challengeID");
		$data["description"] = $this->input->post("description");
		$data["minimumDuration"] = $this->input->post("duration");
		$data["impact"] = $this->input->post("impact");
		$data["difficulty"] = $this->input->post("dificullty");
		$data["ecoPoints"] = $this->input->post("points");
		$data["feedback"] = $this->input->post("feedback");
		$daya["onlyonce"] = $this->input->post("only");
		$tags = $this->input->post("tags");
		
		if ($description != NULL && $duration != NULL && $points != NULL && $tags != NULL)
		{
			$this->load->model('challenges');
			$this->load->model('tags');
			
			$this->db->where("challengeID", $id);
			$this->db->update("challenges", $data);
			
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
			$this->load->view('manage_challenges', $data);
		}
	}
	
	//private functions
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
