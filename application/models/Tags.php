<?php
class Tags extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		/**
		*	Tag related functions
		**/
		public function add($name, $color, $image)
		{
			$data["name"] = $name;
			$data["color"] = $color;
			$data["img"] = $image;
			
			$this->db->insert('tags', $data);
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM tags";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getID($tag)
		{
			$tagID = -1;
			
			$query = "SELECT tagID FROM tags WHERE name='".$tag."'";
			$answer = $this->db->query($query);
			$row = $answer->row();
			if (isset($row))
			{
				$tagID = $row->tagID;
			}
			
			return $tagID;
		}
		
		/**
		* Bind related functions
		**/
		
		/// Challenges
		public function bindToChallenge($challengeID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$data["challengeID"] = $challengeID;
				$data["tagID"] = $tagID;
				$this->db->insert('challengetags' ,$data);
				return true;
			}
			
			return false;
		}
		
		public function isBindedToChallenge($challengeID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$query = "SELECT * FROM challengetags WHERE challengeID='".$challengeID."' AND tagID='".$tagID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getChallengeBindedTags($challengeID)
		{
			$query = "SELECT * FROM tags, challengetags WHERE tags.tagID = challengetags.tagID AND challengetags.challengeID = '".$challengeID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindChallengeTag($challengeID, $tagID)
		{
			$where["challengeID"] = $challengeID;
			$where["tagID"] = $tagID;
			
			$this->db->delete("challengetags", $where);
		}
		
		/// Bibliography
		public function bindToBibliography($bibliographyID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$data["bibliographyID"] = $bibliographyID;
				$data["tagID"] = $tagID;
				$this->db->insert('bibliographytags' ,$data);
				return true;
			}
			
			return false;
		}	
		
		public function isBindedToBibliography($bibliographyID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$query = "SELECT * FROM bibliographytags WHERE bibliographyID='".$bibliographyID."' AND tagID='".$tagID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getBibliographyBindedTags($bibliographyID)
		{
			$query = "SELECT * FROM tags, bibliographytags WHERE tags.tagID = bibliographytags.tagID AND bibliographytags.bibliographyID = '".$bibliographyID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindBibliographyTag($bibliographyID, $tagID)
		{
			$where["bibliographyID"] = $bibliographyID;
			$where["tagID"] = $tagID;
			
			$this->db->delete("bibliographytags", $where);
		}
		
		///Filmography
		public function bindToFilmography($filmographyID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$data["filmographyID"] = $filmographyID;
				$data["tagID"] = $tagID;
				$this->db->insert('filmographytags' ,$data);
				return true;
			}
			
			return false;
		}	
		
		public function isBindedToFilmography($filmographyID, $tag)
		{
			$tagID = $this->getID($tag);
			if ($tagID != -1)
			{	
				$query = "SELECT * FROM filmographytags WHERE filmographyID='".$filmographyID."' AND tagID='".$tagID."'";
				$answer = $this->db->query($query);
				if ($answer->num_rows() != 0)
					return true;
				else
					return false;
			}
			
			return false;
		}
		
		
		public function getFilmographyBindedTags($filmographyID)
		{
			$query = "SELECT * FROM tags, filmographytags WHERE tags.tagID = filmographytags.tagID AND filmographytags.filmographyID = '".$filmographyID."'";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function unbindFilmographyTag($filmographyID, $tagID)
		{
			$where["filmographyID"] = $filmographyID;
			$where["tagID"] = $tagID;
			
			$this->db->delete("filmographytags", $where);
		}
		
		/**
		* Private functions
		**/

}
?>