<?php
class Topics extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		/**
		*	topic related functions
		**/
		public function add($name, $color, $image)
		{
			$data["name"] = $name;
			$data["color"] = $color;
			$data["img"] = $image;
			
			$this->db->insert('topics', $data);
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM topics";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getID($topic)
		{
			$topicID = -1;
			
			$query = "SELECT topicID FROM topics WHERE name='".$topic."'";
			$answer = $this->db->query($query);
			$row = $answer->row();
			if (isset($row))
			{
				$topicID = $row->topicID;
			}
			
			return $topicID;
		}
		
		/**
		* Bind related functions
		**/
		
		/// Challenges
		public function bindToChallenge($challengeID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$data["challengeID"] = $challengeID;
				$data["topicID"] = $topicID;
				$this->db->insert('challengetopics' ,$data);
				return true;
			}
			
			return false;
		}
		
		public function isBindedToChallenge($challengeID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$query = "SELECT * FROM challengetopics WHERE challengeID='".$challengeID."' AND topicID='".$topicID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getChallengeBindedtopics($challengeID)
		{
			$query = "SELECT * FROM topics, challengetopics WHERE topics.topicID = challengetopics.topicID AND challengetopics.challengeID = '".$challengeID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindChallengetopic($challengeID, $topicID)
		{
			$where["challengeID"] = $challengeID;
			$where["topicID"] = $topicID;
			
			$this->db->delete("challengetopics", $where);
		}
		
		/// Bibliography
		public function bindToBibliography($bibliographyID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$data["bibliographyID"] = $bibliographyID;
				$data["topicID"] = $topicID;
				$this->db->insert('bibliographytopics' ,$data);
				return true;
			}
			
			return false;
		}	
		
		public function isBindedToBibliography($bibliographyID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$query = "SELECT * FROM bibliographytopics WHERE bibliographyID='".$bibliographyID."' AND topicID='".$topicID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getBibliographyBindedtopics($bibliographyID)
		{
			$query = "SELECT * FROM topics, bibliographytopics WHERE topics.topicID = bibliographytopics.topicID AND bibliographytopics.bibliographyID = '".$bibliographyID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindBibliographytopic($bibliographyID, $topicID)
		{
			$where["bibliographyID"] = $bibliographyID;
			$where["topicID"] = $topicID;
			
			$this->db->delete("bibliographytopics", $where);
		}
		
		///Filmography
		public function bindToFilmography($filmographyID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$data["filmographyID"] = $filmographyID;
				$data["topicID"] = $topicID;
				$this->db->insert('filmographytopics' ,$data);
				return true;
			}
			
			return false;
		}	
		
		public function isBindedToFilmography($filmographyID, $topic)
		{
			$topicID = $this->getID($topic);
			if ($topicID != -1)
			{	
				$query = "SELECT * FROM filmographytopics WHERE filmographyID='".$filmographyID."' AND topicID='".$topicID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getFilmographyBindedtopics($filmographyID)
		{
			$query = "SELECT * FROM topics, filmographytopics WHERE topics.topicID = filmographytopics.topicID AND filmographytopics.filmographyID = '".$filmographyID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindFilmographytopic($filmographyID, $topicID)
		{
			$where["filmographyID"] = $filmographyID;
			$where["topicID"] = $topicID;
			
			$this->db->delete("filmographytopics", $where);
		}
		
		/**
		* Private functions
		**/

}
?>