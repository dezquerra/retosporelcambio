<?php
class Challenges extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function add($title, $description, $finalMsg, $duration, $dificullty, $points, $feedback, $only)
		{
			$data["title"] = $title;
			$data["description"] = $description;
			$data["duration"] = $duration;
			$data["difficulty"] = $dificullty;
			$data["points"] = $points;
			$data["finalmssg"] = $finalMsg;
			$data["feedback"] = $feedback ? 1 : 0;
			$data["once"] = $only ? 1 : 0;
			
			$this->db->insert('challenges', $data);
			return $this->db->insert_id();
		}
		
		public function update($description, $duration, $impact, $dificullty, $points, $feedback, $only, $id)
		{
			$data["description"] = $description;
			$data["minimumDuration"] = $duration;
			$data["impact"] = $impact;
			$data["difficulty"] = $dificullty;
			$data["ecoPoints"] = $points;
			$data["feedback"] = $feedback ? 1 : 0;
			$data["onlyonce"] = $only ? 1 : 0;
			
			$this->db->where("challengeID", $id);
			$this->db->update("challenges", $data);
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM challenges ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			return array($answer, $answer->num_rows());
		}
		
		public function getAllActive($userID)
		{
			$query = "SELECT * FROM challenges WHERE challengeID in (SELECT challengeID from userchallenge WHERE userID='".$userID."' AND completed=0) ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			return array($answer, $answer->num_rows());
		}
		
		public function getChallenge($id)
		{
			$query = "SELECT * FROM challenges WHERE challengeID='".$id."'";
			$answer = $this->db->query($query);
			
			return $answer->row();
		}
		
		public function getFiltered($filter)
		{
			$query = "SELECT * FROM challenges, challengetags WHERE challenges.challengeID=challengetags.challengeID and challengetags.tagID='".$filter."' ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			return array($answer, $answer->num_rows());
		}
		
		public function getFilteredActive($filter, $userID)
		{
			$main = "SELECT * FROM challenges, challengetags WHERE challenges.challengeID=challengetags.challengeID and challengetags.tagID='".$filter."'";
			$where = "AND challenges.challengeID in (SELECT challengeID from userchallenge WHERE userID='".$userID."' AND completed=0)";
			$query = $main.$where." ORDER BY RAND)";
			$answer = $this->db->query($query);
			
			return array($answer, $answer->num_rows());
		}
		
		public function getNumberOfChallengesByTag($tagID)
		{
			$query = "SELECT COUNT(*) as number FROM challengetags WHERE tagID = '".$tagID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			
			return $row->number;
		}
		
		public function getNumberOfChallenges()
		{
			$query = "SELECT COUNT(*) as number FROM challenges";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			
			return $row->number;
		}
		
		public function getChallengeOpinions($challengeID, $page=0)
		{
			$offset = $page*3;
			$query = "SELECT userchallenge.opinion as opinion, user.username as username FROM userchallenge, user WHERE userchallenge.challengeID = '".$challengeID."' AND userchallenge.userID = user.userID  AND userchallenge.opinion != '' ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			$available = $answer->num_rows();
			
			return array($available, $answer);
		}
		
		public function getRelatedBibliography($tagList, $page=0)
		{
			$where = "WHERE bibliographytags.bibliographyID = bibliography.bibliographyID AND (";
			$i = 0;
			foreach ($tagList->result() as $tag)
			{
				if ($i != 0)
				{
					$where .= "OR bibliographytags.tagID='".$tag->tagID."'";
					
				}
				else
				{
					$where .= "bibliographytags.tagID='".$tag->tagID."'";
					$i++;
				}
			}
			$where .= ")";
			$query = "SELECT DISTINCT bibliography.* FROM bibliographytags, bibliography ". $where;
			$answer = $this->db->query($query);
			
			$available = $answer->num_rows();
			
			return array($available, $answer);
		}
		
		public function getRelatedFilmography($tagList, $page=0)
		{
			$where = "WHERE filmographytags.filmographyID = filmography.filmographyID AND (";
			$i = 0;
			foreach ($tagList->result() as $tag)
			{
				if ($i != 0)
				{
					$where .= "OR filmographytags.tagID='".$tag->tagID."'";
					
				}
				else
				{
					$where .= "filmographytags.tagID='".$tag->tagID."'";
					$i++;
				}
			}
			$where .= ")";
			$query = "SELECT * FROM filmographytags, filmography ". $where;
			$offset = $page*3;
			$answer = $this->db->query($query);
			
			$available = $answer->num_rows();
			
			return array($available, $answer);
		}
		
		public function getUnfinisihedByID($userID, $challengeID)
		{
			$query = "SELECT * FROM userchallenge, challenges WHERE challenges.challengeID=userchallenge.challengeID AND userchallenge.completed = 0 AND userchallenge.challengeID='".$challengeID."' AND userchallenge.userID='".$userID."'";
			$answer = $this->db->query($query);
			
			return $answer->row();
		}
		
		public function accept($challengeID, $userID, $time)
		{
			$data["challengeID"] = $challengeID;
			$data["userID"] = $userID;
			$data["started"] = $time;
			$data["completed"] = 0;
			$data["shared"] = 0;
			
			$this->db->insert('userchallenge', $data);
			return;
		}
		
		public function isInProgress($id, $user, $timeTreshold)
		{
			$query = "SELECT * FROM userchallenge WHERE challengeID = ".$id." AND userID = ".$user." AND DATE(started) < '".$timeTreshold."' AND completed = 0";
			
			$answer = $this->db->query($query);
			if ($answer->num_rows() > 0)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		
		public function getStartedTime($id, $user, $timeTreshold)
		{
			$query = "SELECT * FROM userchallenge WHERE challengeID = ".$id." AND userID = ".$user." AND DATE(started) < '".$timeTreshold."' AND completed = 0";
			
			$answer = $this->db->query($query);
			$row = $answer->row();
			
			return $row->started;
		}
		
		public function getNameFromId($id)
		{
			$query = "SELECT title as name FROM challenges WHERE challengeID = ".$id;
			
			$answer = $this->db->query($query);
			$row = $answer->row();
			
			return $row->name;
		}
}
?>