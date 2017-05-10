<?php
class Filmographies extends CI_Model {

	    public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }
		
		public function add($name, $duration, $year, $description, $src)
		{
			$data["name"] = $name;
			$data["duration"] = $duration;
			$data["year"] = $year;
			$data["description"] = $description;
			$data["location"] = $src;
			
			$this->db->insert('filmography', $data);
			return $this->db->insert_id();
		}
		
		public function update($name, $duration, $year, $src, $topic, $id)
		{
			$data["name"] = $name;
			$data["duration"] = $duration;
			$data["year"] = $year;
			$data["location"] = $src;
			$data["topics"] = $topic;
			
			$this->db->where("filmographyID", $id);
			$this->db->update("filmography", $data);
		}
		
		public function getAll()
		{
			$query = "SELECT * FROM filmography ORDER BY RAND()";
			$answer = $this->db->query($query);
			
			return $answer;
		}
		
		public function getFiltered($filter)
		{
			$query = "SELECT DISTINCT filmography.* FROM filmography, filmographytags, filmographytopics ";
			$where = "WHERE (filmography.filmographyID=filmographytopics.filmographyID AND filmographytopics.topicID='".$filter."') ORDER BY RAND()";
			$answer = $this->db->query($query.$where);
			
			return array($answer->num_rows(),$answer);
		}
		
		public function getNumberOfFilmographyByTag($tagID)
		{
			$query = "SELECT COUNT(*) as number FROM filmographytags WHERE tagID = '".$tagID."'";
			$answer = $this->db->query($query);
			
			$row = $answer->row();
			
			return $row->number;
		}
		
		public function addDownload($id)
		{
			$query = "UPDATE filmography SET downloads=downloads+1 WHERE filmographyID='".$id."'";
			$this->db->query($query);
		}
}
?>